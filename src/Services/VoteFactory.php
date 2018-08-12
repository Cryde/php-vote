<?php

namespace App\Services;

use App\Entity\Idea;
use App\Entity\VotableInterface;
use App\Entity\Vote;
use Doctrine\ORM\EntityManagerInterface;

class VoteFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var VotableClassNameResolver
     */
    private $classNameResolver;

    public function __construct(VotableClassNameResolver $classNameResolver)
    {
        $this->classNameResolver = $classNameResolver;
    }

    public function createVoteFromVotable(VotableInterface $votable)
    {
        $className = $this->classNameResolver->getName($votable);

        if ($className === Idea::class) {
            return (new Vote())->setIdea($votable);
        }

        throw new \LogicException('Votable not handled');
    }
}
