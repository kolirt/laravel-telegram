<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

use Closure;
use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;
use ReflectionFunction;

trait KeyboardBuilderable
{

    protected ?KeyboardBuilder $keyboard_builder;
    protected ?Closure $keyboard_builder_closure;

    public function keyboard(Closure $closure): self
    {
        $this->keyboard_builder_closure = $closure;
        return $this;
    }

    protected function reloadKeyboardBuilder(): KeyboardBuilder|null
    {
        $this->keyboard_builder = null;
        return $this->getKeyboardBuilder();
    }

    protected function getKeyboardBuilder(): KeyboardBuilder|null
    {
        if (!empty($this->keyboard_builder)) {
            return $this->keyboard_builder;
        }

        if (
            $fn = $this->keyboard_builder_closure
        ) {
            $this->keyboard_builder = new KeyboardBuilder;

            $args = [];

            $ref = new ReflectionFunction($fn);
            $ref_params = $ref->getParameters();
            foreach ($ref_params as $ref_param) {
                $name = $ref_param->getType()->getName();

                switch ($name) {
                    case KeyboardBuilder::class:
                        $args[] = $this->keyboard_builder;
                        break;
                    case config('telegram.models.bot.model'):
                        $args[] = $this->model;
                        break;
                    case config('telegram.models.chat.model'):
                        $args[] = $this->chat ?? new $name;
                        break;
                    case config('telegram.models.bot_chat_pivot.model'):
                        $args[] = $this->personal_chat ?? new $name;
                        break;
                    case config('telegram.models.user.model'):
                        $args[] = $this->user ?? new $name;
                        break;
                    default:
                        if (class_exists($name)) {
                            $args[] = app($name);
                        }
                }
            }

            $fn(...$args);
            $this->keyboard_builder->setPath($this->getVirtualPath());
            return $this->keyboard_builder;
        }

        return null;
    }
}
