<?php


namespace App\Kernel\Http\Service;


use App\Kernel\Http\Request;
use App\Kernel\Http\Route;

interface UrlMatcherInterface
{
    /**
     * Match path info with routes and return route handler params
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function match(Request $request): array;

    /**
     * Adds route to route collection
     * @param Route $route
     */
    public function addRoute(Route $route): void;
}