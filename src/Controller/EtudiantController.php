<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Experience;
use App\Entity\Offre;
use App\Entity\Postulation;
use App\Entity\Realisation;
use App\Repository\EtudiantRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    #[Route('/experience', name: 'app_add_experience')]
    public function addExperience(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('You must be logged in to access this section.');
        }

        $etudiantConnecte = $user->getEtudiant();

        if (!$etudiantConnecte) {
            throw $this->createNotFoundException('No student associated with this user.');
        }

        if ($request->isMethod('POST')) {
            $nomExperience = $request->request->get('nom_experience');
            $detailsExperience = $request->request->get('description');

            // Validation des données, création d'une nouvelle entité Experience, etc.
            $experience = new Experience();
            $experience->setNom($nomExperience);
            $experience->setDescription($detailsExperience);
            $experience->setEtudiant($etudiantConnecte);
            // Suppose que vous avez une relation entre Experience et User
            

            $entityManager->persist($experience);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->redirectToRoute('app_accueil');
    }
    #[Route('/competence', name: 'app_add_competence')]
    public function addCompetence(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('You must be logged in to access this section.');
        }

        $etudiantConnecte = $user->getEtudiant();

        if (!$etudiantConnecte) {
            throw $this->createNotFoundException('No student associated with this user.');
        }

        if ($request->isMethod('POST')) {
            $nomCompetence = $request->request->get('nom_competence');

            // Validation des données, création d'une nouvelle entité Experience, etc.
            $competence = new Competence();
            $competence->setNom($nomCompetence);
            $competence->setEtudiant($etudiantConnecte);
            // Suppose que vous avez une relation entre Experience et User
            

            $entityManager->persist($competence);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->redirectToRoute('app_accueil');
    }
    #[Route('/experience', name: 'app_add_realisation')]
    public function addRealisation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('You must be logged in to access this section.');
        }

        $etudiantConnecte = $user->getEtudiant();

        if (!$etudiantConnecte) {
            throw $this->createNotFoundException('No student associated with this user.');
        }

        if ($request->isMethod('POST')) {
            $nomRealisation = $request->request->get('nom_realisation');
            $description = $request->request->get('description');
            $dateRealisation = $request->request->get('date_realisation');

            // Validation des données, création d'une nouvelle entité Experience, etc.
            $realisation = new Realisation();
            $realisation->setNom($nomRealisation);
            $realisation->setDescription($description);
            $realisation->setAnnee(new \DateTime($dateRealisation));
            $realisation->setEtudiant($etudiantConnecte);
            // Suppose que vous avez une relation entre Experience et User
            

            $entityManager->persist($realisation);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/modifie/profil/{id}', name: 'app_modifyProfil')]
public function modify(int $id, Request $request, EtudiantRepository $etudiantRepository, EntityManagerInterface $entityManager): Response
{
    // Correcting the call to findOneBy to use an array
    $etudiant = $etudiantRepository->findOneBy(['id' => $id]);

    if (!$etudiant) {
        throw $this->createNotFoundException('Étudiant non trouvé.');
    }

    if ($request->isMethod('POST')) {

        /** @var UploadedFile $imageFile */
        $imageFile = $request->files->get('imageFile');
        dd($imageFile);

        if ($imageFile) {
            $etudiant->setImageFile($imageFile);
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
