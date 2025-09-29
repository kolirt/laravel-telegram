<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use Kolirt\Telegram\Request\Request;

trait Runnable
{

    protected array|null $normalized_buttons = [];

    /**
     * @param Bot $bot
     * @param Telegram $telegram
     * @param Model|Chat $chat
     * @param Model|User $user
     * @param Model|BotChatPivot $personal_chat
     * @param string $input
     * @return void
     */
    public function run(
        Bot                $bot,
        Telegram           $telegram,
        Model|Chat         $chat,
        Model|User         $user,
        Model|BotChatPivot $personal_chat,
        string             $input
    ): void
    {
        $buttons = $this->getNormalizedButtons();

        $matched_buttons = $this->path === ''
            ? array_filter($buttons, fn($value, $key) => !str_contains($key, '.'), ARRAY_FILTER_USE_BOTH)
            : array_filter($buttons, fn($value, $key) => $this->path === $key || str_starts_with($key, $this->path . '.'), ARRAY_FILTER_USE_BOTH);

        $matched_button = $matched_buttons[$this->path] ?? null;
        $matched_children = array_filter($matched_buttons, fn($key) => $key !== $this->path, ARRAY_FILTER_USE_KEY);

        $next_button = null;
        foreach ($matched_children as $value) {
            if ($value->getLabel() == $input) {
                $next_button = $value;
                break;
            }
        }

        /** handle back and home buttons */
        if (!$next_button && $matched_button) {
            if ($input === $matched_button->getBackButtonLabel()) {
                $parent_path = $matched_button->getParentPath();
                if ($parent_path === '') {
                    $matched_button = null;
                } else {
                    $next_button = $buttons[$parent_path];
                }
            } else if ($input === $matched_button->getHomeButtonLabel()) {
                $matched_button = null;
            }
        }

        /** routing */
        $new_path = '';
        if (
            $next_button &&
            (
                (method_exists($next_button, 'hasChildren') && $next_button->hasChildren()) ||
                (method_exists($next_button, 'hasFallback') && $next_button->hasFallback())
            )
        ) {
            $new_path = $next_button->getName();
        } else if ($matched_button) {
            $new_path = $matched_button->getName();
        }
        $personal_chat->update(['virtual_path' => $new_path]);
        $this->setPath($new_path);

        /** attach keyboard */
        if (
            $next_button &&
            (
                (method_exists($next_button, 'hasChildren') && $next_button->hasChildren()) ||
                (method_exists($next_button, 'hasFallback') && $next_button->hasFallback())
            )
        ) {
            $telegram->attachReplyKeyboardMarkupObject(
                $next_button->getKeyboard()->renderReplyKeyboardMarkup()
            );
        } else if ($matched_button) {
            if ($this->path !== '') {
                if (
                    (method_exists($matched_button, 'hasChildren') && $matched_button->hasChildren()) ||
                    (method_exists($matched_button, 'hasFallback') && $matched_button->hasFallback())
                ) {
                    $telegram->attachReplyKeyboardMarkupObject(
                        $matched_button->getKeyboard()->renderReplyKeyboardMarkup()
                    );
                } else {
                    $parent_path = $matched_button->getParentPath();
                    if ($parent_path === '') {
                        $telegram->attachReplyKeyboardMarkupObject(
                            $this->renderReplyKeyboardMarkup()
                        );
                    } else {
                        $telegram->attachReplyKeyboardMarkupObject(
                            $buttons[$parent_path]->getKeyboard()->renderReplyKeyboardMarkup()
                        );
                    }
                }
            }
        } else {
            $telegram->attachReplyKeyboardMarkupObject(
                $this->renderReplyKeyboardMarkup()
            );
        }

        $request = $this->makeRequest($input);

        /** run handler */
        if ($next_button) {
            $next_button->run(
                request: $request,
                bot: $bot,
                telegram: $telegram,
                chat: $chat,
                user: $user,
                personal_chat: $personal_chat
            );
        } else if ($matched_button) {
            $matched_button->run(
                request: $request,
                bot: $bot,
                telegram: $telegram,
                chat: $chat,
                user: $user,
                personal_chat: $personal_chat,
                fallback: method_exists($matched_button, 'hasFallback') && $matched_button->hasFallback()
            );
        } else {
            $this->runDefault(
                bot: $bot,
                telegram: $telegram,
                chat: $chat,
                user: $user,
                personal_chat: $personal_chat,
                input: $input
            );
        }
    }

    public function getNormalizedButtons(): array
    {
        if ($this->normalized_buttons) {
            return $this->normalized_buttons;
        }

        $buttons = [];

        foreach ($this->lines as $line) {
            foreach ($line->getButtons() as $button) {
                if (method_exists($button, 'getName')) {
                    $buttons[$button->getName()] = $button;

                    if (method_exists($button, 'hasChildren') && $button->hasChildren()) {
                        foreach ($button->getKeyboard()->getNormalizedButtons() as $value) {
                            $buttons[$value->getName()] = $value;
                        }
                    }
                }
            }
        }

        return $this->normalized_buttons = $buttons;
    }

    protected function makeRequest($input)
    {
        return new Request(
            input: $input
        );
    }

    public function reload(
        Bot                $bot,
        Telegram           $telegram,
        Model|Chat         $chat,
        Model|User         $user,
        Model|BotChatPivot $personal_chat
    )
    {
        $telegram->attachReplyKeyboardMarkupObject(
            $this->renderReplyKeyboardMarkup()
        );

        $this->runDefault(
            bot: $bot,
            telegram: $telegram,
            chat: $chat,
            user: $user,
            personal_chat: $personal_chat,
            input: ''
        );
    }

}
