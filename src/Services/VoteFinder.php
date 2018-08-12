<?php

namespace App\Services;

use App\Entity\Idea;
use App\Entity\User;
use App\Entity\VotableInterface;
use App\Repository\VoteRepository;

class VoteFinder
{
    /**
     * @var VoteRepository
     */
    private $voteRepository;
    /**
     * @var VotableClassNameResolver
     */
    private $classNameResolver;

    public function __construct(VotableClassNameResolver $classNameResolver, VoteRepository $voteRepository)
    {
        $this->voteRepository    = $voteRepository;
        $this->classNameResolver = $classNameResolver;
    }

    public function findByVotableAndUser(VotableInterface $votable, User $user)
    {
        $className = $this->classNameResolver->getName($votable);

        if ($className === Idea::class) {
            return $this->voteRepository->findOneBy(['idea' => $votable, 'user' => $user]);
        }

        throw new \LogicException('Votable is not handled');
    }
}
