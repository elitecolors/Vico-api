<?php

namespace App\Entity;

use App\Repository\RatingDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingDataRepository::class)
 */
class RatingData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $overallSatisfaction;

    /**
     * @ORM\Column(type="float")
     */
    private $communication;

    /**
     * @ORM\Column(type="float")
     */
    private $qualityOfWork;

    /**
     * @ORM\Column(type="float")
     */
    private $valueForMoney;

    /**
     * @ORM\Column(type="text")
     */
    private $reviewText;

    /**
     * @ORM\OneToOne(targetEntity=Rating::class, mappedBy="rating", cascade={"persist", "remove"})
     */
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOverallSatisfaction(): ?float
    {
        return $this->overallSatisfaction;
    }

    public function setOverallSatisfaction(float $overallSatisfaction): self
    {
        $this->overallSatisfaction = $overallSatisfaction;

        return $this;
    }

    public function getCommunication(): ?float
    {
        return $this->communication;
    }

    public function setCommunication(float $communication): self
    {
        $this->communication = $communication;

        return $this;
    }

    public function getQualityOfWork(): ?float
    {
        return $this->qualityOfWork;
    }

    public function setQualityOfWork(float $qualityOfWork): self
    {
        $this->qualityOfWork = $qualityOfWork;

        return $this;
    }

    public function getValueForMoney(): ?float
    {
        return $this->valueForMoney;
    }

    public function setValueForMoney(float $valueForMoney): self
    {
        $this->valueForMoney = $valueForMoney;

        return $this;
    }

    public function getReviewText(): ?string
    {
        return $this->reviewText;
    }

    public function setReviewText(string $reviewText): self
    {
        $this->reviewText = $reviewText;

        return $this;
    }

    public function getRating(): ?Rating
    {
        return $this->rating;
    }

    public function setRating(?Rating $rating): self
    {
        // unset the owning side of the relation if necessary
        if (null === $rating && null !== $this->rating) {
            $this->rating->setRating(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $rating && $rating->getRating() !== $this) {
            $rating->setRating($this);
        }

        $this->rating = $rating;

        return $this;
    }
}
