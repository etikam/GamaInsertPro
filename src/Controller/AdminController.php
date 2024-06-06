<?php

namespace App\Controller;

use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Etudiant;
use App\Repository\EntrepriseRepository;
/*use Dompdf\Dompdf;
use Dompdf\Options;*/
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, EntityManagerInterface $em, EntrepriseRepository $entrepriseRepository): Response
    {
        $nombreDeFemmes = $this->countFemaleStudent($em);
        $handicapedPersons = $this->countPersonHandicap($em);
        $etudiantsEnVoyage = $this->countTravelerStudent($em);
        $compteurDeStatus = $this->countStatus($em);
        $compteurTotalStudent = $this->countStudent($em);
        $offre_entreprise = $entrepriseRepository->findAll();

        $context = [
            'nombreDeFemmes' => $nombreDeFemmes,
            'handicapedPersons' => $handicapedPersons,
            'etudiantsEnVoyage' => $etudiantsEnVoyage,
            'statusDesEtudiants' => $compteurDeStatus,
            'nombreTotalStudent' => $compteurTotalStudent,
            'message_entreprise' => $offre_entreprise
        ];

        return $this->render('admin/index.html.twig', $context);
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
            ->setParameter('handicape', "Oui");

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

    /*Pour la partie statistique de la page administrateur*/
    #[Route('/statistiques', name: 'app_statistiques')]
    public function stat(Request $request, EntityManagerInterface $em): Response
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
        return $this->render('admin/statistiques.html.twig',
            [
                'controller_name' => 'AdminController',
                'nombreDeFemmes' => $nombreDeFemmes,
                'handicapedPersons' => $handicapedPersons,
                'etudiantsEnVoyage' => $etudiantsEnVoyage,
                'statusDesEtudiants' => $compteurDeStatus,
                'nombreTotalStudent' => $compteurTotalStudent,
                'year'=> $year,
            ]);
    }

    public function tab(Request $request, EntityManagerInterface $em, $year, $status): Response
    {
        $repo = $em->getRepository(Etudiant::class);

        $search = $request->query->get('search', '');
        $departementId = $request->query->getInt('departement', 0); // Utilisation de 0 comme valeur par défaut
        $handicape =  $request->query->get('handicape');
        if ($handicape === '1') {
            $handicap = true;
        } elseif ($handicape === '0') {
            $handicap = false;
        } else {
            $handicap = null;
        }

        $genre = $request->query->getString('genre');
        $plageAge = $request->query->getString('age_range');
        $lieu = $request->query->getString('en_voyage');
        $word = $request->query->getBoolean('word', false);


        // Si le departementId est 0, le transformer en null pour la recherche
        $departementId = $departementId === 0 ? null : $departementId;

        $etudiants = $repo->searchEtudiants($search, $status, $year, $departementId, $handicap, $genre, $plageAge, $lieu);

        $departements = $em->getRepository(Departement::class)->findAll();

        if ($word) {
            // Génération du contenu HTML du document Word
            $html = $this->renderView('admin/tableau_pdf.html.twig', [
                'controller_name' => 'AdminController',
                'etudiants' => $etudiants,
                'status' => $status,
                'stat' => strtolower($status),
                'year' => $year,
                'search' => $search,
                'depart' => $departements,
                'departementId' => $departementId,
                'handicape' => $handicape,
                'genre' => $genre,
                'plageAge' => $plageAge,
                'etatVoyage' => $lieu
            ]);

            return new Response($html, 200, [
                'Content-Type' => 'application/vnd.ms-word',
                'Content-Disposition' => 'attachment; filename="rapport.doc"'
            ]);
        }

        return $this->render('admin/tableaux.html.twig', [
            'controller_name' => 'AdminController',
            'etudiants' => $etudiants,
            'status' => $status,
            'stat' => strtolower($status),
            'year' => $year,
            'search' => $search,
            'depart' => $departements,
            'departementId' => $departementId,
            'handicape' => $handicape,
            'genre' => $genre,
            'plageAge' => $plageAge,
            'etatVoyage' => $lieu
        ]);
    }
}