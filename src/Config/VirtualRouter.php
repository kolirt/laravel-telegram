<?php

namespace Kolirt\Telegram\Config;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;

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

    /**
     * @param string $path
     *
     * @return ReplyKeyboardMarkupType|null
     */
    public function renderReplyKeyboardMarkup(string $path = ''): ReplyKeyboardMarkupType|null
    {
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
                if ($r->getName() !== '') {
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

}
