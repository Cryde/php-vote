<?php

namespace App\Services;

use App\Entity\Comment;
use App\Entity\Idea;
use App\Entity\VotableInterface;
use App\Entity\Vote;
use App\Entity\VoteComment;

class VoteFactory
{
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

        if($className === Comment::class) {
            return (new VoteComment())->setComment($votable);
        }

        throw new \LogicException('Votable not handled');
    }
}
