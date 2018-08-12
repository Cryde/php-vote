<?php

namespace App\Services;

use App\Entity\VotableInterface;
use Doctrine\ORM\EntityManagerInterface;

class VotableClassNameResolver
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getName(VotableInterface $votable)
    {
        return $this->entityManager->getClassMetadata(get_class($votable))->getName();
    }
}
