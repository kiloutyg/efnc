<?php

namespace App\Repository;

use App\Entity\BoughtComponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoughtComponent>
 *
 * @method BoughtComponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoughtComponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoughtComponent[]    findAll()
 * @method BoughtComponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoughtComponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoughtComponent::class);
    }

//    /**
//     * @return BoughtComponent[] Returns an array of BoughtComponent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BoughtComponent
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
