<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EtudiantRepository;

#[Route("/etudiant")]
class GestionEtudiantController extends AbstractController
{
    #[Route('/', name: 'app_gestion_etudiant')]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('gestion_etudiant/index.html.twig', [
            'controller_name' => 'GestionEtudiantController',
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route("/profil", name: "app_add_etudiant")]
    public function show():Response
    {
        return $this->render('null');
    }
}
