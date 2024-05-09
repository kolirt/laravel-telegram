<?php

namespace Kolirt\Telegram\Config;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Traits\CommandBuildable;
use Kolirt\Telegram\Config\Traits\VirtualRouterable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\User;

class Bot
{

    use CommandBuildable, VirtualRouterable;

    private Model $model;


    public function __construct(
        protected string $name,
    )
    {
    }

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function run(Telegram $telegram, UpdateType $context): void
    {
        /**
         * @var Chat|null $chat
         * @var User|null $user
         */
        [$chat, $user] = $this->saveData($context);

        if ($context->message && $this->isCommand($context->message->text)) {
            $segments = explode(' ', $context->message->text, 2);
            $command_name = str_replace('/', '', $segments[0]);

            if ($this->isStartCommand($command_name)) {
                $reply_keyboard_markup_object = $this->virtual_router->renderReplyKeyboardMarkup();
                if ($reply_keyboard_markup_object) {
                    $telegram->attachReplyKeyboardMarkupObject($reply_keyboard_markup_object);
                }
                // TODO: need reset virtual_router_state
            }

            $args = $segments[1] ?? '';

            $command = $this->command_builder->getCommand($command_name);
            if ($command) {
                $command->setBot($this);
                $command->setTelegram($telegram);
                $command->setContext($context);
                $command->setChat($chat);
                $command->setUser($user);
                $command->run($args);
            }
        }

// dd($context);
    }

    private function saveData(UpdateType $context): array
    {
        $chat = null;
        $user = null;

        if ($context->message) {
            $message = $context->message;

            if ($message->chat) {
                $chat = config('telegram.models.chat.model')::updateOrCreate(
                    ['id' => $message->chat->id],
                    (array)$message->chat
                );

                if ($message->from) {
                    $user = config('telegram.models.user.model')::updateOrCreate(
                        ['id' => $message->from->id],
                        [
                            ...(array)$message->from,
                            'chat_id' => $chat->id
                        ]
                    );
                }
            }
        }

        if ($chat && $user) {
            config('telegram.models.bot_chat_pivot.model')::query()->updateOrCreate([
                'bot_id' => $this->model->id,
                'chat_id' => $chat->id
            ], [
                'last_activity_at' => now()
            ]);
        }

        return [$chat, $user];
    }

}