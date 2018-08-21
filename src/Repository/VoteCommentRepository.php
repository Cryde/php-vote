<?php

namespace App\Repository;

use App\Entity\VoteComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VoteComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoteComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoteComment[]    findAll()
 * @method VoteComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VoteComment::class);
    }
}
