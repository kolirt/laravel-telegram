<?php

namespace Kolirt\Telegram\Config;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;

class VirtualRouter
{

    const HOME_PATH = '';

    /**
     * @var VirtualRoute[] $routes
     */
    protected array $routes = [];
    protected array $keyboard = [];

    protected string $path = self::HOME_PATH;

    public function group($fn): self
    {
        $router = new VirtualRouter;
        $fn($router);
        $routes = $router->getRoutes();
        $keyboard = [];
        foreach ($routes as $route) {
            $route_name = $route->getName();
            $this->routes[$route_name] = $route;
            $keyboard[] = $route_name;
        }
        $this->keyboard[self::HOME_PATH][] = $keyboard;
        return $this;
    }

    public function home(string|array $handler, string $label)
    {
        return $this->route(self::HOME_PATH, $handler, $label);
    }

    public function route(string $name, string|array $handler, string $label): VirtualRoute
    {
        $route = new VirtualRoute($name, $handler, $label);
        $this->routes[$name] = $route;
        if ($name !== self::HOME_PATH) {
            $this->keyboard[self::HOME_PATH][] = [$name];
        }
        return $route;
    }

    /**
     * @return VirtualRoute[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param string $label
     *
     * @return VirtualRoute
     */
    public function getRoute(string $label): VirtualRoute
    {
        dd($label, $this);
    }

    /**
     * @param string $path
     *
     * @return ReplyKeyboardMarkupType|null
     */
    public function renderReplyKeyboardMarkup(string $path = self::HOME_PATH): ReplyKeyboardMarkupType|null
    {
        dd('renderReplyKeyboardMarkup');

        $keyboard = [];

        foreach ($this->routes as $route) {
            if ($route instanceof VirtualRoute) {
                $route = [$route];

            }

            $line = [];

            /**
             * @var VirtualRoute $r
             */
            foreach ($route as $r) {
                if ($r->getName() !== self::HOME_PATH) {
                    $line[] = $r->renderKeyboardButton();
                }
            }

            if (count($line)) {
                $keyboard[] = $line;
            }
        }

        if (count($keyboard)) {
            return new ReplyKeyboardMarkupType(
                keyboard: $keyboard,
            // is_persistent: $is_persistent,
            // resize_keyboard: $resize_keyboard,
            // one_time_keyboard: $one_time_keyboard,
            // input_field_placeholder: $input_field_placeholder,
            // selective: $selective
            );
        } else {
            return null;
        }
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /*public function normalize()
    {
        foreach ($this->routes as $route) {
            if ($route->hasChildren()) {
                dd($route->normalize());
            }
        }

        dd($this);
    }*/

}
