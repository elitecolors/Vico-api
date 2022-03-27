<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Rating;
use App\Entity\RatingData;
use Doctrine\ORM\EntityManagerInterface;

class RatingService
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function addRating(array $data, Client $client): bool
    {
        $project = $this->getProject($data['project_id']);

        if (!$project) {
            return false;
        }
        // client can create only one review by project
        $checkRating = $this->getRating($client, $project);

        if ($checkRating) {
            return false;
        }

        $ratingData = $this->newRattingData($data['ratingData']);

        $rating = new Rating();
        $rating->setClient($client);
        $rating->setProject($project);
        $rating->setRating($ratingData->getRating());

        $this->entityManager->persist($rating);

        $ratingData->setRating($rating);

        $this->entityManager->persist($ratingData);
        $this->entityManager->flush();

        return true;
    }

    private function newRattingData(array $data): RatingData
    {
        $ratingData = new RatingData();
        $ratingData->setCommunication($data['communication']);
        $ratingData->setOverallSatisfaction($data['overall_satisfaction']);
        $ratingData->setQualityOfWork($data['quality_of_work']);
        $ratingData->setReviewText($data['review_text']);
        $ratingData->setValueForMoney($data['value_for_money']);

        $this->entityManager->persist($ratingData);
        $this->entityManager->flush();

        return $ratingData;
    }

    public function updateRating(array $data, Client $client)
    {
        $project = $this->getProject($data['project_id']);

        if (!$project) {
            return false;
        }

        // client can create only one review by project
        $rating = $this->getRating($client, $project);

        if (!$rating) {
            return false;
        }

        $ratingData = $this->updateRatingData($rating->getRating(), $data['ratingData']);

        $rating->setRating($ratingData);

        $this->entityManager->persist($rating);

        $ratingData->setRating($rating);

        $this->entityManager->persist($ratingData);
        $this->entityManager->flush();

        return true;
    }

    private function getProject(int $project_id): ?Project
    {
        $repoProject = $this
            ->entityManager
            ->getRepository(Project::class);

        return $repoProject->find($project_id);
    }

    private function getRating(Client $client, Project $project): ?Rating
    {
        $repoRating = $this
            ->entityManager
            ->getRepository(Rating::class);

        $result = $repoRating->findOneBy(
            [
                'client' => $client,
                'project' => $project,
            ]
        );

        return $result ?? null;
    }

    private function updateRatingData(RatingData $ratingData, array $data): RatingData
    {
        $ratingData->setCommunication($data['communication']);
        $ratingData->setOverallSatisfaction($data['overall_satisfaction']);
        $ratingData->setQualityOfWork($data['quality_of_work']);
        $ratingData->setReviewText($data['review_text']);
        $ratingData->setValueForMoney($data['value_for_money']);

        $this->entityManager->persist($ratingData);
        $this->entityManager->flush();

        return $ratingData;
    }
}
