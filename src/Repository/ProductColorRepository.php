<?php

namespace App\Repository;

use App\Entity\ProductColor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductColor>
 *
 * @method ProductColor|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductColor|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductColor[]    findAll()
 * @method ProductColor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductColorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductColor::class);
    }

//    /**
//     * @return ProductColor[] Returns an array of ProductColor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductColor
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
