<?php declare(strict_types = 1);

namespace Venta\Routing;

use Venta\Contracts\Routing\Route as RouteContract;
use Venta\Contracts\Routing\RouteCollection as RouteCollectionContract;
use Venta\Contracts\Routing\RouteGroup as RouteGroupContract;

/**
 * Class RouteCollection
 *
 * @package Venta\Routing
 */
class RouteCollection implements RouteCollectionContract
{

    /**
     * @var RouteContract[]
     */
    private $routes = [];

    /**
     * @inheritDoc
     */
    public function addGroup(RouteGroupContract $group): RouteCollectionContract
    {
        foreach ($group->all() as $route) {
            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addRoute(RouteContract $route): RouteCollectionContract
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->routes;
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $routeName)
    {
        foreach ($this->routes as $route) {
            if ($route->name() === $routeName) {
                return $route;
            }
        }
    }

}