<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Config\Keyboard\Buttons\Traits\Childrenable;
use Kolirt\Telegram\Config\Keyboard\Configuration\Traits\Configurable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use ReflectionMethod;

class KeyboardTextButton extends BaseKeyboardButton
{

    use Childrenable;

    use Configurable {
        Configurable::__construct as private __configurable_construct;
    }

    public function __construct(
        protected string            $name,
        protected string|array      $handler,
        protected string            $label,
        protected string|array|null $fallback_handler = null,

        bool                        $lined_back_and_home_buttons = false,
        bool                        $reverse_back_and_home_buttons = false,
        string                      $back_button_label = 'default',
        bool                        $home_button_enabled = false,
        string                      $home_button_label = 'default',
    )
    {
        $this->__configurable_construct(
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,
            back_button_label: $back_button_label,
            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );
    }

    public function hasFallback()
    {
        return !empty($this->fallback_handler);
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel()
        );
    }

    public function run(
        Bot          $bot,
        Telegram     $telegram,
        UpdateType   $context,
        Chat         $chat_model,
        User         $user_model,
        BotChatPivot $bot_chat_pivot_model,
        string       $input,
        bool         $fallback = false
    )
    {
        if ($fallback) {
            $class = is_array($this->fallback_handler) ? $this->fallback_handler[0] : $this->fallback_handler;
            $method = is_array($this->fallback_handler) ? $this->fallback_handler[1] : '__invoke';
        } else {
            $class = is_array($this->handler) ? $this->handler[0] : $this->handler;
            $method = is_array($this->handler) ? $this->handler[1] : '__invoke';
        }
        $params = [];

        $handler = new $class(
            $bot,
            $telegram,
            $context,
            $chat_model,
            $user_model
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}
