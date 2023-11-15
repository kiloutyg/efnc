<?php

namespace App\Repository;

use App\Entity\CorrectivePreventiveActionPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CorrectivePreventiveActionPlan>
 *
 * @method CorrectivePreventiveActionPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method CorrectivePreventiveActionPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method CorrectivePreventiveActionPlan[]    findAll()
 * @method CorrectivePreventiveActionPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorrectivePreventiveActionPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorrectivePreventiveActionPlan::class);
    }

//    /**
//     * @return CorrectivePreventiveActionPlan[] Returns an array of CorrectivePreventiveActionPlan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CorrectivePreventiveActionPlan
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
