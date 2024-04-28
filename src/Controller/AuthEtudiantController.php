<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Etudiant;
use App\Entity\EtudiantNotActivate;
use App\Form\CheckExistenceType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AuthEtudiantController extends AbstractController
{
    #[Route('/login', name: 'app_auth_etudiant')]
    public function index(): Response
    {
        return $this->render('auth_etudiant/index.html.twig', [
            'controller_name' => 'AuthEtudiantController',
        ]);
    }

    #[Route('/inscrire', name: 'app_register_etudiant')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CheckExistenceType::class);
        $form->handleRequest($request);
                  
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Vérification des données dans la base de données
         
            $etudiant = $entityManager->getRepository(EtudiantNotActivate::class)->findOneBy([
                'matricule' => $data['matricule'],
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
            ]);

            if ($etudiant) {
                        // Redirection si toutes les vérifications sont passées

                        $this->addFlash("edit_info_msg","Vos informations sont à retenir");
                        return $this->redirectToRoute('app_register', [
                            'matricule' => $data['matricule']
                        ]);
                 }
                         
            
            // Si une vérification échoue, affichez un message d'erreur
            $this->addFlash("etudiant_not_existe", "Aucun étudiant correspondant trouvé");
        }
    
        

        return $this->render('check_existence/index.html.twig', [
            'controller_name' => 'CheckExistenceController',
            'checkform'=>$form->createView()
        ]);
    }



    #[Route('/connexion', name: 'app_login_etudiant', methods: ['POST'])]
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
            
            return $this->redirectToRoute('app_homepage');
        } else {
            // Gérer le cas où l'authentification échoue
            $this->addFlash('error', 'Erreur d\'authentification. Veuillez vérifier vos informations.');
            // Pour l'exemple, redirigeons simplement vers la page de connexion
            return $this->redirectToRoute('app_auth_etudiant');
        }
    }
}


