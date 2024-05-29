<?php

namespace App\Controller;

use App\Entity\Postulation;
use App\Repository\PostulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/postulation')]
class PostulationController extends AbstractController
{
    #[Route('/', name: 'app_postulation')]
    public function index(PostulationRepository $postulationRepository): Response
    {
        $postulation = $postulationRepository->findAll();
        $context = [
            'postulations'=> $postulation
        ];
        return $this->render('postulation/index.html.twig', $context);
    }

    #[Route('/new', name: 'app_new_postulation')]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $context = [
            'postulations'=> ''
        ];
        return $this->render('postulation/postule.html.twig', $context);
    }

    #[Route('/{id}', name: 'app_show_postulation')]
    public function show(Postulation $postulation): Response
    {

        $context = [
            'postulation'=> $postulation
        ];
        return $this->render('postulation/show.html.twig', $context);
    }
}
