<?php

namespace Kolirt\Telegram\Config\Traits;

use Kolirt\Telegram\Config\VirtualRoute;
use Kolirt\Telegram\Config\VirtualRouter;

trait Childrenable
{

    protected VirtualRouter $virtual_router;

    public function children($fn): self
    {
        $this->virtual_router = new VirtualRouter;
        $this->virtual_router->setPath($this->name);
        $fn($this->virtual_router);
        return $this;
    }


    /**
     * @return VirtualRoute[]
     */
    public function getChildren(): array
    {
        return $this->virtual_router->getRoutes();
    }

    public function hasChildren(): bool
    {
        return !empty($this->virtual_router) && count($this->getChildren()) > 0;
    }

}
