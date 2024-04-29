<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\EtudiantNotActivate;
use App\Form\CheckExistenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckExistenceController extends AbstractController
{
    // #[Route('/check/existence', name: 'app_check_existence')]
    // public function index(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(CheckExistenceType::class);
    //     $form->handleRequest($request);
                  
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $data = $form->getData();
    //         // Vérification des données dans la base de données
    //         $etudiant = $entityManager->getRepository(EtudiantNotActivate::class)->findOneBy([
    //             'matricule' => $data['matricule'],
    //             'prenom' => $data['prenom'],
    //             'nom' => $data['nom']
    //         ]);

    //         if ($etudiant) {
    //             // Redirection si l'étudiant existe
    //             return $this->redirectToRoute('app_auth_etudiant');
    //         } else {
    //             // Message d'erreur si l'étudiant n'existe pas
    //             $this->addFlash("auth_error", "Informations non valides");
    //         }
    //     }

    //     return $this->render('check_existence/index.html.twig', [
    //         'controller_name' => 'CheckExistenceController',
    //         'checkform' => $form->createView(),
    //     ]);
    // }
}
