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
     *     description="Create a client",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class, groups={"full"}))
     *     )
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
     *     name="username",
     *     in="query",
     *     description="email username",
     *     @OA\Schema(type="email")
     * )
     * @OA\Parameter(
     *     name="password",
     *     in="query",
     *     description="password + 6 char",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="firstname",
     *     in="query",
     *     description="firstname",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="lastname",
     *     in="query",
     *     description="lastname client",
     *     @OA\Schema(type="string")
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
