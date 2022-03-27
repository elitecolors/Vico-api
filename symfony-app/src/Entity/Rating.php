<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 * @ORM\Table(
 *      name="rating",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="unique_pc",columns={"client_id","project_id"})
 *      }
 * )
 * @UniqueEntity(fields="client_id", message="Code is already taken.")
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=RatingData::class, inversedBy="rating", cascade={"persist", "remove"})
     */
    private $rating;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="ratings")
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="ratings")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?RatingData
    {
        return $this->rating;
    }

    public function setRating(?RatingData $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
