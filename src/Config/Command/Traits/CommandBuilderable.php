<?php

namespace Kolirt\Telegram\Config\Command\Traits;

use Closure;
use Kolirt\Telegram\Config\Command\CommandBuilder;
use ReflectionFunction;

trait CommandBuilderable
{

    protected ?CommandBuilder $command_builder;
    protected ?Closure $command_builder_closure;

    public function commands(Closure $closure): self
    {
        $this->command_builder_closure = $closure;
        return $this;
    }

    public function getCommandBuilder(): CommandBuilder|null
    {
        if (!empty($this->command_builder)) {
            return $this->command_builder;
        }

        if (
            $fn = $this->command_builder_closure
        ) {
            $this->command_builder = new CommandBuilder;

            $args = [];

            $ref = new ReflectionFunction($fn);
            $ref_params = $ref->getParameters();
            foreach ($ref_params as $ref_param) {
                $name = $ref_param->getType()->getName();

                switch ($name) {
                    case CommandBuilder::class:
                        $args[] = $this->command_builder;
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
            return $this->command_builder;
        }

        return null;
    }
}
