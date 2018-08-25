<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment implements VotableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Idea", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idea;
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creationDatetime;
    /**
     * @ORM\Column(type="text")
     */
    private $content;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoteComment", mappedBy="comment", orphanRemoval=true)
     */
    private $votes;
    /**
     * @ORM\Column(type="integer", options={"default" : 0, "unsigned"=true})
     */
    private $totalVoteUp;
    /**
     * @ORM\Column(type="integer", options={"default" : 0, "unsigned"=true})
     */
    private $totalVoteDown;

    public function __construct()
    {
        $this->votes         = new ArrayCollection();
        $this->totalVoteUp   = 0;
        $this->totalVoteDown = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdea(): ?Idea
    {
        return $this->idea;
    }

    public function setIdea(?Idea $idea): self
    {
        $this->idea = $idea;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
     * @return Collection|VoteComment[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(VoteComment $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setComment($this);
        }

        return $this;
    }

    /**
     * @param VoteComment $vote
     *
     * @return Comment
     */
    public function removeVote($vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getComment() === $this) {
                $vote->setComment(null);
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
}
