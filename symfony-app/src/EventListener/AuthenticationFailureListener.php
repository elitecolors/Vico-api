<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailureListener
{
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status' => [
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Email et/ou mot de passe erroné(s)',
            ],
        ];

        $response = new JsonResponse($data, $data['status']['code']);
        $event->setResponse($response);
    }
}
