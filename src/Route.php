<?php declare(strict_types = 1);

namespace Venta\Routing;

use Venta\Contracts\Routing\Route as RouteContract;

/**
 * Class Route
 *
 * @package Venta\Routing
 */
class Route implements RouteContract
{

    /**
     * Route handler, may contain callable or controller action.
     *
     * @var string|callable
     */
    private $handler;

    /**
     * Host to apply route to.
     *
     * @var string
     */
    private $host = '';

    /**
     * Route allowed methods.
     *
     * @var string[]
     */
    private $methods = [];

    /**
     * Route name.
     *
     * @var string
     */
    private $name = '';

    /**
     * Route path
     *
     * @var string
     */
    private $path = '';

    /**
     * Scheme to apply route to.
     *
     * @var string
     */
    private $scheme = '';

    /**
     * Route variables.
     *
     * @var string[]
     */
    private $variables = [];

    /**
     * Route constructor.
     *
     * @param array $methods
     * @param string $path
     * @param string|callable $handler
     */
    public function __construct(array $methods, string $path, $handler)
    {
        $this->methods = $methods;
        $this->path = '/' . ltrim($path, '/');
        $this->handler = $handler;
    }

    /**
     * @param $path
     * @param callable|string $handler
     * @return Route
     */
    public static function any($path, $handler): Route
    {
        return new static(['HEAD', 'GET', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function delete(string $path, $handler): Route
    {
        return new static(['DELETE'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function get(string $path, $handler): Route
    {
        return new static(['GET'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function head(string $path, $handler): Route
    {
        return new static(['HEAD'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function options(string $path, $handler): Route
    {
        return new static(['OPTIONS'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function patch(string $path, $handler): Route
    {
        return new static(['PATCH'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function post(string $path, $handler): Route
    {
        return new static(['POST'], $path, $handler);
    }

    /**
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public static function put(string $path, $handler): Route
    {
        return new static(['PUT'], $path, $handler);
    }

    /**
     * @inheritDoc
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @inheritDoc
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @inheritDoc
     */
    public function url(array $parameters = []): string
    {
        return UrlGenerator::generate($this->getPath(), $parameters);
    }

    /**
     * Set the host.
     *
     * @param string $host
     * @return Route
     */
    public function withHost(string $host): Route
    {
        $route = clone $this;
        $route->host = $host;

        return $route;
    }

    /**
     * Set the name.
     *
     * @param string $name
     * @return Route
     */
    public function withName(string $name): Route
    {
        $route = clone $this;
        $route->name = $name;

        return $route;
    }

    /**
     * Prefix the path.
     *
     * @param string $prefix
     * @return Route
     */
    public function withPathPrefix(string $prefix): Route
    {
        $route = clone $this;
        $route->path = $prefix == '/' || $prefix == '' ?
            $route->path :
            sprintf('/%s/%s', trim($prefix, '/'), ltrim($route->path, '/'));

        return $route;
    }

    /**
     * Set the scheme.
     *
     * @param string $scheme
     * @return Route
     */
    public function withScheme(string $scheme): Route
    {
        $route = clone $this;
        $route->scheme = $scheme;

        return $route;
    }

    /**
     * Set route parameters.
     *
     * @param array $variables
     * @return Route
     */
    public function withVariables(array $variables): Route
    {
        $route = clone $this;
        $route->variables = $variables;

        return $route;
    }

}