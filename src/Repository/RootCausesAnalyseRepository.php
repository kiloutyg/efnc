<?php

namespace App\Repository;

use App\Entity\RootCausesAnalyse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RootCausesAnalyse>
 *
 * @method RootCausesAnalyse|null find($id, $lockMode = null, $lockVersion = null)
 * @method RootCausesAnalyse|null findOneBy(array $criteria, array $orderBy = null)
 * @method RootCausesAnalyse[]    findAll()
 * @method RootCausesAnalyse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RootCausesAnalyseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RootCausesAnalyse::class);
    }

//    /**
//     * @return RootCausesAnalyse[] Returns an array of RootCausesAnalyse objects
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

//    public function findOneBySomeField($value): ?RootCausesAnalyse
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
