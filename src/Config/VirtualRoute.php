<?php

namespace Kolirt\Telegram\Config;

class VirtualRoute
{

    public function __construct(
        protected string       $name,
        protected string|array $handler,
        protected string       $label
    )
    {
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
