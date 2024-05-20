<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index( Request $request, EntityManagerInterface $entityManager ): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérez les données du formulaire
            $entreprise = new Entreprise();
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $nomEntreprise = $request->request->get('nomEntreprise');
            $telephone = $request->request->get('telephone');
            $typeOffre = $request->request->get('typeOffre');
            $description = $request->request->get('description');
            $dateCloture = $request->request->get('dateCloture');
            $tailleEntreprise = $request->request->get('taille');
            $secteurActivite = $request->request->get('secteur');
            $localisation = $request->request->get('lieu');
            $experienceRequise = $request->request->get('experience');
            $competencesRequises = $request->request->get('competence');
            $dateCloture = new \DateTime($dateCloture);
            //$date_creation = new \DateTime('now');
            $date_creation = $request->request->get('dateDepot');
            $date_creation = new \DateTime($date_creation);

            // Entregistrement des donnés dans la base de données
            $entreprise->setNom($nom);
            $entreprise->setPrenom($prenom);
            $entreprise->setEmail($email);
            $entreprise->setNomEntreprise($nomEntreprise);
            $entreprise->setTelephone($telephone);
            $entreprise->setType($typeOffre);
            $entreprise->setDateLimite($dateCloture);
            $entreprise->setDescription($description);
            $entreprise->setTaille($tailleEntreprise);
            $entreprise->setDomaine($secteurActivite);
            $entreprise->setLieu($localisation);
            $entreprise->setExperience($experienceRequise);
            $entreprise->setCompetence($competencesRequises);
            $entreprise->setDateCreation($date_creation);

            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        } else {
            return $this->render('entreprise/index.html.twig');
        }
        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }
}
