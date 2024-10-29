<?php

namespace App\Repository;

use App\Entity\X;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<X>
 *
 * @method X|null find($id, $lockMode = null, $lockVersion = null)
 * @method X|null findOneBy(array $criteria, array $orderBy = null)
 * @method X[]    findAll()
 * @method X[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, X::class);
    }

//    /**
//     * @return X[] Returns an array of X objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('x')
//            ->andWhere('x.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('x.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?X
//    {
//        return $this->createQueryBuilder('x')
//            ->andWhere('x.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
