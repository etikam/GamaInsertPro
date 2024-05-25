<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\TypeOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(): Response
    {

        return $this->render('entreprise/index.html.twig');
    }


    #[Route('/soumettre', name: 'app_soumettre')]
    public function put(Request $request, EntityManagerInterface $entityManager, TypeOffreRepository $typeOffreRepository): Response
    {
        $typeOffres = $typeOffreRepository->findAll();

        if ($request->isMethod('POST')) {
            // Récupérez les données du formulaire
            $entreprise = new Entreprise();
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $nomEntreprise = $request->request->get('nomEntreprise');
            $telephone = $request->request->get('telephone');
            $offreId = $request->request->get('typeOffre');
            $description = $request->request->get('description');
            $dateCloture = $request->request->get('dateCloture');
            $tailleEntreprise = $request->request->get('taille');
            $secteurActivite = $request->request->get('secteur');
            $localisation = $request->request->get('lieu');
            $experienceRequise = $request->request->get('experience');
            $competencesRequises = $request->request->get('competence');
            $dateCreation = $request->request->get('dateDepot');

            // Validate and convert date fields
            try {
                $dateCloture = new \DateTime($dateCloture);
            } catch (\Exception $e) {
                return new Response('Invalid date format for dateCloture', Response::HTTP_BAD_REQUEST);
            }

            try {
                $dateCreation = new \DateTime($dateCreation);
            } catch (\Exception $e) {
                return new Response('Invalid date format for dateCreation', Response::HTTP_BAD_REQUEST);
            }

            // Retrieve the TypeOffre entity
            $tOffre = $typeOffreRepository->findOneBy(['id' => $offreId]);
            if (!$tOffre) {
                return new Response('Invalid typeOffre', Response::HTTP_BAD_REQUEST);
            }

            // Set the Entreprise entity properties
            $entreprise->setNom($nom);
            $entreprise->setPrenom($prenom);
            $entreprise->setEmail($email);
            $entreprise->setNomEntreprise($nomEntreprise);
            $entreprise->setTelephone($telephone);
            $entreprise->addFkTypeOffre($tOffre);
            $entreprise->setDateLimite($dateCloture);
            $entreprise->setDescription($description);
            $entreprise->setTaille($tailleEntreprise);
            $entreprise->setDomaine($secteurActivite);
            $entreprise->setLieu($localisation);
            $entreprise->setExperience($experienceRequise);
            $entreprise->setCompetence($competencesRequises);
            $entreprise->setDateCreation($dateCreation);

            // Persist the entity to the database
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('entreprise/soumettre.html.twig', [
            'typeOffres' => $typeOffres,
        ]);
    }

}
