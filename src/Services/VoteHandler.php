<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\VotableInterface;
use App\Entity\VoteInterface;

class VoteHandler
{
    /**
     * @var VoteManager
     */
    private $voteManager;
    /**
     * @var VoteFinder
     */
    private $voteFinder;
    /**
     * @var VoteFactory
     */
    private $voteFactory;

    /**
     * VoteHandler constructor.
     *
     * @param VoteFinder  $voteFinder
     * @param VoteManager $voteManager
     * @param VoteFactory $voteFactory
     */
    public function __construct(VoteFinder $voteFinder, VoteManager $voteManager, VoteFactory $voteFactory)
    {
        $this->voteManager = $voteManager;
        $this->voteFinder  = $voteFinder;
        $this->voteFactory = $voteFactory;
    }

    /**
     * @param VotableInterface $votable
     * @param User             $user
     * @param int              $voteValue
     */
    public function handleVote(VotableInterface $votable, User $user, int $voteValue)
    {
        $vote = $this->voteFinder->findByVotableAndUser($votable, $user);

        if (!$vote) {
            $this->newVote($votable, $user, $voteValue);
        } else {
            $this->existingVote($votable, $vote, $voteValue);
        }

        $this->voteManager->flush();
    }

    /**
     * @param VotableInterface $votable
     * @param User             $user
     * @param int              $voteValue
     */
    private function newVote(VotableInterface $votable, User $user, int $voteValue)
    {
        $vote = $this->voteFactory->createVoteFromVotable($votable);
        $vote
            ->setUser($user)
            ->setValue($voteValue);

        $this->voteManager->persist($vote);

        if ($voteValue === VoteInterface::VALUE_UP) {
            $votable->setTotalVoteUp($votable->getTotalVoteUp() + 1);
        } else {
            $votable->setTotalVoteDown($votable->getTotalVoteDown() + 1);
        }
    }

    /**
     * @param VotableInterface $votable
     * @param VoteInterface    $vote
     * @param int              $voteValue
     */
    private function existingVote(VotableInterface $votable, VoteInterface $vote, int $voteValue)
    {
        $previousVote = $vote->getValue();
        $vote->setValue($voteValue);

        // If previous vote was the same as now we remove it
        if ($previousVote === $voteValue) {
            $votable->removeVote($vote);
            if ($previousVote === VoteInterface::VALUE_UP) {
                $votable->setTotalVoteUp($votable->getTotalVoteUp() - 1);
            } else {
                $votable->setTotalVoteDown($votable->getTotalVoteDown() - 1);
            }

            return;
        }

        if ($voteValue === VoteInterface::VALUE_UP) {
            $votable->setTotalVoteUp($votable->getTotalVoteUp() + 1);
            $votable->setTotalVoteDown($votable->getTotalVoteDown() - 1);
        } else {
            $votable->setTotalVoteDown($votable->getTotalVoteDown() + 1);
            $votable->setTotalVoteUp($votable->getTotalVoteUp() - 1);
        }
    }
}
