<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // dd($this->getUser());
        

        if ($this->getUser()) {
            // Redirection en fonction du rôle de l'utilisateur
            $user = $this->getUser();
            $roles = $user->getRoles();
            //dd($roles);
            
            if (in_array('ROLE_ADMIN', $roles)) {
                //dd($roles);
                return $this->redirectToRoute('app_admin'); //redirection à l'interface d'administration si l'utilisateur possède un role ROLES_ADMIN
            } else {
                return $this->redirectToRoute('app_accueil');// Redirection à l'interface Etudiant pour tous utilisateur avec le role ROLES_USER uniquement
            }
        }
        // return $this->render('authentification/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        return $this->render('auth_etudiant/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
