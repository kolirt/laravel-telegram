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

    public function addToPath(string $path): self
    {
        $this->path = $this->path !== '' ? $this->path . '.' . $path : $path;
        return $this;
    }

}
