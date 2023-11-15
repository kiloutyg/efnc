<?php

namespace App\Repository;

use App\Entity\ImmediateConservatoryMeasures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImmediateConservatoryMeasures>
 *
 * @method ImmediateConservatoryMeasures|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImmediateConservatoryMeasures|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImmediateConservatoryMeasures[]    findAll()
 * @method ImmediateConservatoryMeasures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmediateConservatoryMeasuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImmediateConservatoryMeasures::class);
    }

//    /**
//     * @return ImmediateConservatoryMeasures[] Returns an array of ImmediateConservatoryMeasures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImmediateConservatoryMeasures
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
