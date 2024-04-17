<?php

namespace App\Controller;

use App\Entity\EtudiantNotActivate;
use App\Form\EtudiantNotActivateType;
use App\Repository\EtudiantNotActivateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etudiant/activate')]
class EtudiantNotActivateController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_activate_index', methods: ['GET'])]
    public function index(EtudiantNotActivateRepository $etudiantRepository): Response
    {
        return $this->render('etudiant_activate/index.html.twig', [
            'etudiant_not_activates' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etudiant_activate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiantNotActivate = new EtudiantNotActivate();
        $form = $this->createForm(EtudiantNotActivateType::class, $etudiantNotActivate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etudiantNotActivate);
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_activate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant_activate/new.html.twig', [
            'etudiant_not_activate' => $etudiantNotActivate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_activate_show', methods: ['GET'])]
    public function show(EtudiantNotActivate $etudiantNotActivate): Response
    {
        return $this->render('etudiant_activate/show.html.twig', [
            'etudiant_not_activate' => $etudiantNotActivate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_activate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtudiantNotActivate $etudiantNotActivate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantNotActivateType::class, $etudiantNotActivate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_activate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant_activate/edit.html.twig', [
            'etudiant_not_activate' => $etudiantNotActivate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_activate_delete', methods: ['POST'])]
    public function delete(Request $request, EtudiantNotActivate $etudiantNotActivate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiantNotActivate->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($etudiantNotActivate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etudiant_ctivate_index', [], Response::HTTP_SEE_OTHER);
    }
}
