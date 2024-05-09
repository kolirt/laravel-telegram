<?php

namespace Kolirt\Telegram\Config;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Command\CommandBuildable;
use Kolirt\Telegram\Config\Keyboard\KeyboardBuilderable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

class Bot
{

    use CommandBuildable, KeyboardBuilderable;

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
         * @var Chat|null $chat_model
         * @var User|null $user_model
         * @var BotChatPivot|null $bot_chat_pivot_model
         */
        [$chat_model, $user_model, $bot_chat_pivot_model] = $this->saveData($context);

        /** Commands */
        if ($context->message && $this->command_builder->isCommand($context->message->text)) {
            $segments = explode(' ', $context->message->text, 2);
            $command_name = str_replace('/', '', $segments[0]);

            if ($this->command_builder->isStartCommand($command_name)) {
                $reply_keyboard_markup_object = $this->keyboard_builder->renderReplyKeyboardMarkup();
                $telegram->attachReplyKeyboardMarkupObject($reply_keyboard_markup_object);
                // TODO: need reset virtual_router_state
            }

            $args = $segments[1] ?? '';

            $command = $this->command_builder->getCommand($command_name);
            if ($command) {
                $command->setBot($this);
                $command->setTelegram($telegram);
                $command->setContext($context);
                $command->setChat($chat_model);
                $command->setUser($user_model);
                $command->run($args);
            }
        }

        /** Virtual routes */
        /*if ($context->message && $this->hasVirtualRoutes()) {
            $router = $this->virtual_router;
//            $router->normalize();
            dd($router);
            $router->setPath($bot_chat_pivot_model->virtual_router_state ?? '');

            $text = $context->message->text ?? '';
            $route = $this->virtual_router->getRoute($text);

            dd(
                $context,
                $route
            );
        }*/
    }

    /**
     * @param UpdateType $context
     *
     * @return array [Chat|null, User|null, BotChatPivot|null]
     */
    private function saveData(UpdateType $context): array
    {
        $chat_model = null;
        $user_model = null;
        $pivot_model = null;

        if ($context->message) {
            $message = $context->message;

            if ($message->chat) {
                $chat_model = config('telegram.models.chat.model')::updateOrCreate(
                    ['id' => $message->chat->id],
                    (array)$message->chat
                );

                if ($message->from) {
                    $user_model = config('telegram.models.user.model')::updateOrCreate(
                        ['id' => $message->from->id],
                        [
                            ...(array)$message->from,
                            'chat_id' => $chat_model->id
                        ]
                    );
                }
            }
        }

        if ($chat_model) {
            $pivot_model = config('telegram.models.bot_chat_pivot.model')::query()->updateOrCreate([
                'bot_id' => $this->model->id,
                'chat_id' => $chat_model->id
            ], [
                'last_activity_at' => now()
            ]);
        }

        return [$chat_model, $user_model, $pivot_model];
    }

}