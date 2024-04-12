<?php

namespace App\Repository;

use App\Entity\Concentration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concentration>
 *
 * @method Concentration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concentration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concentration[]    findAll()
 * @method Concentration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcentrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concentration::class);
    }

    //    /**
    //     * @return Concentration[] Returns an array of Concentration objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Concentration
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
