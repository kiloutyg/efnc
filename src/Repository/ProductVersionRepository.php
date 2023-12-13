<?php

namespace App\Repository;

use App\Entity\ProductVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductVersion>
 *
 * @method ProductVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductVersion[]    findAll()
 * @method ProductVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVersion::class);
    }

//    /**
//     * @return ProductVersion[] Returns an array of ProductVersion objects
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

//    public function findOneBySomeField($value): ?ProductVersion
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
