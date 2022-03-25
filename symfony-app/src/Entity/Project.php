<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project", indexes={@ORM\Index(name="IDX_2FB3D0EE19F89217", columns={"vico_id"}), @ORM\Index(name="creator_idx", columns={"creator_id"}), @ORM\Index(name="created_idx", columns={"created"})})
 * @ORM\Entity
 */
class Project
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \Vico
     *
     * @ORM\ManyToOne(targetEntity="Vico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vico_id", referencedColumnName="id")
     * })
     */
    private $vico;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     * })
     */
    private $creator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVico(): ?Vico
    {
        return $this->vico;
    }

    public function setVico(?Vico $vico): self
    {
        $this->vico = $vico;

        return $this;
    }

    public function getCreator(): ?Client
    {
        return $this->creator;
    }

    public function setCreator(?Client $creator): self
    {
        $this->creator = $creator;

        return $this;
    }


}
