<?php


namespace App\Kernel\Http\Service;


use App\Kernel\Http\Request;
use App\Kernel\Http\Route;

class ControllerResolver implements ControllerResolverInterface
{

    /**
     * @var array
     */
    private $controllersCollection;

    public function __construct(array $controllersCollection = [])
    {
        $this->controllersCollection = $controllersCollection;
    }

    /**
     * @inheritDoc
     */
    public function getController(Route $route, Request $request): callable
    {
        $controller = $route->getController();

        if (is_callable($controller)) {
            return $controller;
        }

        if (is_object($controller)) {
            if (method_exists($controller, '__invoke')) {
                return $controller;
            }

            throw new \InvalidArgumentException(
                sprintf(
                    'Controller "%s" for URI "%s" is not callable.',
                    get_class($controller),
                    $request->getPathInfo()
                ),
                500
            );
        }

        if (false === strpos($controller, ':')) {
            if (class_exists($controller)
                && method_exists($controller, '__invoke')
            ) {
                if (isset($this->controllersCollection[$controller])) {
                    return $this->controllersCollection[$controller];
                }
            }

            throw new \Exception(
                "Could not resolve controller '{$controller}'",
                500
            );
        }

        return $this->createController($controller);
    }

    /**
     * Returns a callable for the given controller.
     *
     * @param string $controller A Controller string
     *
     * @return array A PHP callable array with object and method
     *
     * @throws \InvalidArgumentException
     */
    private function createController(string $controller): array
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(
                sprintf('Unable to find controller "%s".', $controller),
                500
            );
        }

        [$class, $method] = explode('::', $controller, 2);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                sprintf('Class "%s" does not exist.', $class),
                500
            );
        }

        if (!isset($this->controllersCollection[$class])) {
            throw new \InvalidArgumentException(
                "Could not resolve controller '{$class}'",
                500
            );
        }

        return [$this->controllersCollection[$class], $method];
    }
}