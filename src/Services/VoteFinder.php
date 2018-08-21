<?php

namespace App\Services;

use App\Entity\Comment;
use App\Entity\Idea;
use App\Entity\User;
use App\Entity\VotableInterface;
use App\Repository\VoteCommentRepository;
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
    /**
     * @var VoteCommentRepository
     */
    private $voteCommentRepository;

    public function __construct(
        VotableClassNameResolver $classNameResolver,
        VoteRepository $voteRepository,
        VoteCommentRepository $voteCommentRepository
    ) {
        $this->voteRepository        = $voteRepository;
        $this->classNameResolver     = $classNameResolver;
        $this->voteCommentRepository = $voteCommentRepository;
    }

    public function findByVotableAndUser(VotableInterface $votable, User $user)
    {
        $className = $this->classNameResolver->getName($votable);

        if ($className === Idea::class) {
            return $this->voteRepository->findOneBy(['idea' => $votable, 'user' => $user]);
        }

        if ($className === Comment::class) {
            return $this->voteCommentRepository->findOneBy(['comment' => $votable, 'user' => $user]);
        }

        throw new \LogicException('Votable is not handled');
    }
}
