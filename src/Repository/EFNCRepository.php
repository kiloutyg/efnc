<?php

namespace App\Repository;

use App\Entity\EFNC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EFNC>
 *
 * @method EFNC|null find($id, $lockMode = null, $lockVersion = null)
 * @method EFNC|null findOneBy(array $criteria, array $orderBy = null)
 * @method EFNC[]    findAll()
 * @method EFNC[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EFNCRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EFNC::class);
    }

    public function getMonthOldLowLevelRiskEfnc()
    {
        $date = new \DateTime();
        $date->modify('-1 month');
        $date = $date->format('Y-m-d');
        return $this->createQueryBuilder('e')
            ->leftJoin('e.riskWeighting', 'r')
            ->andWhere('r.RiskPriorityIndex < :val')
            ->andWhere('e.CreatedAt < :date')
            ->andWhere('e.closed IS NULL')
            ->andWhere('e.archived IS NULL')
            ->setParameter('val', '100')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return EFNC[] Returns an array of EFNC objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EFNC
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
