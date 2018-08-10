<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Loggable
 * @ORM\Entity(repositoryClass="App\Repository\IdeaRepository")
 */
class Idea
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creationDatetime;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     */
    private $content;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="idea")
     */
    private $comments;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ideas")
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="idea", orphanRemoval=true)
     */
    private $votes;
    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $totalVoteUp;
    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $totalVoteDown;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $editDatetime;

    public function __construct()
    {
        $this->comments      = new ArrayCollection();
        $this->votes         = new ArrayCollection();
        $this->totalVoteDown = 0;
        $this->totalVoteUp   = 0;
    }

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIdea($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getIdea() === $this) {
                $comment->setIdea(null);
            }
        }

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

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setIdea($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getIdea() === $this) {
                $vote->setIdea(null);
            }
        }

        return $this;
    }

    public function getTotalVoteUp(): ?int
    {
        return $this->totalVoteUp;
    }

    public function setTotalVoteUp(int $totalVoteUp): self
    {
        $this->totalVoteUp = $totalVoteUp;

        return $this;
    }

    public function getTotalVoteDown(): ?int
    {
        return $this->totalVoteDown;
    }

    public function setTotalVoteDown(int $totalVoteDown): self
    {
        $this->totalVoteDown = $totalVoteDown;

        return $this;
    }

    public function getEditDatetime(): ?\DateTimeInterface
    {
        return $this->editDatetime;
    }

    public function setEditDatetime(?\DateTimeInterface $editDatetime): self
    {
        $this->editDatetime = $editDatetime;

        return $this;
    }
}
