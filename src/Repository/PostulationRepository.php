<?php

namespace App\Repository;

use App\Entity\Postulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Postulation>
 *
 * @method Postulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postulation[]    findAll()
 * @method Postulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postulation::class);
    }

    //    /**
    //     * @return Postulation[] Returns an array of Postulation objects
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

    //    public function findOneBySomeField($value): ?Postulation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function retained(?string $entrepriseNom = null, ?string $tpOffre = null, ?string $depart = null): array
    {
        $qb = $this->createQueryBuilder('p') // Utilisation de l'alias 'p' pour Postulation
        ->leftJoin('p.offre', 'o') // Jointure avec Offre
        ->leftJoin('p.etudiant', 'et') // Jointure avec Etudiant
        ->leftJoin('et.departement', 'd') // Jointure avec Departement

        ->where('p.etat = :etat') // Condition sur l'état
        ->setParameter('etat', true);

        if ($entrepriseNom) {
            $qb->andWhere('o.nomEntreprise = :entrepriseNom') // Filtre par nom de l'entreprise
            ->setParameter('entrepriseNom', $entrepriseNom);
        }

        if ($tpOffre) {
            $qb->andWhere('o.nomOffre = :tpOffre') // Filtre par nom de l'offre
            ->setParameter('tpOffre', $tpOffre);
        }

        if ($depart) {
            $qb->andWhere('d.nom = :depart') // Filtre par nom du département
            ->setParameter('depart', $depart);
        }

        return $qb->getQuery()
            ->getResult();
    }

}
