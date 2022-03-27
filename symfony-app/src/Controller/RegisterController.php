<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use App\Validator\ClientValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/register")
 */
class RegisterController extends AbstractController
{
    /**
     * @Route("/client",
     *      name="_register_client",
     *      methods={"POST"}
     *     )
     */
    public function registerClient(
        Request $request,
        ClientService $clientService,
        ClientValidator $clientValidator
    ): Response {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return new JsonResponse(['error' => 'no data find'], Response::HTTP_BAD_REQUEST);
        }

        $validationRequest = $clientValidator->validateClient($data);

        if ($validationRequest->count() > 0) {
            return new JsonResponse(['error' => (string) $validationRequest], Response::HTTP_BAD_REQUEST);
        }

        try {
            $clientService->createClient($data);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['success' => 'client created']);
    }
}
