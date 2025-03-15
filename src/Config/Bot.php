<?php

namespace Kolirt\Telegram\Config;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Command\Traits\CommandBuildable;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\KeyboardBuilderable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

class Bot
{

    use CommandBuildable, KeyboardBuilderable;

    protected Model $model;

    protected Model|Chat|null $chat_model = null;
    protected Model|User|null $user_model = null;
    protected Model|BotChatPivot|null $bot_chat_pivot_model = null;
    protected string $virtual_router_state = '';

    public function __construct(
        protected string $name,
    )
    {
    }

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function run(Telegram $telegram): void
    {
        $this->syncContext($telegram->update);

        if (
            $this->chat_model &&
            $this->user_model &&
            $this->bot_chat_pivot_model
        ) {
            $this->setVirtualRouterState($this->bot_chat_pivot_model->virtual_router_state ?? '');
            $text = $telegram->update->message->text ?? '';

            if (
                /** Commands */
                $telegram->update->message &&
                !empty($this->command_builder) &&
                !$this->command_builder->empty() &&
                $this->command_builder->isCommand($text)
            ) {
                $segments = explode(' ', $text, 2);
                $command_name = str_replace('/', '', $segments[0]);

                if ($this->command_builder->isStartCommand($command_name)) {
                    $this->setVirtualRouterState('');
                    $telegram->attachReplyKeyboardMarkupObject(
                        $this->renderReplyKeyboardMarkup()
                    );
                }

                $args = $segments[1] ?? '';

                $command = $this->command_builder->getCommand($command_name);
                $command?->run(
                    bot: $this,
                    telegram: $telegram,
                    chat_model: $this->chat_model,
                    user_model: $this->user_model,
                    bot_chat_pivot_model: $this->bot_chat_pivot_model,
                    input: $args
                );
            } else if (
                /** Keyboard */
                $telegram->update->message &&
                !empty($this->keyboard_builder) &&
                (
                    !$this->keyboard_builder->empty() ||
                    $this->keyboard_builder->hasDefaultHandler()
                )
            ) {
                $buttons = $this->keyboard_builder->getNormalizedButtons();

                if (
                    !array_key_exists($this->virtual_router_state, $buttons) ||
                    !(
                        (
                            method_exists($buttons[$this->virtual_router_state], 'hasChildren') &&
                            $buttons[$this->virtual_router_state]->hasChildren()
                        ) ||
                        (
                            method_exists($buttons[$this->virtual_router_state], 'hasFallback') &&
                            $buttons[$this->virtual_router_state]->hasFallback()
                        )
                    )
                ) {
                    $this->setVirtualRouterState('');
                }

                $this->keyboard_builder->run(
                    bot: $this,
                    telegram: $telegram,
                    chat_model: $this->chat_model,
                    user_model: $this->user_model,
                    bot_chat_pivot_model: $this->bot_chat_pivot_model,
                    input: $text
                );
            }
        }
    }

    /**
     * @param string $state
     * @return void
     */
    protected function setVirtualRouterState(string $state): void
    {
        $this->bot_chat_pivot_model->update(['virtual_router_state' => $state]);
        $this->virtual_router_state = $this->bot_chat_pivot_model->virtual_router_state ?? '';
        $this->keyboard_builder->setPath($this->virtual_router_state);
    }

    /**
     * @param UpdateType $context
     */
    protected function syncContext(UpdateType $context): void
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
                            'is_premium' => $message->from->is_premium !== null,
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
                'last_activity_at' => now(),
                'blocked_at' => null
            ]);

            /*if ($pivot_model->wasRecentlyCreated) {
                $pivot_model->refresh();
            }*/
        }

        $this->chat_model = $chat_model;
        $this->user_model = $user_model;
        $this->bot_chat_pivot_model = $pivot_model;
    }

}
