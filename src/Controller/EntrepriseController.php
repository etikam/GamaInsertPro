<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Offre;
use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use App\Repository\TypeOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/entreprise")]
class EntrepriseController extends AbstractController
{
    #[Route('/', name: 'app_entreprise')]
    public function index(): Response
    {

        return $this->render('entreprise/index.html.twig');
    }


    #[Route('/soumettre', name: 'app_soumettre')]
    public function put(Request $request, EntityManagerInterface $entityManager, TypeOffreRepository $typeOffreRepository): Response
    {
        $typeOffres = $typeOffreRepository->findAll();
        try {
            if ($request->isMethod('POST')) {
            // Récupérez les données du formulaire
            $entreprise = new Entreprise();
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $telephone = $request->request->get('telephone');
            $offreId = $request->request->get('typeOffre');
            $nomEntreprise = $request->request->get('nomEntreprise');
            $description = $request->request->get('description');
            $dateCloture = $request->request->get('dateCloture');
            $tailleEntreprise = $request->request->get('taille');
            $prenom = $request->request->get('prenom');
            $secteurActivite = $request->request->get('secteur');
            $localisation = $request->request->get('lieu');
            $experienceRequise = $request->request->get('experience');
            $competencesRequises = $request->request->get('competence');
            $dateCreation = $request->request->get('dateDepot');

            $mailResponsable = $request->request->get('mail');
            $telResponsable = $request->request->get('tel');
            $niveau = $request->request->get('niveau');
            $domainRecherche = $request->request->get('domaine');
            $dateEnvoi = new \DateTime('now');

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
            $entreprise->setEmailResponsable($mailResponsable);
            $entreprise->setTelResponsable($telResponsable);
            $entreprise->setNiveauRecherche($niveau);
            $entreprise->setDomaineRecherche($domainRecherche);
            $entreprise->setDateEnvoi($dateEnvoi);
            $entreprise->setStatut(false);


            // Persist the entity to the database
            $entityManager->persist($entreprise);
            $entityManager->flush();
            $this->addFlash(
               'success',
               'Votre offre à été soumis avec succès ! '
            );
            return $this->redirectToRoute('app_entreprise');
        }
        } catch (\Exception $e) {
            $this->addFlash(
               'danger',
               'Votre formulaire n\'a pas été soumise !'
            );
            return $this->redirectToRoute('app_entreprise');
        }


        return $this->render('entreprise/soumettre.html.twig', [
            'typeOffres' => $typeOffres,
        ]);
    }

    #[Route('/offre', name: 'app_offreEntreprise')]
    public function index2( EntrepriseRepository $entrepriseRepository, TypeOffreRepository $typeOffreRepository, OffreRepository $offreRepository): Response
    {
        $offreEntreprise = $entrepriseRepository->findAll();
        $offrePublie = $offreRepository->findAll();
        $context = ['offre_entreprises'=> $offreEntreprise,
        'offre_publies'=> $offrePublie,
        'typeOffres' => $typeOffreRepository->findAll(),
    ];

        return $this->render('entreprise/gestion_offre.html.twig', $context);
    }

    #[Route('/{id}', name: 'app_showEntreprise')]
    public function show(Entreprise $offreEntreprise ): Response
    {
        $context = ['offre_entreprise'=> $offreEntreprise];

        return $this->render('entreprise/show.html.twig', $context);
    }
    #[Route('/publier/{id}', name: 'app_publier')]
    public function postule(Entreprise $offreEntreprise, Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            // Vérifiez si le statut de l'offre est déjà publié
        if ($offreEntreprise->isStatut() === true) {
            $this->addFlash('warning', 'Cette offre a déjà été publiée.');
            return $this->redirectToRoute('app_offreEntreprise');
        }
            $toffre = $offreEntreprise->getFkTypeOffre();

            $offre = new Offre();
            $offre->setNomEntreprise($offreEntreprise->getNomEntreprise());
            $offre->setDescription($offreEntreprise->getDescription());
            $offre->setEmail($offreEntreprise->getEmail());
            $offre->setTelephone($offreEntreprise->getTelephone());
            $offre->setDateDebut($offreEntreprise->getDateCreation());
            $offre->setDateLimite($offreEntreprise->getDateLimite());

            // Si vous avez une seule relation avec un type d'offre, vous pouvez l'ajouter directement
            if ($toffre !== null && !$toffre->isEmpty()) {
                $offre->setFkTypeOffre($toffre->first());
            }
    $offre->setNomOffre($toffre->first()->getNom());
            $offre->setImage(""); 
            $offre->setDateCreate(new \DateTime('now')); 
            $offreEntreprise->setStatut(true);


            // Enregistrement de l'offre dans la base de données
            $entityManager->persist($offre);
            $entityManager->flush();

            // Message flash pour indiquer que l'opération s'est bien déroulée
            $this->addFlash('success', 'Offre ajoutée avec succès.');
        } catch (\Exception $e) {
            // En cas d'erreur, ajoutez un message flash d'erreur
            $this->addFlash('error', 'Une erreur est survenue lors de l\'ajout de l\'offre.');
        }

        // Redirection vers une page appropriée
        return $this->redirectToRoute('app_offreEntreprise');
    }

}
