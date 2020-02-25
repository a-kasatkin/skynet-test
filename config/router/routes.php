<?php

use App\Domain\Tarif\Controller\Action\GetUsersServicesTarifsAction;
use App\Domain\Tarif\Controller\Action\PutUsersServicesTarifsAction;

return [
    'routes' => [
        [
            'method' => 'GET',
            'pattern' => '/users/{user_id}/services/{service_id}/tarifs',
            'requirements' => [
                'user_id' => '\d+',
                'service_id' => '\d+',
            ],
            'controller' => GetUsersServicesTarifsAction::class
        ],
        [
            'method' => 'PUT',
            'pattern' => '/users/{user_id}/services/{service_id}/tarifs',
            'requirements' => [
                'user_id' => '\d+',
                'service_id' => '\d+',
            ],
            'controller' => PutUsersServicesTarifsAction::class
        ],
    ]
];