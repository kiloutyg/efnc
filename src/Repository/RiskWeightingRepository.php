<?php

namespace App\Repository;

use App\Entity\RiskWeighting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RiskWeighting>
 *
 * @method RiskWeighting|null find($id, $lockMode = null, $lockVersion = null)
 * @method RiskWeighting|null findOneBy(array $criteria, array $orderBy = null)
 * @method RiskWeighting[]    findAll()
 * @method RiskWeighting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RiskWeightingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RiskWeighting::class);
    }

//    /**
//     * @return RiskWeighting[] Returns an array of RiskWeighting objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RiskWeighting
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
