<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote implements VoteInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var \DateTimeInterface
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creationDatetime;
    /**
     * @ORM\Column(type="smallint")
     */
    private $value;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Idea", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idea;

    public function getId()
    {
        return $this->id;
    }

    public function getCreationDatetime(): ?\DateTimeInterface
    {
        return $this->creationDatetime;
    }

    public function setCreationDatetime(\DateTimeInterface $creationDatetime): self
    {
        $this->creationDatetime = $creationDatetime;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIdea(): ?Idea
    {
        return $this->idea;
    }

    public function setIdea(?VotableInterface $idea): self
    {
        $this->idea = $idea;

        return $this;
    }
}
