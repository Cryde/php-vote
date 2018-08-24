<?php

namespace App\Services\Helper;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\VoteComment;
use App\Repository\VoteCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;

class CommentHelper
{
    /**
     * @var VoteCommentRepository
     */
    private $voteCommentRepository;

    public function __construct(VoteCommentRepository $voteCommentRepository
    ) {
        $this->voteCommentRepository = $voteCommentRepository;
    }

    /**
     * @param ArrayCollection|Comment[] $comments
     *
     * @return array
     */
    public function getCommentIds($comments)
    {
        return $comments->map(
            function (Comment $comment) {
                return $comment->getId();
            }
        )->toArray();
    }

    /**
     * @param ArrayCollection|Comment[] $comments
     * @param User|null                 $user
     *
     * @return array
     */
    public function getFormattedVoteByUser($comments, ?User $user)
    {
        if (!$user) {
            return [];
        }

        /** @var VoteComment[] $votes */
        $votes = $this->voteCommentRepository->findByCommentIdsAndUser($this->getCommentIds($comments), $user);

        $result = [];
        foreach ($votes as $vote) {
            $result[$vote->getComment()->getId()] = $vote->getValue();
        }

        return $result;
    }
}
