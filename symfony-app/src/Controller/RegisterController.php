<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use App\Validator\ClientValidator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
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
     * @OA\Response(
     *     response=200,
     *     description="Create a client"
     * )
     * @OA\Response(
     *     response=401,
     *     description="forbiden access",
     * )
     * @OA\Response(
     *     response=500,
     *     description="server internal error",
     * )
     * @OA\Parameter(
     *     name="json",
     *     in="query",
     *     description="json payload to create client",
     *       @OA\Schema(type="object",
     *          @OA\Property(property="username", type="string"),
     *         @OA\Property(property="password", type="string",description="password + 6 char",minLength=6),
     *         @OA\Property(property="firstname", type="string"),
     *         @OA\Property(property="lastname", type="string")
     *     )
     * )
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
