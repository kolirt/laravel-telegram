<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Buttonable;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Pathable;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Runnable;
use Kolirt\Telegram\Config\Keyboard\Line\KeyboardLine;
use Kolirt\Telegram\Config\Keyboard\Navigation\Traits\Navigationable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use ReflectionMethod;

class KeyboardBuilder
{

    use Navigationable {
        Navigationable::__construct as private __navigation_construct;
    }
    use Buttonable;
    use Pathable;
    use Runnable;

    /** @var KeyboardLine[] */
    protected array $lines = [];

    protected string|array $default_handler;

    public function __construct(
        bool   $on_top = false,
        bool   $lined_back_and_home_buttons = false,
        bool   $reverse_back_and_home_buttons = false,
        string $back_button_label = '🔙 Back',
        bool   $home_button_enabled = false,
        string $home_button_label = '🏘 Home',
    )
    {
        $this->__navigation_construct(
            on_top: $on_top,
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,
            back_button_label: $back_button_label,
            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );
    }

    public function line($fn): void
    {
        $line = new KeyboardLine(
            on_top: $this->navigation->on_top,
            lined_back_and_home_buttons: $this->navigation->lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $this->navigation->reverse_back_and_home_buttons,
            back_button_label: $this->navigation->back_button_label,
            home_button_enabled: $this->navigation->home_button_enabled,
            home_button_label: $this->navigation->home_button_label,
        );
        $line->addToPath($this->path);
        $fn($line);
        $this->lines[] = $line;
    }

    public function defaultHandler(string|array $default_handler): self
    {
        $this->default_handler = $default_handler;
        return $this;
    }

    public function runDefault(
        Bot                $bot,
        Telegram           $telegram,
        Model|Chat         $chat_model,
        Model|User         $user_model,
        Model|BotChatPivot $bot_chat_pivot_model,
        string             $input
    ): void
    {
        if (!$this->default_handler) {
            return;
        }

        $class = is_array($this->default_handler) ? $this->default_handler[0] : $this->default_handler;
        $method = is_array($this->default_handler) ? $this->default_handler[1] : '__invoke';

        $params = [];

        $handler = new $class(
            bot: $bot,
            telegram: $telegram,
            context: $telegram->update,
            chat_model: $chat_model,
            user_model: $user_model,
            bot_chat_pivot_model: $bot_chat_pivot_model
        );

        $ref = new ReflectionMethod($handler, $method);
        $ref_params = $ref->getParameters();
        if (count($ref_params)) {
            $type = $ref->getParameters()[0]->getType();
            if ($type && class_exists($type->getName())) {
                $input = new ($type->getName())($input);
            }
            $params[] = $input;
        }

        call_user_func([$handler, $method], ...$params);
    }

    public function renderReplyKeyboardMarkup(): ReplyKeyboardMarkupType|ReplyKeyboardRemoveType
    {
        if ($this->path === '' && count($this->lines) === 0) {
            return new ReplyKeyboardRemoveType(true);
        }

        $keyboard = array_map(fn(KeyboardLine $line) => $line->render(), $this->lines);

        if ($this->path !== '') {
            if ($this->navigation->lined_back_and_home_buttons && $this->navigation->home_button_enabled) {
                $buttons = [
                    new KeyboardButtonType(
                        text: $this->navigation->back_button_label
                    ),
                    new KeyboardButtonType(
                        text: $this->navigation->home_button_label
                    )
                ];

                $navigation_buttons = $this->navigation->reverse_back_and_home_buttons ? array_reverse($buttons) : $buttons;
                if ($this->navigation->on_top) {
                    $keyboard = [
                        $navigation_buttons,
                        ...$keyboard
                    ];
                } else {
                    $keyboard[] = $navigation_buttons;
                }
            } else {
                $buttons = [
                    [
                        new KeyboardButtonType(
                            text: $this->navigation->back_button_label
                        ),
                    ]
                ];

                if ($this->navigation->home_button_enabled) {
                    $buttons[] = [
                        new KeyboardButtonType(
                            text: $this->navigation->home_button_label
                        )
                    ];
                }

                $buttons = $this->navigation->reverse_back_and_home_buttons ? array_reverse($buttons) : $buttons;

                array_push($keyboard, ...$buttons);
            }
        }

        return new ReplyKeyboardMarkupType(
            keyboard: $keyboard,
            resize_keyboard: true
        );
    }

    public function empty(): bool
    {
        return count($this->lines) === 0;
    }

    public function hasDefaultHandler(): bool
    {
        return (bool)$this->default_handler;
    }

    /**
     * @return KeyboardLine[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

}
