<?php


namespace App\Kernel\Http;


use App\Kernel\Http\Service\ControllerResolverInterface;

class HttpKernel implements HttpKernelInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var ControllerResolverInterface
     */
    private $resolver;

    public function __construct(
        RouterInterface $router,
        ControllerResolverInterface $resolver
    ) {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    /**
     * @inheritDoc
     */
    public function handle(Request $request)
    {
        try {
            if (!$request->isJson()) {
                throw new \Exception('Acceptable only JSON request', 400);
            }

            [$route, $params] = $this->router->process($request);
            $controller = $this->resolver->getController($route, $request);
            $response = call_user_func_array($controller, $params);
        } catch (\Exception $e) {
            $response = $this->handleException($e, $request);
        }

        return $response;
    }

    /**
     * @param \Exception $e
     * @param Request $request
     * @return JsonResponse
     */
    private function handleException(\Exception $e, Request $request): JsonResponse
    {
        return new JsonResponse(['error' => [
            'message' => $e->getMessage(),
            'code' => $e->getCode()
        ]], $e->getCode());
    }
}