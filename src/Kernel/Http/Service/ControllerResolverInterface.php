<?php


namespace App\Kernel\Http\Service;


use App\Kernel\Http\Request;
use App\Kernel\Http\Route;

interface ControllerResolverInterface
{
    /**
     * @param Route $route
     * @param Request $request
     * @return callable
     * @throws \Exception
     */
    public function getController(Route $route, Request $request): callable;
}