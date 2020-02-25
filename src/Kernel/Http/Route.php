<?php


namespace App\Kernel\Http;


class Route
{
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var string
     */
    private $method;
    /**
     * @var string|object|callable
     */
    private $controller;
    /**
     * @var array
     */
    private $requirements;

    public function __construct(
        string $pattern,
        string $method,
        $controller,
        array $requirements = []
    ) {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->controller = $controller;
        $this->requirements = $requirements;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return callable|object|string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return array
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }
}
