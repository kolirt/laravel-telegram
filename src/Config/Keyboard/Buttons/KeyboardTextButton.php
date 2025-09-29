<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Config\Keyboard\Buttons\Traits\Childrenable;
use Kolirt\Telegram\Config\Keyboard\Navigation\Traits\Navigationable;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Helpers\Run;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use Kolirt\Telegram\Request\Request;

class KeyboardTextButton extends BaseKeyboardButton
{

    use Childrenable;

    use Navigationable {
        Navigationable::__construct as private __configurable_construct;
    }

    public function __construct(
        protected string            $name,
        protected string            $label,
        protected string|array      $handler,
        protected array             $handler_args = [],
        protected string|array|null $fallback_handler = null,
        protected array             $fallback_handler_args = [],

        bool                        $on_top = false,
        bool                        $lined_back_and_home_buttons = false,
        bool                        $reverse_back_and_home_buttons = false,
        string                      $back_button_label = 'default',
        bool                        $home_button_enabled = false,
        string                      $home_button_label = 'default',
    )
    {
        $this->__configurable_construct(
            on_top: $on_top,
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

    public function getName(): string
    {
        return $this->name;
    }

    public function run(
        Request                 $request,
        Bot                     $bot,
        Telegram                $telegram,
        Model|Chat|null         $chat,
        Model|User|null         $user,
        Model|BotChatPivot|null $personal_chat,
        bool                    $fallback = false
    ): void
    {
        if ($fallback) {
            $class = is_array($this->fallback_handler) ? $this->fallback_handler[0] : $this->fallback_handler;
            $method = is_array($this->fallback_handler) ? $this->fallback_handler[1] : '__invoke';
        } else {
            $class = is_array($this->handler) ? $this->handler[0] : $this->handler;
            $method = is_array($this->handler) ? $this->handler[1] : '__invoke';
        }

        $handler = new $class(
            request: $request,
            bot: $bot,
            telegram: $telegram,
            context: $telegram->update,
            chat: $chat,
            user: $user,
            personal_chat: $personal_chat,
            args: $fallback ? $this->fallback_handler_args : $this->handler_args
        );

        (new Run)->call($handler, $method);
    }
}
