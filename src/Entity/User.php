<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $creationDatetime;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Idea", mappedBy="user")
     */
    private $ideas;

    public function __construct()
    {
        parent::__construct();
        $this->creationDatetime = new \DateTime();
        $this->ideas            = new ArrayCollection();
    }

    /**
     * @return Collection|Idea[]
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): self
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas[] = $idea;
            $idea->setUser($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): self
    {
        if ($this->ideas->contains($idea)) {
            $this->ideas->removeElement($idea);
            // set the owning side to null (unless already changed)
            if ($idea->getUser() === $this) {
                $idea->setUser(null);
            }
        }

        return $this;
    }
}