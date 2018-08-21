<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Idea;
use App\Services\VoteHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends Controller
{
    /**
     * @Route("/api/vote/idea/{id}/{voteValue}", name="api_vote_idea", requirements={"voteValue"="1|-1"})
     *
     * @param Idea        $idea
     * @param int         $voteValue
     * @param VoteHandler $voteHandler
     *
     * @return JsonResponse
     */
    public function idea(Idea $idea, int $voteValue, VoteHandler $voteHandler)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $voteHandler->handleVote($idea, $this->getUser(), $voteValue);

        return $this->json(
            [
                'data' => [
                    'vote' => $voteValue,
                    'idea' => [
                        'total_vote_up'   => $idea->getTotalVoteUp(),
                        'total_vote_down' => $idea->getTotalVoteDown(),
                    ],
                ],
            ]
        );
    }

    /**
     * @Route("/api/vote/comment/{id}/{voteValue}", name="api_vote_comment", requirements={"voteValue"="1|-1"})
     *
     * @param Comment     $comment
     * @param int         $voteValue
     * @param VoteHandler $voteHandler
     *
     * @return JsonResponse
     */
    public function comment(Comment $comment, int $voteValue, VoteHandler $voteHandler)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $voteHandler->handleVote($comment, $this->getUser(), $voteValue);

        return $this->json(
            [
                'data' => [
                    'vote' => $voteValue,
                    'idea' => [
                        'total_vote_up'   => $comment->getTotalVoteUp(),
                        'total_vote_down' => $comment->getTotalVoteDown(),
                    ],
                ],
            ]
        );
    }
}
