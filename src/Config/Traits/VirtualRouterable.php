<?php

namespace Kolirt\Telegram\Config\Traits;

use Kolirt\Telegram\Config\VirtualRoute;
use Kolirt\Telegram\Config\VirtualRouter;

trait VirtualRouterable
{

    protected VirtualRouter $virtual_router;

    public function virtual_routes($fn): self
    {
        $this->virtual_router = new VirtualRouter;
        $fn($this->virtual_router);
        return $this;
    }

    /**
     * @return VirtualRoute[]
     */
    public function getRoutes(): array
    {
        return $this->virtual_router->getRoutes();
    }

}
