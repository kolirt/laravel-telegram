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
                    foreach ($button->getKeyboard()->normalizeButtons() as $key => $value) {
                        $buttons[$button->getName() . '.' . $key] = $value;
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

        dump(
            $this->path,
            $buttons,
            $matched_buttons,
            $matched_button,
            $matched_children,
            $next_button,
            '==========='
        );

        if ($next_button) {
            if (method_exists($next_button, 'hasChildren') && $next_button->hasChildren()) {
                $new_virtual_router_state = $this->path !== ''
                    ? implode('.', [$this->path, $next_button->getName()])
                    : $next_button->getName();
                $bot_chat_pivot_model->update(['virtual_router_state' => $new_virtual_router_state]);

                $telegram->attachReplyKeyboardMarkupObject(
                    $next_button->getKeyboard()->renderReplyKeyboardMarkup()
                );
            }

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
            if ($this->path !== '' && method_exists($matched_button, 'hasChildren') && $matched_button->hasChildren()) {
                $telegram->attachReplyKeyboardMarkupObject(
                    $matched_button->getKeyboard()->renderReplyKeyboardMarkup()
                );
            }

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

            /*$telegram->attachReplyKeyboardMarkupObject(
                $this->renderReplyKeyboardMarkup()
            );

            $this->runDefault(
                $bot,
                $telegram,
                $context,
                $chat_model,
                $user_model,
                $bot_chat_pivot_model,
                $input
            );*/
        }

        die;
// dd($this->path, $input, $matched_button, $matched_children, $next_button);


        $button_path = $this->prepareState();
        if (count($button_path)) {

        } else {
            $button = null;
            foreach ($this->lines as $line) {
                $button = $line->getButtonByLabel($input);
                if ($button) break;
            }

            if ($button) {
                if (method_exists($button, 'hasChildren') && $button->hasChildren()) {
                    $new_virtual_router_state = $this->path !== ''
                        ? implode('.', [$this->path, $button->getName()])
                        : $button->getName();
                    $bot_chat_pivot_model->update(['virtual_router_state' => $new_virtual_router_state]);

                    $telegram->attachReplyKeyboardMarkupObject(
                        $button->getKeyboard()->renderReplyKeyboardMarkup()
                    );
                }

                $button->run(
                    $bot,
                    $telegram,
                    $context,
                    $chat_model,
                    $user_model,
                    $bot_chat_pivot_model,
                    $input
                );
            }
        }

        dd($this, $input, $button_path);

        if ($last) {
            dd($last);

//            $telegram->attachReplyKeyboardMarkupObject()

            $last->run(
                $bot,
                $telegram,
                $context,
                $chat_model,
                $user_model,
                $bot_chat_pivot_model,
                $input
            );
        }
        dd($parent, $last);


        // dump('last_path: ' . $this->path);

        // dump($this->getButton());

        // $current_lines = $this->getLines($this->path);


        // dd($this, $input, $current_lines);


        // dd($this, $virtual_router_state, $input, $current_lines);

        /*$button = $this->getButton($input);
        if ($button) {
            if (method_exists($button, 'hasChildren') && $button->hasChildren()) {
                $new_virtual_router_state = implode('/', [$virtual_router_state, $button->getName()]);
                $bot_chat_pivot_model->update(['virtual_router_state' => $new_virtual_router_state]);
            }

            $button->run(
                $bot,
                $telegram,
                $context,
                $chat_model,
                $user_model,
                $bot_chat_pivot_model,
                $input);
        }*/
    }

}