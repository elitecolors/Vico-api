<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JWTInvalidListener
{
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $data = [
            'status' => [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'Your token is invalid, please login again to get a new one',
            ],
        ];

        $response = new JsonResponse($data, $data['status']['code']);
        $event->setResponse($response);
    }
}
