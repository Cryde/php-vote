<?php

namespace App\Controller\Api;

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
    public function index(Idea $idea, int $voteValue, VoteHandler $voteHandler)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $voteHandler->handleVote($idea, $this->getUser(), $voteValue);

        return $this->json(['data' => [
            'vote' => $voteValue,
            'idea' => ['total_vote_up' => $idea->getTotalVoteUp(), 'total_vote_down' => $idea->getTotalVoteDown()]
        ]]);
    }
}
