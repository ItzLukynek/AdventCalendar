<?php

namespace App\Repository;

use App\Entity\O;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<O>
 *
 * @method O|null find($id, $lockMode = null, $lockVersion = null)
 * @method O|null findOneBy(array $criteria, array $orderBy = null)
 * @method O[]    findAll()
 * @method O[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ORepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, O::class);
    }

//    /**
//     * @return O[] Returns an array of O objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?O
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
