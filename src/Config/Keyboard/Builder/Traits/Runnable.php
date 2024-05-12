<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

trait Runnable
{

    protected function prepareState(): array
    {
        $explode_path = explode('.', $this->path);

        $buttons = [];
        $lines = $this->lines;
        foreach ($explode_path as $index => $name) {
            foreach ($lines as $line) {
                $line_button = $line->getButtonByName($name);
                if ($line_button) {
                    $buttons[] = $line_button;
                    if (count($explode_path) - 1 !== $index && $line_button->hasChildren()) {
                        if (method_exists($line_button, 'hasChildren') && $line_button->hasChildren()) {
                            $lines = $line_button->getKeyboard()->getLines();
                        }
                    }
                    break;
                }
            }
        }

        return $buttons;
    }

    private function normalizeButtons(): array
    {
        $buttons = [];

        foreach ($this->lines as $line) {
            foreach ($line->getButtons() as $button) {
                $buttons[$button->getName()] = $button;

                if (method_exists($button, 'hasChildren') && $button->hasChildren()) {
                    foreach ($button->getKeyboard()->normalizeButtons() as $value) {
                        $buttons[$value->getName()] = $value;
                    }
                }
            }
        }

        return $buttons;
    }

    public function run(
        Bot          $bot,
        Telegram     $telegram,
        UpdateType   $context,
        Chat         $chat_model,
        User         $user_model,
        BotChatPivot $bot_chat_pivot_model,
        string       $input
    )
    {
        $buttons = $this->normalizeButtons();
        $matched_buttons = $this->path === ''
            ? array_filter($buttons, fn($value, $key) => preg_match('/^[\w\d]+$/', $key), ARRAY_FILTER_USE_BOTH)
            : array_filter($buttons, fn($value, $key) => $this->path === $key || preg_match('/^' . $this->path . '\.[\w\d]+$/', $key), ARRAY_FILTER_USE_BOTH);
        $matched_button = array_key_exists($this->path, $matched_buttons) ? $matched_buttons[$this->path] : null;
        $matched_children = array_filter($matched_buttons, fn($key) => str_starts_with($key, $this->path !== '' ? $this->path . '.' : $this->path), ARRAY_FILTER_USE_KEY);
        $next_button = null;
        foreach ($matched_children as $value) {
            if ($value->getLabel() == $input) {
                $next_button = $value;
                break;
            }
        }

        /*dump(
            $this->path,
            $buttons,
            $matched_buttons,
            $matched_button,
            $matched_children,
            $next_button,
            '==========='
        );*/

        dump(
            '$matched_button',
            $matched_button,
            '$next_button',
            $next_button,
            '========='
        );

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
        if ($next_button && method_exists($next_button, 'hasChildren') && $next_button->hasChildren()) {
            $new_path = $next_button->getName();
        } else if ($matched_button) {
            $new_path = $matched_button->getName();
        }
        $bot_chat_pivot_model->update(['virtual_router_state' => $new_path]);
        $this->setPath($new_path);

        /** attach keyboard */
        if ($next_button && method_exists($next_button, 'hasChildren') && $next_button->hasChildren()) {
            $telegram->attachReplyKeyboardMarkupObject(
                $next_button->getKeyboard()->renderReplyKeyboardMarkup()
            );
        } else if ($matched_button) {
            if ($this->path !== '') {
                if (method_exists($matched_button, 'hasChildren') && $matched_button->hasChildren()) {
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


        /** run handler */
        if ($next_button) {
            dump('$next_button', $next_button);
            $next_button->run(
                $bot,
                $telegram,
                $context,
                $chat_model,
                $user_model,
                $bot_chat_pivot_model,
                $input
            );
        } else if ($matched_button) {
            dump('$matched_button', $matched_button);
            $matched_button->run(
                $bot,
                $telegram,
                $context,
                $chat_model,
                $user_model,
                $bot_chat_pivot_model,
                $input
            );
        } else {
            dump('else');
            $this->runDefault(
                $bot,
                $telegram,
                $context,
                $chat_model,
                $user_model,
                $bot_chat_pivot_model,
                $input
            );
        }


        /*if ($next_button) {
            if (method_exists($next_button, 'hasChildren') && $next_button->hasChildren()) {
                $new_path = $next_button->getName();
                $bot_chat_pivot_model->update(['virtual_router_state' => $new_path]);
                $this->setPath($new_path);

                $telegram->attachReplyKeyboardMarkupObject(
                    $next_button->getKeyboard()->renderReplyKeyboardMarkup()
                );
            } else {
                $telegram->attachReplyKeyboardMarkupObject(
                    $this->renderReplyKeyboardMarkup()
                );
            }
        } else if ($matched_button) {
            if ($this->path !== '' && method_exists($matched_button, 'hasChildren') && $matched_button->hasChildren()) {
                // dump('add back');
                $telegram->attachReplyKeyboardMarkupObject(
                    $matched_button->getKeyboard()->renderReplyKeyboardMarkup()
                );
            } else {
                $telegram->attachReplyKeyboardMarkupObject(
                    $this->renderReplyKeyboardMarkup()
                );
            }

            dump('$matched_button', $matched_button);
        } else {
            $new_path = '';
            $bot_chat_pivot_model->update(['virtual_router_state' => $new_path]);
            $this->setPath($new_path);

            dump('else');
            // dump($this->renderReplyKeyboardMarkup());

            $telegram->attachReplyKeyboardMarkupObject(
                $this->renderReplyKeyboardMarkup()
            );
        }*/
    }

}
