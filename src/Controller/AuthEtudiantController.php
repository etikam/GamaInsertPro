<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Etudiant;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AuthEtudiantController extends AbstractController
{
    #[Route('/auth', name: 'app_auth_etudiant')]
    public function index(): Response
    {
        return $this->render('auth_etudiant/index.html.twig', [
            'controller_name' => 'AuthEtudiantController',
        ]);
    }

    #[Route('/inscrire', name: 'app_register_etudiant', methods: ['POST'])]
    public function register(Request $request, ManagerRegistry $doctrine): Response
    {
        // Récupérer les données du formulaire
        $matricule = $request->request->get('matricule');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');

        // Vérifier si l'étudiant existe
        $repository = $doctrine->getRepository(Etudiant::class);
        $etudiant = $repository->findOneBy([
            'matricule' => $matricule,
            'nom' => $nom,
            'prenom' => $prenom,
        ]);

        // Si l'étudiant existe, afficher la vue "activate_account.html.twig" avec les détails de l'étudiant
        if ($etudiant) {
            return $this->render('auth_etudiant/activate_account.html.twig', [
                'etudiant' => $etudiant,
            ]);
        } else {
            $this->addFlash('not_etudiant','Aucun match valide dans notre base de données');
            return $this->redirectToRoute('app_auth_etudiant');
        }
    }

    #[Route('/login', name: 'app_login_etudiant', methods: ['POST'])]
    public function login(Request $request, ManagerRegistry $doctrine): Response
    {
        // Récupérer les données du formulaire
        $matricule = $request->request->get('matricule');
        $password = $request->request->get('pswd');

        // Vérifier si l'étudiant existe avec les informations fournies
        $repository = $doctrine->getRepository(Etudiant::class);
        
        $etudiant = $repository->findOneBy([
            'matricule' => $matricule,
            'password' => $password, // Vous devez vérifier le mot de passe de manière sécurisée (hachage, etc.)
        ]);

        // Si l'étudiant existe, connecter l'utilisateur (exemple simplifié)
        if ($etudiant) {
            // Ici, vous mettriez en œuvre la logique de connexion réelle
            // Pour l'exemple, nous redirigeons simplement vers la page d'accueil
            return $this->redirectToRoute('app_homepage');
        } else {
            // Gérer le cas où l'authentification échoue
            $this->addFlash('error', 'Erreur d\'authentification. Veuillez vérifier vos informations.');
            // Pour l'exemple, redirigeons simplement vers la page de connexion
            return $this->redirectToRoute('app_auth_etudiant');
        }
    }
}


