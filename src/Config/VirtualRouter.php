<?php

namespace Kolirt\Telegram\Config;

class VirtualRouter
{

    /**
     * @var VirtualRoute[] $routes
     */
    protected array $routes = [];

    public function group($fn): self
    {
        $router = new VirtualRouter;
        $fn($router);
        $this->routes[] = $router->getRoutes();
        return $this;
    }

    public function home(string|array $handler, string $label)
    {
        return $this->route('', $handler, $label);
    }

    public function route(string $name, string|array $handler, string $label): VirtualRoute
    {
        $route = new VirtualRoute($name, $handler, $label);
        $this->routes[] = $route;
        return $route;
    }

    /**
     * @return VirtualRoute[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

}
