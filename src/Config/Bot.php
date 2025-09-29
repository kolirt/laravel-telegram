<?php

namespace Kolirt\Telegram\Config;

use Kolirt\Telegram\Config\Command\CommandBuilder;
use Kolirt\Telegram\Config\Command\Traits\CommandBuilderable;
use Kolirt\Telegram\Config\Hooks\Hookable;
use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\KeyboardBuilderable;
use Kolirt\Telegram\Config\VirtualPath\VirtualPathable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Bot as BotModel;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

class Bot
{

    use VirtualPathable;
    use CommandBuilderable;
    use KeyboardBuilderable;
    use Hookable;

    protected BotModel $model;

    protected Chat|null $chat = null;
    protected User|null $user = null;
    protected BotChatPivot|null $personal_chat = null;

    public function __construct(
        protected string $name,
    )
    {
    }

    public function setModel(BotModel $model): void
    {
        $this->model = $model;
    }

    public function run(Telegram $telegram): void
    {
        $this->syncContext($telegram->update);

        $this->beforeStart();

        if (
            $this->chat &&
            $this->user &&
            $this->personal_chat
        ) {
            $this->setVirtualPath($this->personal_chat->virtual_path);
            $text = $telegram->update->message->text ?? '';

            /** @var CommandBuilder $command_builder */
            $command_builder = $this->getCommandBuilder();
            /** @var KeyboardBuilder $keyboard_builder */
            $keyboard_builder = $this->getKeyboardBuilder();

            if (
                /** Commands */
                $telegram->update->message &&
                $command_builder &&
                !$command_builder->empty() &&
                $command_builder->isCommand($text)
            ) {
                $segments = explode(' ', $text, 2);
                $command_name = str_replace('/', '', $segments[0]);

                if (
                    $keyboard_builder &&
                    $command_builder->isStartCommand($command_name)
                ) {
                    $this->resetVirtualPath();
                    $telegram->attachReplyKeyboardMarkupObject(
                        $keyboard_builder->renderReplyKeyboardMarkup()
                    );
                }

                $args = $segments[1] ?? '';

                $command = $command_builder->getCommand($command_name);
                $command?->run(
                    bot: $this,
                    telegram: $telegram,
                    chat: $this->chat,
                    user: $this->user,
                    personal_chat: $this->personal_chat,
                    input: $args
                );

                return;
            }

            if (
                /** Keyboard */
                $telegram->update->message &&
                $keyboard_builder &&
                (!$keyboard_builder->empty() || $keyboard_builder->hasDefaultHandler())
            ) {
                $buttons = $keyboard_builder->getNormalizedButtons();
                $virtual_path = $this->getVirtualPath();

                if (
                    !array_key_exists($virtual_path, $buttons) ||
                    !(
                        (
                            method_exists($buttons[$virtual_path], 'hasChildren') &&
                            $buttons[$virtual_path]->hasChildren()
                        ) ||
                        (
                            method_exists($buttons[$virtual_path], 'hasFallback') &&
                            $buttons[$virtual_path]->hasFallback()
                        )
                    )
                ) {
                    $this->resetVirtualPath();
                }

                $keyboard_builder->run(
                    bot: $this,
                    telegram: $telegram,
                    chat: $this->chat,
                    user: $this->user,
                    personal_chat: $this->personal_chat,
                    input: $text
                );
            }
        }
    }

    /**
     * @param UpdateType $context
     */
    protected function syncContext(UpdateType $context): void
    {
        $chat = null;
        $user = null;
        $pivot_model = null;

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
                            'is_premium' => $message->from->is_premium !== null,
                            'chat_id' => $chat->id
                        ]
                    );
                }
            }
        }

        if ($chat) {
            $pivot_model = config('telegram.models.bot_chat_pivot.model')::query()
                ->updateOrCreate(
                    [
                        'bot_id' => $this->model->id,
                        'chat_id' => $chat->id
                    ],
                    [
                        'last_activity_at' => now(),
                        'blocked_at' => null
                    ]
                );

            /*if ($pivot_model->wasRecentlyCreated) {
                $pivot_model->refresh();
            }*/
        }

        $this->chat = $chat;
        $this->user = $user;
        $this->personal_chat = $pivot_model;
    }

    public function goHome(Telegram $telegram): void
    {
        $this->setVirtualPath($this->personal_chat->virtual_path);

        $keyboard_builder = $this->reloadKeyboardBuilder();

        if (
            $keyboard_builder &&
            (!$keyboard_builder->empty() || $keyboard_builder->hasDefaultHandler())
        ) {
            $keyboard_builder->reload(
                bot: $this,
                telegram: $telegram,
                chat: $this->chat,
                user: $this->user,
                personal_chat: $this->personal_chat
            );
        }
    }

}
