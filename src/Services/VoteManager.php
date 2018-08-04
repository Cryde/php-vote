<?php

namespace App\Services;

use App\Entity\Vote;
use Doctrine\ORM\EntityManagerInterface;

class VoteManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * VoteManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Vote $vote
     */
    public function persist(Vote $vote)
    {
        $this->entityManager->persist($vote);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}
