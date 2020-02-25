<?php


namespace App\Kernel\Http;


interface RouterInterface
{
    /**
     * Finds controller by request uri
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function process(Request $request): array;
}