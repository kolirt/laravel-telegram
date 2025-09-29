<?php

namespace Kolirt\Telegram\Config\Hooks;

use Closure;
use ReflectionFunction;

trait Hookable
{
    protected ?Closure $on_before_start_closure;

    public function onBeforeStart(Closure $closure): self
    {
        $this->on_before_start_closure = $closure;
        return $this;
    }

    protected function beforeStart(): void
    {
        if (
            $this->on_before_start_closure &&
            $this->personal_chat
        ) {
            $fn = $this->on_before_start_closure;

            $args = [];

            $ref = new ReflectionFunction($fn);
            $ref_params = $ref->getParameters();
            foreach ($ref_params as $ref_param) {
                $name = $ref_param->getType()->getName();

                switch ($name) {
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
        }
    }
}
