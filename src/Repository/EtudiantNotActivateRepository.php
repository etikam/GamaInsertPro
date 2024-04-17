<?php

namespace App\Repository;

use App\Entity\EtudiantNotActivate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtudiantNotActivate>
 *
 * @method EtudiantNotActivate|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtudiantNotActivate|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtudiantNotActivate[]    findAll()
 * @method EtudiantNotActivate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantNotActivateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtudiantNotActivate::class);
    }

    //    /**
    //     * @return EtudiantNotActivate[] Returns an array of Etudiant objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Etudiant
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
