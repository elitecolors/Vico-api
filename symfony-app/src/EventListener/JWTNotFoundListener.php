<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'status' => ['code' => Response::HTTP_FORBIDDEN, 'message' => 'JWT Token not found'],
        ];

        $response = new JsonResponse($data, $data['status']['code']);

        $event->setResponse($response);
    }
}
