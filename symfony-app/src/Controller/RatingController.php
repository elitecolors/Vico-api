<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Service\RatingService;
use App\Validator\RatingRequestValidator;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("api/rating", name="rating")
 */
class RatingController extends AbstractController
{
    /**
     * @Route("/save",
     *      name="_client_rate_project",
     *      methods={"POST"}
     *     )
     * @OA\Response(
     *     response=200,
     *     description="client rate project"
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
     *     name="project_id",
     *     in="query",
     *     description="project id ",
     *     @OA\Schema(type="int")
     * )
     * @OA\Parameter(
     *     name="ratingData",
     *     in="query",
     *     description="object with rating data",
     *     @OA\Schema(type="json")
     * )
     * @OA\Parameter(
     *     name="overall_satisfaction",
     *     in="query",
     *     description="overall satisfication",
     *     @OA\Schema(type="float")
     * )
     * @OA\Parameter(
     *     name="communication",
     *     in="query",
     *     description="communication",
     *     @OA\Schema(type="float")
     * )
     * @OA\Parameter(
     *     name="quality_of_work",
     *     in="query",
     *     description="quality of work",
     *     @OA\Schema(type="float")
     * )
     * @OA\Parameter(
     *     name="value_for_money",
     *     in="query",
     *     description="value_for_money ",
     *     @OA\Schema(type="float")
     * )
     * @OA\Parameter(
     *     name="review_text",
     *     in="query",
     *     description="review text",
     *     @OA\Schema(type="flaot")
     * )
     */
    public function rateProject(
        Request $request,
        SerializerInterface $serializer,
        RatingService $ratingService,
        ValidatorInterface $validator
    ): Response {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return new JsonResponse(['error' => 'no data find in request'], Response::HTTP_BAD_REQUEST);
        }

        $requestPayload = $serializer->deserialize(
            $request->getContent(),
            RatingRequestValidator::class,
            'json'
        );

        $errors = $validator->validate($requestPayload);

        if ($errors->count() > 0) {
            return new JsonResponse(
                $errors,
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            /** @var Client $client */
            $client = $this->getUser();
            $add = $ratingService->addRating($data, $client);

            if (!$add) {
                return new JsonResponse(
                    ['error' => 'project not exist or already review added'],
                    Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['success' => 'rating added !']);
    }

    /**
     * @Route("/update",
     *      name="_client_update_rate_project",
     *      methods={"POST"}
     *     )
     */
    public function updateRateProject(
        Request $request,
        SerializerInterface $serializer,
        RatingService $ratingService,
        ValidatorInterface $validator
    ): Response {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return new JsonResponse(['error' => 'no data find in request'], Response::HTTP_BAD_REQUEST);
        }

        $requestPayload = $serializer->deserialize(
            $request->getContent(),
            RatingRequestValidator::class,
            'json'
        );

        $errors = $validator->validate($requestPayload);

        if ($errors->count() > 0) {
            return new JsonResponse(
                $errors,
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            /** @var Client $client */
            $client = $this->getUser();
            $update = $ratingService->updateRating($data, $client);

            if (!$update) {
                return new JsonResponse(
                    ['error' => 'project not exist or already review added'],
                    Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['success' => 'rating update ok !']);
    }
}
