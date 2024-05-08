<?php

namespace Kolirt\Telegram\Config\Traits;

trait Routable
{

    protected array $routes = [];

    public function route(string $route, array $class): self
    {
        $this->routes[$route] = [$class[0], $class[1]];
        return $this;
    }

    public function routes(array $routes): self
    {
        foreach ($routes as $route => $class) {
            $this->route($route, $class);
        }
        return $this;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

}
