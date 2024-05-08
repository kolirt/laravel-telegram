<?php

namespace Kolirt\Telegram\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kolirt\Telegram\Config\Traits\Backable;
use Kolirt\Telegram\Config\Traits\Cancelable;
use Kolirt\Telegram\Config\Traits\Commandable;
use Kolirt\Telegram\Config\Traits\Routable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\TelegramChat;
use Kolirt\Telegram\Models\TelegramUser;

class TelegramBotConfig
{

    use Commandable, Routable;
    use Backable, Cancelable;

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

    public function run(Telegram $telegram,UpdateType $context): void
    {
        /**
         * @var TelegramChat|null $chat
         * @var TelegramUser|null $user
         */
        [$chat, $user] = $this->save($context);

        if ($context->message && $this->isCommand($context->message->text)) {
            $segments = explode(' ', $context->message->text, 2);
            $command_name = str_replace('/', '', $segments[0]);
            $args = $segments[1] ?? '';

            $command = $this->getCommand($command_name);
            if ($command) {
                $command->setBot($this);
                $command->setTelegram($telegram);
                $command->setContext($context);
                $command->setChat($chat);
                $command->setUser($user);
                $command->run($args);
            }
        }
    }

    private function save(UpdateType $context): array
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
            BotChatPivot::query()->updateOrCreate([
                'bot_id' => $this->model->id,
                'chat_id' => $chat->id
            ], [
                'last_activity_at' => now()
            ]);
        }

        return [$chat, $user];
    }

}
