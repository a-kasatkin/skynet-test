<?php


namespace App\Kernel\Http;


use App\Kernel\Http\Service\UrlMatcherInterface;

class Router implements RouterInterface
{
    /**
     * @var UrlMatcherInterface
     */
    private $urlMatcher;

    public function __construct(UrlMatcherInterface $urlMatcher)
    {
        $this->urlMatcher = $urlMatcher;
    }

    /**
     * @inheritDoc
     */
    public function process(Request $request): array
    {
        /** @var Route $route */
        [$route, $params] = $this->urlMatcher->match($request);
        array_unshift($params, $request);

        return [$route, $params];
    }
}