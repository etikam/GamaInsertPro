<?php

namespace App\Repository;

use App\Entity\ResponsableEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResponsableEntreprise>
 *
 * @method ResponsableEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponsableEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponsableEntreprise[]    findAll()
 * @method ResponsableEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponsableEntreprise::class);
    }

    //    /**
    //     * @return ResponsableEntreprise[] Returns an array of ResponsableEntreprise objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ResponsableEntreprise
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
