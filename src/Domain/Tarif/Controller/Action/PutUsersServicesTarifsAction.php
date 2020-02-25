<?php


namespace App\Domain\Tarif\Controller\Action;


use App\Domain\Service\Manager\ServiceManagerInterface;
use App\Domain\Tarif\Manager\TarifManagerInterface;
use App\Domain\User\Manager\UserManagerInterface;
use App\Kernel\Http\JsonResponse;
use App\Kernel\Http\Request;

class PutUsersServicesTarifsAction
{

    /**
     * @var UserManagerInterface
     */
    private $userManager;
    /**
     * @var ServiceManagerInterface
     */
    private $serviceManager;
    /**
     * @var TarifManagerInterface
     */
    private $tarifManager;

    public function __construct(
        UserManagerInterface $userManager,
        ServiceManagerInterface $serviceManager,
        TarifManagerInterface $tarifManager
    ) {
        $this->userManager = $userManager;
        $this->serviceManager = $serviceManager;
        $this->tarifManager = $tarifManager;
    }

    /**
     * @param Request $request
     * @param int $userId
     * @param int $serviceId
     * @return JsonResponse
     */
    public function __invoke(
        Request $request,
        int $userId,
        int $serviceId
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true);

            if (empty($data)) {
                throw new \Exception('Not found required request data', 400);
            }

            if (empty($data['tarif_id'])) {
                throw new \Exception('Not found required request data', 400);
            }

            if (!$user = $this->userManager->getUserById($userId)) {
                throw new \Exception('User not found', 404);
            }

            if (!$service = $this->serviceManager->getServiceByUserAndId($user, $userId)) {
                throw new \Exception('User service not found', 404);
            }

            if (!$tarif = $this->tarifManager->getTarifById((int)$data['tarif_id'])) {
                throw new \Exception('Tarif not found', 404);
            }

            $this->serviceManager->setTarif($service, $tarif);

            return new JsonResponse(
                [
                    'result' => 'ok',
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'result' => 'error',
                    'error' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode()
                    ]
                ],
                $e->getCode()
            );
        }
    }
}