<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index( OffreRepository $offreRepository): Response
    {
        $offreRecents = $offreRepository->findThreeMostRecent();
        $offre = $offreRepository->findAll();
        $nbOffreRecent = count($offre);
        $context = [
            'offreRecents' => $offreRecents,
            'nbOffres' => $nbOffreRecent
        ];
        return $this->render('accueil/index.html.twig',$context);
    }
}
