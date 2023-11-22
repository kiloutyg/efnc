<?php

namespace App\Repository;

use App\Entity\UAP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UAP>
 *
 * @method UAP|null find($id, $lockMode = null, $lockVersion = null)
 * @method UAP|null findOneBy(array $criteria, array $orderBy = null)
 * @method UAP[]    findAll()
 * @method UAP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UAPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UAP::class);
    }

//    /**
//     * @return UAP[] Returns an array of UAP objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UAP
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
