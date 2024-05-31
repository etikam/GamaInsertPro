<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Departement;
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    public function searchEtudiants(?string $search, ?string $status, ?int $year, ?int $departementId, ?bool $handicap, ?string $genre, ?string $ageRange, ?string $en_voyage)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->leftJoin('e.departement', 'd');

        $searchTerm = '%' . strtolower($search) . '%';
        $handicapMapping = ['oui' => true, 'non' => false];

        if (array_key_exists(strtolower($search), $handicapMapping)) {
            $qb->andWhere('e.handicape = :handicap')
                ->setParameter('handicap', $handicapMapping[strtolower($search)]);
        } else {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('e.genre', ':search'),
                $qb->expr()->like('e.dateNaissance', ':search'),
                $qb->expr()->like('e.paysResidence', ':search'),
                $qb->expr()->like('d.nom', ':departement')
            ));
            $qb->setParameter('search', $searchTerm)
                ->setParameter('departement', $searchTerm);
        }

        if ($status) {
            $qb->andWhere('e.status = :status')
                ->setParameter('status', $status);
        }

        if ($year) {
            $qb->andWhere('e.annee = :year')
                ->setParameter('year', $year);
        }

        if ($departementId) {
            $qb->andWhere('d.id = :departement')
                ->setParameter('departement', $departementId);
        }

        if ($handicap !== null) {
            $qb->andWhere('e.handicape = :handicap')
                ->setParameter('handicap', $handicap);
        }


        if($genre){
            $qb->andWhere('e.genre = :genre')
                ->setParameter('genre', $genre);
        }

        if ($ageRange) {
            list($ageMin, $ageMax) = explode('-', $ageRange);

            $ageMin = $ageMin - 1;
            $ageMax = $ageMax +1;
            // Calcul de la date de naissance minimale et maximale en fonction des âges min et max
            $minBirthday = new \DateTime("-$ageMax years");
            $maxBirthday = new \DateTime("-$ageMin years");

            // Filtrer les étudiants dont la date de naissance est entre les dates calculées
            $qb->andWhere($qb->expr()->between('e.dateNaissance', ':minBirthday', ':maxBirthday'))
                ->setParameter('minBirthday', $minBirthday->format('Y-m-d'))
                ->setParameter('maxBirthday', $maxBirthday->format('Y-m-d'));
        }

        if ($en_voyage) {
            if ($en_voyage == 'non') {
                $qb->andWhere('e.paysResidence = :pays')
                    ->setParameter('pays', 'Guinée');
            } else if ($en_voyage == 'oui') {
                $qb->andWhere('e.paysResidence != :pays')
                    ->setParameter('pays', 'Guinée');
            }
        }

        return $qb->getQuery()->getResult();
    }
}
