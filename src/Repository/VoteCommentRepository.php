<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\VoteComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VoteComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoteComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoteComment[]    findAll()
 * @method VoteComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoteComment::class);
    }

    public function findByCommentIdsAndUser(array $ids, User $user)
    {
        return $this->createQueryBuilder('voteComment')
                    ->select('voteComment')
                    ->join('voteComment.comment', 'comment')
                    ->where('voteComment.user = :user')
                    ->andWhere('voteComment.comment in (:ids)')
                    ->setParameter('user', $user)
                    ->setParameter('ids', $ids)
                    ->getQuery()
                    ->getResult();
    }
}
