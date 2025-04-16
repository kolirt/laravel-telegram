<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

use Closure;
use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;

trait KeyboardBuilderable
{

    protected Closure|null $keyboard_builder;

    public function keyboard(Closure $fn): self
    {
        $this->keyboard_builder = $fn;
        return $this;
    }

    public function getKeyboardBuilder(): KeyboardBuilder|null
    {
        if ($this->keyboard_builder) {
            $keyboard_builder = new KeyboardBuilder;
            $fn = $this->keyboard_builder;

            $args = [];

            $ref = new \ReflectionFunction($fn);
            $ref_params = $ref->getParameters();
            foreach ($ref_params as $ref_param) {
                $name = $ref_param->getType()->getName();

                switch ($name) {
                    case KeyboardBuilder::class:
                        $args[] = $keyboard_builder;
                        break;
                    case config('telegram.models.bot.model'):
                        $args[] = $this->model;
                        break;
                    case config('telegram.models.chat.model'):
                        $args[] = $this->chat_model ?? new $name;
                        break;
                    case config('telegram.models.bot_chat_pivot.model'):
                        $args[] = $this->bot_chat_pivot_model ?? new $name;
                        break;
                    case config('telegram.models.user.model'):
                        $args[] = $this->user_model ?? new $name;
                        break;
                    default:
                        if (class_exists($name)) {
                            $args[] = app($name);
                        }
                }
            }

            $fn(...$args);
            $keyboard_builder->setPath($this->virtual_router_state);
            return $keyboard_builder;
        }

        return null;
    }

}
