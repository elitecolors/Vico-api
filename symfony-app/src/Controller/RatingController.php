<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Rating;
use App\Entity\RatingData;
use App\Service\RatingService;
use App\Validator\RatingRequestValidator;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/rating", name="rating")
 */
class RatingController extends ApiAbstractController
{
    /**
     * @Route("/save",
     *      name="_client_rate_project",
     *      methods={"POST"}
     *     )
     * @OA\Response(
     *     response=200,
     *     description="client rate project",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Rating::class, groups={"full"}))
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
     *     name="rating",
     *     in="query",
     *     description="json payload to rate project",
     *       @OA\Schema(type="object",
     *         @OA\Property(property="project_id", type="integer"),
     *          @OA\Property(type="object",property="dataRating",
     *           @OA\Property(property="overall_satisfaction", type="double",minLength=0,maxLength=5),
     *           @OA\Property(property="communication", type="double",minLength=5),
     *           @OA\Property(property="quality_of_work", type="double",minLength=0,maxLength=5),
     *           @OA\Property(property="value_for_money", type="double",minLength=0,maxLength=5),
     *           @OA\Property(property="review_text", type="double",minLength=0,maxLength=5),
     *     )
     * )
     * )
     * @Security(name="Bearer")
     */
    public function rateProject(
        Request $request,
        RatingService $ratingService,
    ): Response {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return new JsonResponse(['error' => 'no data find in request'], Response::HTTP_BAD_REQUEST);
        }

        $validationsErrors = $this->validateRequest($request->getContent(), RatingRequestValidator::class);

        if ($validationsErrors->count() > 0) {
            return $this->createGenericErrorValidationResponse($validationsErrors);
        }

        try {
            /** @var Client $client */
            $client = $this->getUser();
            $add = $ratingService->addRating($data, $client);

            if (!$add) {
                return $this->createGenericErrorResponse(throw new \Exception('project not exist or already review added'));
            }
        } catch (\Exception $e) {
            return $this->createGenericErrorResponse($e);
        }

        return $this->createSuccessfulApiResponse('rating added !');
    }

    /**
     * @Route("/update",
     *      name="_client_update_rate_project",
     *      methods={"POST"}
     *     )
     * @OA\Response(
     *     response=200,
     *     description="client rate project",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=RatingData::class, groups={"full"}))
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
     *     name="rating",
     *     in="query",
     *     description="json payload to rate project",
     *       @OA\Schema(type="object",
     *         @OA\Property(property="project_id", type="integer"),
     *           @OA\Property(type="object",property="dataRating",
     *              @OA\Property(property="overall_satisfaction", type="double",minLength=0,maxLength=5),
     *              @OA\Property(property="communication", type="double",minLength=5),
     *              @OA\Property(property="quality_of_work", type="double",minLength=0,maxLength=5),
     *              @OA\Property(property="value_for_money", type="double",minLength=0,maxLength=5),
     *              @OA\Property(property="review_text", type="double",minLength=0,maxLength=5),
     *     )
     * )
     * )
     * @Security(name="Bearer")
     */
    public function updateRateProject(
        Request $request,
        RatingService $ratingService
    ): Response {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return new JsonResponse(['error' => 'no data find in request'], Response::HTTP_BAD_REQUEST);
        }

        $validationsErrors = $this->validateRequest($request->getContent(), RatingRequestValidator::class);

        if ($validationsErrors->count() > 0) {
            return $this->createGenericErrorValidationResponse($validationsErrors);
        }

        try {
            /** @var Client $client */
            $client = $this->getUser();
            $update = $ratingService->updateRating($data, $client);

            if (!$update) {
                return $this->createGenericErrorResponse(throw new \Exception('project not exist or already review added'));
            }
        } catch (\Exception $e) {
            return $this->createGenericErrorResponse($e);
        }

        return $this->createSuccessfulApiResponse('rating update ok !');
    }
}
