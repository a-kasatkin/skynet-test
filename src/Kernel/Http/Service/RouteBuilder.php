<?php


namespace App\Kernel\Http\Service;


use App\Kernel\Http\Route;

class RouteBuilder implements RouteBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function buildRoute(array $routeParams): Route
    {
        if (!isset($routeParams['pattern'])) {
            throw new \Exception('Undefined route pattern', 500);
        }

        $pattern = $routeParams['pattern'];

        if (!is_string($pattern)) {
            throw new \Exception('Route pattern MUST BE a string', 500);
        }

        if (!isset($routeParams['method'])) {
            throw new \Exception("Undefined allowed methods for route `{$pattern}`", 500);
        }

        $method = $routeParams['method'];

        if (is_string($method)) {
            $methods = strtoupper($method);
        } else {
            throw new \Exception("Methods for route MUST BE a string", 500);
        }

        if (!isset($routeParams['controller'])) {
            throw new \Exception("Undefined controller for route `{$pattern}`", 500);
        }

        $controller = $routeParams['controller'];

        if (!is_object($controller)
            && !is_string($controller)
            && !is_callable($controller)
        ) {
            throw new \Exception("Controller for route MUST BE as an invokable object or as a string or as a callable", 500);
        }

        if (!isset($routeParams['requirements'])) {
            $requirements = [];
        } elseif (!is_array($routeParams['requirements'])) {
            throw new \Exception("Requirements for route MUST BE an array", 500);
        } else {
            $requirements = $routeParams['requirements'];
        }

        return new Route($pattern, $method, $controller, $requirements);
    }
}