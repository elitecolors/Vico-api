<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiAbstractController extends AbstractController
{
    public const GENERAL_ERROR = ['error' => 'Something went wrong.'];

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function createGenericErrorResponse(\Exception $exception): JsonResponse
    {
        $errors = array_merge(self::GENERAL_ERROR, ['details' => $exception->getMessage()]);

        return new JsonResponse(
            $errors,
            Response::HTTP_BAD_REQUEST
        );
    }

    public function createSuccessfulApiResponse(string $message, $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(['success' => $message], $status);
    }

    public function validateRequest(string $data, string $classValidator): ConstraintViolationListInterface
    {
        $requestPayload = $this->serializer->deserialize(
            $data,
            $classValidator,
            'json'
        );

        return $this->validator->validate($requestPayload);
    }

    public function createGenericErrorValidationResponse(ConstraintViolationListInterface $constraintViolationList): Response
    {
        $errors = [];
        /** @var ConstraintViolation $error */
        foreach ($constraintViolationList as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return new JsonResponse(
            $errors,
            Response::HTTP_BAD_REQUEST
        );
    }
}
