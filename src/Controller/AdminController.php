<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Etudiant;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $em): Response
    {
        $nombreDeFemmes = $this->countFemaleStudent($em);
        $handicapedPersons = $this->countPersonHandicap($em);
        $etudiantsEnVoyage = $this->countTravelerStudent($em);
        $compteurDeStatus = $this->countStatus($em);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'nombreDeFemmes' => $nombreDeFemmes,
            'handicapedPersons' => $handicapedPersons,
            'etudiantsEnVoyage' => $etudiantsEnVoyage,
            'statusDesEtudiants' => $compteurDeStatus,
        ]);
    }

    private function countFemaleStudent(EntityManagerInterface $em): int
    {
        $repo = $em->getRepository(Etudiant::class);

        return $repo->count(['genre' => 'Feminin']);
    }

    private function countPersonHandicap(EntityManagerInterface $em): int
    {
        $repo = $em->getRepository(Etudiant::class);

        return $repo->count(['handicape' => 'oui']);
    }

    private function countTravelerStudent(EntityManagerInterface $em): int
    {
        $repo = $em->getRepository(Etudiant::class);

        $qb = $repo->createQueryBuilder('e');
        $qb->select('COUNT(e.id)');
        $qb->where($qb->expr()->neq('e.paysResidence', ':country'));
        $qb->setParameter('country', 'Guinee');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /*private function countEmployes(EntityManagerInterface $em): int
    {
        $repo = $em->getRepository(Etudiant::class);

        return $repo->count(['status' => 'Employé']);
    }

    private function countStagiaires(EntityManagerInterface $em): int
    {
        $repo = $em->getRepository(Etudiant::class);

        return $repo->count(['status' => 'Stage']);
    }

    private function countChomeurs(EntityManagerInterface $em): int
    {
        $repo = $em->getRepository(Etudiant::class);

        return $repo->count(['status' => 'Chômeur']);
    }*/

    //La fonction doit compter le nombre d'etudiants pour chaque status et ajouter la valeur dans le dictionnaire status à la clé correspondante
    private function countStatus(EntityManagerInterface $em): array
    {
        $repo = $em->getRepository(Etudiant::class);
        $status = ['Employé' => 0, 'Stage' => 0, 'Chômeur' => 0, 'Entrepreneur' => 0];

        foreach ($status as $key => $value) {
            $status[$key] = $repo->count(['status' => $key]);
        }

        return $status;
    }
}
