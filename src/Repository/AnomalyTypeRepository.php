<?php

namespace App\Repository;

use App\Entity\AnomalyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnomalyType>
 *
 * @method AnomalyType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnomalyType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnomalyType[]    findAll()
 * @method AnomalyType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnomalyTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnomalyType::class);
    }

//    /**
//     * @return AnomalyType[] Returns an array of AnomalyType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnomalyType
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
