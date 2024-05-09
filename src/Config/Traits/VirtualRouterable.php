<?php

namespace Kolirt\Telegram\Config\Traits;

use Kolirt\Telegram\Config\VirtualRoute;
use Kolirt\Telegram\Config\VirtualRouter;

trait VirtualRouterable
{

    protected VirtualRouter $virtual_router;

    public function virtualRoutes($fn): self
    {
        $this->virtual_router = new VirtualRouter;
        $fn($this->virtual_router);
        return $this;
    }

    /**
     * @return VirtualRoute[]
     */
    public function getVirtualRoutes(): array
    {
        return $this->virtual_router->getRoutes();
    }

    public function hasVirtualRoutes(): bool
    {
        return count($this->getVirtualRoutes()) > 0;
    }

}
