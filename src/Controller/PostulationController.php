<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Offre;
use App\Entity\Postulation;
use App\Repository\PostulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\PostDec;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostulationController extends AbstractController
{
    #[Route('/postulation', name: 'app_postulation')]
    public function index(PostulationRepository $postulationRepository): Response
    {

        $postulants = $postulationRepository->findAll();
        return $this->render('postulation/index.html.twig', [
            'postulants' => $postulants,
        ]);
    }
    #[Route('/postule/{id}', name: 'app_postule')]
    public function postule(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $etudiantConnect = $user->etudiant;
        if (!$etudiantConnect) {
            throw $this->createNotFoundException('No etudiant found for the current user.');
        }

        $idEtudiant = $etudiantConnect->getId();
        $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(['id' => $idEtudiant]);
        if (!$etudiant) {
            throw $this->createNotFoundException('No etudiant found for id ' . $idEtudiant);
        }
        // Trouver l'entité Offre
        $offre = $entityManager->getRepository(Offre::class)->find($id);
        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée.');
        }
        // Si une postulation existe déjà, afficher un message flash et rediriger
        if ($etudiant->aDejaPostulePourOffre($offre)) {
            $this->addFlash('warning', 'Vous avez déjà postulé pour cette offre.');
            return $this->redirectToRoute('app_notification');
        }


        // Créer une nouvelle postulation pour l'étudiant connecté
        $postulation = new Postulation();
        $postulation->setDatePostulation(new \DateTime('now'));
        $postulation->setOffre($offre);
        $postulation->setEtudiant($etudiant);

        $entityManager->persist($postulation);
        $entityManager->flush();

        // Rediriger vers une page de confirmation ou toute autre page
        $this->addFlash('success', 'Votre postulation a été envoyée avec succès.');

        return $this->redirectToRoute('app_notification');
        return $this->render('postulation/index.html.twig', [
            'controller_name' => 'PostulationController',
        ]);
    }
}
