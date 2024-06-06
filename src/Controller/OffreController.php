<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Postulation;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use App\Repository\TypeOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
    public function index(OffreRepository $offreRepository): Response
    {

        return $this->render('offre/index.html.twig', [
            'offres' => $offreRepository->findMostRecent(),
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
public function new(Request $request, TypeOffreRepository $typeOffreRepository, EntityManagerInterface $entityManager): Response
{
    if ($request->isMethod('POST')) {
        $nomEntreprise = $request->request->get('nomEntreprise');
        $nomOffre = $request->request->get('nomOffre');
        $description = $request->request->get('description');
        $typeOffre = $request->request->get('typeOffre');
        $email = $request->request->get('email');
        $telephone = $request->request->get('telephone');
        $dateDebut = new \DateTime($request->request->get('dateDebut'));
        $dateLimite = new \DateTime($request->request->get('dateLimite'));
        $image = $request->request->get('image');

        $condition = [
            'nomEntreprise' => $nomEntreprise,
            'dateDebut' => $dateDebut,
            'dateLimite' => $dateLimite
        ];

        $offreExiste = $entityManager->getRepository(Offre::class)->findBy($condition);

        if ($offreExiste) {
            $this->addFlash(
               'danger',
               'Vous avez déjà partagé cette Offre !'
            );
            return $this->redirectToRoute('app_offreEntreprise');
        } elseif ($dateDebut > $dateLimite) {
            $this->addFlash(
               'danger',
               'La DATE DEBUT doit être inférieure à la DATE LIMITE !'
            );
            return $this->redirectToRoute('app_offreEntreprise');
        }

        $offre = new Offre();
        $toffre = $typeOffreRepository->findOneBy(['id' => $typeOffre]); // Assuming $typeOffre is the ID

        if (!$toffre) {
            $this->addFlash(
               'danger',
               'Le type d\'offre spécifié n\'existe pas !'
            );
            return $this->redirectToRoute('app_offreEntreprise');
        }

        $offre->setNomEntreprise($nomEntreprise);
        $offre->setNomOffre($nomOffre);
        $offre->setDescription($description);
        $offre->setFkTypeOffre($toffre);
        $offre->setEmail($email);
        $offre->setTelephone($telephone);
        $offre->setDateDebut($dateDebut);
        $offre->setDateLimite($dateLimite);
        $offre->setImage($image);
        $offre->setDateCreate(new \DateTime('now'));

        $entityManager->persist($offre);
        $entityManager->flush();
        
        $this->addFlash(
           'success',
           'L\'offre partagée avec succès !'
        );

        return $this->redirectToRoute('app_offreEntreprise');
    } else {
        $this->addFlash(
           'warning',
           'L\'offre n\'est pas partagée !'
        );
        return $this->redirectToRoute('app_offreEntreprise');
    }
}


    #[Route('/{id}', name: 'app_offre_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }
    

    #[Route('/delete/{id}', name: 'app_offre_delete')]
public function delete(Offre $offre, EntityManagerInterface $entityManager): Response
{
    try {
        // Récupérer toutes les postulations associées à l'offre
        $postulations = $entityManager->getRepository(Postulation::class)->findBy(['offre' => $offre]);

        // Supprimer toutes les postulations
        foreach ($postulations as $postulation) {
            $entityManager->remove($postulation);
        }

        // Supprimer l'offre
        $entityManager->remove($offre);
        $entityManager->flush();

        // Ajouter un message flash pour indiquer que l'opération s'est bien déroulée
        $this->addFlash('success', 'Offre supprimée avec succès !');
    } catch (\Exception $e) {
        // En cas d'erreur, ajouter un message flash d'erreur
        $this->addFlash('error', 'Une erreur est survenue lors de la suppression de l\'offre : ' . $e->getMessage());
    }

    // Rediriger vers une page appropriée
    return $this->redirectToRoute('app_offreEntreprise');
}


}
