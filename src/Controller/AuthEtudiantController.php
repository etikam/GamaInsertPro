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

#[Route(path: '/auth')]
class AuthEtudiantController extends AbstractController
{
  
    // public function index(): Response
    // {
    //     return $this->render('authentification/index.html.twig', [
    //         'controller_name' => 'AuthEtudiantController',
    //     ]);
    // }

    #[Route('/check', name: 'app_register_etudiant')]
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


}


