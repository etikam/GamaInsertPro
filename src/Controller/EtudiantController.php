<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Postulation;
use App\Repository\EtudiantRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }
    #[Route('/notification', name: 'app_notification')]
    public function notif(OffreRepository $offreRepository): Response
    {
        $offre = $offreRepository->findAll();
        $context = [
            'offres' => $offre
        ];
        return $this->render('etudiant/index.html.twig', $context);
    }

    #[Route('/modifie/profil/{id}', name: 'app_modifyProfil')]
public function modify(int $id, Request $request, SluggerInterface $slugger, EtudiantRepository $etudiantRepository, EntityManagerInterface $entityManager): Response
{
    // Correcting the call to findOneBy to use an array
    $etudiant = $etudiantRepository->findOneBy(['id' => $id]);

    if (!$etudiant) {
        throw $this->createNotFoundException('Étudiant non trouvé.');
    }

    if ($request->isMethod('POST')) {
        /** @var UploadeFile|null $imageFile */
        $imageFile = $request->request->get('imageFile');

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_-] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Gérer l'exception si quelque chose se passe pendant l'upload du fichier
            }

            $etudiant->setImage($newFilename);
        }
        $adresse = $request->request->get('adresse');
        $paysResidence = $request->request->get('paysResidence');
        $status = $request->request->get('status');

        $etudiant->setAdresse($adresse);
        $etudiant->setPaysResidence($paysResidence);
        $etudiant->setStatus($status);

        $entityManager->persist($etudiant);
        $entityManager->flush();

        $this->addFlash('success', 'Profil mis à jour avec succès.');

        return $this->redirectToRoute('app_accueil');
    }

    // Render a form for editing the profile if the method is not POST
    return $this->redirectToRoute('app_accueil');
}


}
