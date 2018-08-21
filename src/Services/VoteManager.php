<?php

namespace App\Services;

use App\Entity\VoteInterface;
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
     * @param VoteInterface $vote
     */
    public function persist(VoteInterface $vote)
    {
        $this->entityManager->persist($vote);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}
