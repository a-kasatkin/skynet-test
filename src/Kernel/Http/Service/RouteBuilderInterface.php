<?php


namespace App\Kernel\Http\Service;


use App\Kernel\Http\Route;

interface RouteBuilderInterface
{
    /**
     * @param array $routeParams
     * @return Route
     * @throws \Exception
     */
    public function buildRoute(array $routeParams): Route;
}