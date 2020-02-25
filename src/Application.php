<?php


namespace App;


use App\Kernel\Http\HttpKernel;
use App\Kernel\Http\JsonResponse;
use App\Kernel\Http\Request;
use App\Kernel\Http\Router;
use App\Kernel\Http\Service\ControllerResolver;
use App\Kernel\Http\Service\RouteBuilder;
use App\Kernel\Http\Service\UrlMatcher;
use App\Kernel\Provider\ServiceProviderInterface;

class Application implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $container = [];

    public function __construct(array $params = [])
    {
        $this->container = $params;

        $this[RouteBuilder::class] = function ($app) {
            return new RouteBuilder();
        };

        $this[UrlMatcher::class] = function ($app) {
            /** @var RouteBuilder $builder */
            $builder = $app[RouteBuilder::class];
            $routes = [];

            foreach ($app['routes'] as $routeParams) {
                $routes[] = $builder->buildRoute($routeParams);
            }

            return new UrlMatcher($routes);
        };

        $this[Router::class] = function ($app) {
            return new Router($app[UrlMatcher::class]);
        };

        $this['controllers_collection'] = function ($app) {
            return [];
        };

        $this[ControllerResolver::class] = function ($app) {
            return new ControllerResolver(
                $app['controllers_collection']
            );
        };

        $this[HttpKernel::class] = function ($app) {
            return new HttpKernel(
                $app[Router::class],
                $app[ControllerResolver::class]
            );
        };
    }

    /**
     * Handles the request and delivers the response.
     */
    public function run()
    {
        $request = Request::fromGlobals();
        /** @var JsonResponse $response */
        $response = $this[HttpKernel::class]->handle($request);
        $response->send();
    }

    /**
     * Registers a service provider.
     * @param ServiceProviderInterface $provider
     */
    public function register(ServiceProviderInterface $provider)
    {
        $provider->register($this);
    }

    /**
     * Extends an object definition.
     *
     * Useful when you want to extend an existing object definition,
     * without necessarily loading that object.
     *
     * @param string $id
     * @param callable $callable A service definition to extend the original
     *
     * @return \Closure
     *
     * @throws \InvalidArgumentException
     */
    public function extend($id, $callable)
    {
        if (!array_key_exists($id, $this->container)) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }

        if (!is_object($this->container[$id]) || !method_exists($this->container[$id], '__invoke')) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" does not contain an object definition.', $id));
        }

        if (!is_object($callable) || !method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException('Extension service definition is not a Closure or invokable object.');
        }

        $factory = $this->container[$id];

        return $this->container[$id] = function ($c) use ($callable, $factory) {
            return $callable($factory($c), $c);
        };
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($id)
    {
        return array_key_exists($id, $this->container);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($id)
    {
        if (!array_key_exists($id, $this->container)) {
            throw new \InvalidArgumentException(
                sprintf('Identifier "%s" is not defined.', $id)
            );
        }

        $isFactory = is_object($this->container[$id])
            && method_exists($this->container[$id], '__invoke');

        return $isFactory ? $this->container[$id](
            $this
        ) : $this->container[$id];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($id, $value)
    {
        $this->container[$id] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($id)
    {
        unset($this->container[$id]);
    }
}