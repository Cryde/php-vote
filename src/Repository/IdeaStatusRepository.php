<?php

namespace App\Repository;

use App\Entity\IdeaStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IdeaStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdeaStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdeaStatus[]    findAll()
 * @method IdeaStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdeaStatus::class);
    }

//    /**
//     * @return IdeaStatus[] Returns an array of IdeaStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IdeaStatus
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
