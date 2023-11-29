<?php

namespace App\Repository;

use App\Entity\ImmediateConservatoryMeasuresList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImmediateConservatoryMeasuresList>
 *
 * @method ImmediateConservatoryMeasuresList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImmediateConservatoryMeasuresList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImmediateConservatoryMeasuresList[]    findAll()
 * @method ImmediateConservatoryMeasuresList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmediateConservatoryMeasuresListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImmediateConservatoryMeasuresList::class);
    }

//    /**
//     * @return ImmediateConservatoryMeasuresList[] Returns an array of ImmediateConservatoryMeasuresList objects
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

//    public function findOneBySomeField($value): ?ImmediateConservatoryMeasuresList
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
