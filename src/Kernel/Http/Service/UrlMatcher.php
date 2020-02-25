<?php


namespace App\Kernel\Http\Service;


use App\Kernel\Http\Request;
use App\Kernel\Http\Route;

class UrlMatcher implements UrlMatcherInterface
{
    /**
     * @var Route[]
     */
    private $routes;

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * @inheritDoc
     */
    public function match(Request $request): array
    {
        $allowedMethods = [];

        foreach ($this->routes as $route) {
            $regex = $this->createRegex(
                $route->getPattern(),
                $route->getRequirements()
            );

            if (!preg_match($regex, $request->getPathInfo(), $matches)) {
                continue;
            }

            if ($route->getMethod() !== $request->getMethod()) {
                $allowedMethods[] = $route->getMethod();
                continue;
            }

            $params = array_filter(
                $matches,
                function ($value, $name) {
                    return '' !== $value && false === is_int($name);
                },
                ARRAY_FILTER_USE_BOTH
            );

            return [$route, $params];
        }

        if (0 < count($allowedMethods)) {
            throw new \Exception(
                sprintf(
                    "No route found for \"%s %s\": Method Not Allowed (Allow: %s)",
                    $request->getMethod(),
                    $request->getPathInfo(),
                    implode(',', $allowedMethods)
                ),
                405
            );
        } else {
            throw new \Exception(
                "Route for path \"{$request->getPathInfo()}\" not found", 404
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    /**
     * Создает регулярное выражение
     *
     * @param $path
     * @param $params
     *
     * @return string
     */
    private function createRegex($path, $params): string
    {
        $regex = addcslashes($path, '.\+*?[^]$=!<>|:-#');
        $regex = str_replace(['(', ')'], ['(?:', ')?'], $regex);
        $regex = preg_replace_callback(
            '/{(\w+)}/',
            function ($matches) use ($params) {
                return '(?<' . $matches[1] . '>' . ($params[$matches[1]] ?? '[^/]+') . ')';
            },
            $regex
        );

        return '#^' . $regex . '$#ui';
    }
}
