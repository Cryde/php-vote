<?php

namespace App\Services;

use App\Entity\Idea;
use App\Entity\User;
use App\Entity\Vote;
use App\Repository\VoteRepository;

class VoteHandler
{
    /**
     * @var VoteRepository
     */
    private $voteRepository;
    /**
     * @var VoteManager
     */
    private $voteManager;

    /**
     * VoteHandler constructor.
     *
     * @param VoteRepository $voteRepository
     * @param VoteManager    $voteManager
     */
    public function __construct(VoteRepository $voteRepository, VoteManager $voteManager)
    {
        $this->voteRepository = $voteRepository;
        $this->voteManager    = $voteManager;
    }

    /**
     * @param Idea $idea
     * @param User $user
     * @param int  $voteValue
     */
    public function handleVote(Idea $idea, User $user, int $voteValue)
    {
        $vote = $this->voteRepository->findOneBy(['idea' => $idea, 'user' => $user]);

        if (!$vote) {
            $this->newVote($idea, $user, $voteValue);
        } else {
            $this->existingVote($idea, $vote, $voteValue);
        }

        $this->voteManager->flush();
    }

    /**
     * @param Idea $idea
     * @param User $user
     * @param int  $voteValue
     */
    private function newVote(Idea $idea, User $user, int $voteValue)
    {
        $vote = (new Vote())
            ->setUser($user)
            ->setIdea($idea)
            ->setValue($voteValue);

        $this->voteManager->persist($vote);

        if ($voteValue === Vote::VALUE_UP) {
            $idea->setTotalVoteUp($idea->getTotalVoteUp() + 1);
        } else {
            $idea->setTotalVoteDown($idea->getTotalVoteDown() + 1);
        }
    }

    /**
     * @param Idea $idea
     * @param Vote $vote
     * @param int  $voteValue
     */
    private function existingVote(Idea $idea, Vote $vote, int $voteValue)
    {
        $previousVote = $vote->getValue();
        $vote->setValue($voteValue);

        if ($previousVote === $voteValue) {
            $idea->removeVote($vote);
            if ($previousVote === Vote::VALUE_UP) {
                $idea->setTotalVoteUp($idea->getTotalVoteUp() - 1);
            } else {
                $idea->setTotalVoteDown($idea->getTotalVoteDown() - 1);
            }

            return;
        }

        if ($voteValue === Vote::VALUE_UP) {
            $idea->setTotalVoteUp($idea->getTotalVoteUp() + 1);
            $idea->setTotalVoteDown($idea->getTotalVoteDown() - 1);
        } else {
            $idea->setTotalVoteDown($idea->getTotalVoteDown() + 1);
            $idea->setTotalVoteUp($idea->getTotalVoteUp() - 1);
        }
    }
}
