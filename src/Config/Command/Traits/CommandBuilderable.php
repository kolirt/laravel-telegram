<?php

namespace Kolirt\Telegram\Config\Command\Traits;

use Closure;
use Kolirt\Telegram\Config\Command\CommandBuilder;

trait CommandBuilderable
{

    protected Closure|null $command_builder = null;

    public function commands(Closure $fn): self
    {
        $this->command_builder = $fn;
        return $this;
    }

    public function getCommandBuilder(): CommandBuilder|null
    {
        if ($this->command_builder) {
            $command_builder = new CommandBuilder;
            $fn = $this->command_builder;

            $args = [];

            $ref = new \ReflectionFunction($fn);
            $ref_params = $ref->getParameters();
            foreach ($ref_params as $ref_param) {
                $name = $ref_param->getType()->getName();

                switch ($name) {
                    case CommandBuilder::class:
                        $args[] = $command_builder;
                        break;
                    case config('telegram.models.bot.model'):
                        $args[] = $this->model;
                        break;
                    case config('telegram.models.chat.model'):
                        $args[] = $this->chat_model;
                        break;
                    case config('telegram.models.bot_chat_pivot.model'):
                        $args[] = $this->bot_chat_pivot_model;
                        break;
                    case config('telegram.models.user.model'):
                        $args[] = $this->user_model;
                        break;
                    default:
                        if (class_exists($name)) {
                            $args[] = app($name);
                        }
                }
            }

            $fn(...$args);
            return $command_builder;
        }

        return null;
    }

}
