<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

trait Pathable
{

    protected string $path = '';

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

}