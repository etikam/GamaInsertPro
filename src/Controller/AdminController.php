<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Etudiant;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $year  = $request->query->get('year');
        if ($year) {
            $nombreDeFemmes = $this->countFemaleStudent($em, $year);
            $handicapedPersons = $this->countPersonHandicap($em, $year);
            $etudiantsEnVoyage = $this->countTravelerStudent($em, $year);
            $compteurDeStatus = $this->countStatus($em, $year);
            $compteurTotalStudent = $this->countStudent($em, $year);

        }
        else {
            $nombreDeFemmes = $this->countFemaleStudent($em);
            $handicapedPersons = $this->countPersonHandicap($em);
            $etudiantsEnVoyage = $this->countTravelerStudent($em);
            $compteurDeStatus = $this->countStatus($em);
            $compteurTotalStudent = $this->countStudent($em);
        }


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'nombreDeFemmes' => $nombreDeFemmes,
            'handicapedPersons' => $handicapedPersons,
            'etudiantsEnVoyage' => $etudiantsEnVoyage,
            'statusDesEtudiants' => $compteurDeStatus,
            'nombreTotalStudent' => $compteurTotalStudent
        ]);
    }

    private function countFemaleStudent(EntityManagerInterface $em, $year = null): int
    {
        $repo = $em->getRepository(Etudiant::class);
        $query = $repo->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.genre = :genre')
            ->setParameter('genre', 'Feminin');

        if ($year !== null) {
            $query->andWhere('e.annee = :year')
                ->setParameter('year', $year);
        }

        return (int) $query->getQuery()->getSingleScalarResult();
    }

    private function countStudent(EntityManagerInterface $em, $year = null): int
    {
        $repo = $em->getRepository(Etudiant::class);
        $query = $repo->createQueryBuilder('e')
            ->select('COUNT(e.id)');

        if ($year !== null) {
            $query->andWhere('e.annee = :year')
                ->setParameter('year', $year);
        }

        return (int) $query->getQuery()->getSingleScalarResult();
    }

    private function countPersonHandicap(EntityManagerInterface $em, $year = null): int
    {
        $repo = $em->getRepository(Etudiant::class);
        $query = $repo->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.handicape = :handicape')
            ->setParameter('handicape', true);

        if ($year !== null) {
            $query->andWhere('e.annee = :year')
                ->setParameter('year', $year);
        }
        return (int) $query->getQuery()->getSingleScalarResult();
    }


    //La fonction doit compter le nombre d'etudiants pour chaque status et ajouter la valeur dans le dictionnaire status à la clé correspondante
    private function countStatus(EntityManagerInterface $em, $year = null): array
    {
        $repo = $em->getRepository(Etudiant::class);
        $status = ['Employé' => 0, 'Stage' => 0, 'Chômeur' => 0, 'Entrepreneur' => 0, 'En formation'=> 0];

        foreach ($status as $key => &$value) {
            $query = $repo->createQueryBuilder('e')
                ->select('COUNT(e.id)')
                ->where('e.status = :status')
                ->setParameter('status', $key);

            if ($year !== null) {
                $query->andWhere('e.annee = :year')
                    ->setParameter('year', $year);
            }

            $value = (int) $query->getQuery()->getSingleScalarResult();
        }
        return $status;
    }

    private function countTravelerStudent(EntityManagerInterface $em, $year = null): int
    {
        $repo = $em->getRepository(Etudiant::class);

        $qb = $repo->createQueryBuilder('e');
        $qb->select('COUNT(e.id)');
        $qb->where($qb->expr()->neq('e.paysResidence', ':country'));
        $qb->setParameter('country', 'Guinee');

        if ($year !== null) {
            $qb->andWhere('e.annee = :year')
                ->setParameter('year', $year);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    #[Route('/statistique', name: 'Statistique')]
    private function Statistique()
    {

    }
}