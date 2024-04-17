<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\EtudiantNotActivate;
use App\Entity\Etudiant;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(LoggerInterface $logger, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // try{

        
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $test = $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                // dd($user);
                //Récuperation des donnée du formulaire
                $username = $form->get('username')->getData();
                $email = $form->get('email')->getData();
                $confirmPassword = $form->get('confirmPassword')->getData();
                $password = $form->get('plainPassword')->getData();
                // hasher le mot de pass
                //dd($confirmPassword);
               if($confirmPassword == $password){
                //dd($confirmPassword);
                    //dd($password);
                    //verification si l'etudiant existe 
                    $etudiantExiste = $entityManager->getRepository(EtudiantNotActivate::class)
                    ->findOneBy(['matricule' => $username]);

                    if($etudiantExiste !== null){
                        //creer le deuxieme tables
                        $etudiant = new Etudiant();
                        //copier les donnes dans la base de données 
                        $etudiant->setUsername($username);
                        $etudiant->setEmail($email);
                        
                        $etudiant->setPassword(
                            $userPasswordHasher->hashPassword(
                                $etudiant, // Utiliser $etudiant ici au lieu de $user
                                $form->get('plainPassword')->getData()
                            )
                        );
                        $etudiant->setNom($etudiantExiste->getNom());
                        $etudiant->setPrenom($etudiantExiste->getPrenom());
                        $etudiant->setGenre($etudiantExiste->getGenre());
                        $etudiant->setHandicape($etudiantExiste->isHandicape());
                        $etudiant->setDateNaissance($etudiantExiste->getDateNaissance());
                        $etudiant->setPaysResidence($etudiantExiste->getPaysResidence());
                        $etudiant->setAdresse($etudiantExiste->getAdresse());
                        $etudiant->setEncours($etudiantExiste->isEncours());
                        $etudiant->setNiveau($etudiantExiste->getNiveau());
                        //Mise à jour de la base de données
                        $entityManager->remove($etudiantExiste);
                        //Enregistrement des données de l'etudiant dans la base de données
                        $entityManager->persist($etudiant);
                        $entityManager->flush();
                        $this->addFlash(
                            'success',
                            'password et confirm password sont inconrrect ! '
                         );
                        return $this->redirectToRoute('app_login');
                    } else
                    {
                        return $this->redirectToRoute('app_register');

                    }
               } else{
                $this->addFlash(
                   'danger',
                   'password et confirm password sont inconrrect ! '
                );
                return $this->redirectToRoute('app_register');
               }
                
            } 


            // do anything else you need here, like send an email

        // }catch (\Exception $e) {
        //         // Capturer et enregistrer l'exception dans les logs
                
        //         $logger->error('Une exception a été levée lors du traitement de l\'inscription : ' . $e->getMessage());
                
        //         // Gérer l'exception (redirection, affichage d'un message d'erreur, etc.)
        //         return $this->redirectToRoute('app_register');
        //     }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
