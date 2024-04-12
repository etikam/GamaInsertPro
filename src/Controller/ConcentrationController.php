<?php

namespace App\Controller;

use App\Entity\Concentration;
use App\Form\ConcentrationType;
use App\Repository\ConcentrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/concentration')]
class ConcentrationController extends AbstractController
{
    #[Route('/', name: 'app_concentration_index', methods: ['GET'])]
    public function index(ConcentrationRepository $concentrationRepository): Response
    {
        return $this->render('concentration/index.html.twig', [
            'concentrations' => $concentrationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_concentration_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $concentration = new Concentration();
        $form = $this->createForm(ConcentrationType::class, $concentration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($concentration);
            $entityManager->flush();

            return $this->redirectToRoute('app_concentration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('concentration/new.html.twig', [
            'concentration' => $concentration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_concentration_show', methods: ['GET'])]
    public function show(Concentration $concentration): Response
    {
        return $this->render('concentration/show.html.twig', [
            'concentration' => $concentration,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_concentration_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Concentration $concentration, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConcentrationType::class, $concentration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_concentration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('concentration/edit.html.twig', [
            'concentration' => $concentration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_concentration_delete', methods: ['POST'])]
    public function delete(Request $request, Concentration $concentration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concentration->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($concentration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_concentration_index', [], Response::HTTP_SEE_OTHER);
    }
}
