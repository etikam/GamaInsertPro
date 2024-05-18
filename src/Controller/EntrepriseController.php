<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\ResponsableEntreprise;
use App\Entity\OffreEntreprise;
use App\Entity\ProfilEntreprise;
use App\Entity\ProfilRecherche;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérez les données du formulaire
            $entreprise = new Entreprise();
            //class de Responsables
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $nomEntreprise = $request->request->get('nomEntreprise');
            $telephone = $request->request->get('telephone');


            // Offre Entreprise
            $typeOffre = $request->request->get('typeOffre');
            $description = $request->request->get('description');
            $dateCloture = $request->request->get('dateCloture');

            //Profil Recherche
            $tailleEntreprise = $request->request->get('tailleEntreprise');
            $secteurActivite = $request->request->get('secteur');
            $lieu = $request->request->get('lieu');
            $experienceRequise = $request->request->get('experience');
            $competencesRequises = $request->request->get('competence');
            $date_creation = $request->request->get('dateDepot');

            // Convertir la date et l'heure en objet DateTime
            $dateCloture = new \DateTime($dateCloture);

            // Créez et remplissez l'entité ResponsableEntreprise
            $responsable = new ResponsableEntreprise();
            $responsable->setNom($nom);
            $responsable->setPrenom($prenom);
            $responsable->setEmail($email);
            $responsable->setNomEntreprise($nomEntreprise);
            $responsable->setTelephone($telephone);

            // Sauvegardez l'entité ResponsableEntreprise dans la base de données
            $entityManager->persist($responsable);
            $entityManager->flush();

            // Créez et remplissez l'entité OffreEntreprise
            $offre = new OffreEntreprise();
            $offre->setType($typeOffre);
            $offre->setDescription($description);
            $offre->setDateLimite($dateCloture);

            // Sauvegardez l'entité OffreEntreprise dans la base de données
            $entityManager->persist($offre);
            $entityManager->flush();

            // Créez et remplissez l'entité ProfilEntreprise
            $profil = new ProfilRecherche();
            $profil->setTaille($tailleEntreprise);
            $profil->setDomaine($secteurActivite);
            $profil->setLieu($lieu);
            $profil->setExperience($experienceRequise);
            $profil->setCompetence($competencesRequises);
            $profil->setDateDepot(new \DateTime($date_creation));

            // Sauvegardez l'entité ProfilEntreprise dans la base de données
            $entityManager->persist($profil);
            $entityManager->persist($entreprise);
            $entityManager->flush();


            // Redirigez vers une route de succès
            return $this->redirectToRoute('app_entreprise'); // Remplacez par la route de votre choix
        }

        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }
}
