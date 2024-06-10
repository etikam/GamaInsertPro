<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Etudiant;
use App\Entity\Offre;
use App\Entity\Postulation;
use App\Entity\TypeOffre;
use App\Repository\PostulationRepository;
use App\Service\EmailSender;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\PostDec;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class PostulationController extends AbstractController
{
    #[Route('/postulation', name: 'app_postulation')]
    public function index(Request $request, PostulationRepository $postulationRepository, EntityManagerInterface $em): Response
    {
        $entrepriseNom = $request->query->get('entreprise');
        $tpOffre = $request->query->get('offre');

        $postulants = $postulationRepository->searchPostulant($tpOffre, $entrepriseNom);

        $offre = $em->getRepository(TypeOffre::class)->findAll();
        $offreRepository = $em->getRepository(Offre::class);
        $entreprises = $offreRepository->findCompanyNames();

        return $this->render('postulation/index.html.twig', [
            'postulants' => $postulants,
            'offre' => $offre,
            'entreprises' => $entreprises,
            'selectedEntreprise' => $entrepriseNom,
            'selectedOffre' => $tpOffre
        ]);
    }
    #[Route('/postule/{id}', name: 'app_postule')]
    public function postule(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $etudiantConnect = $user->etudiant;
        if (!$etudiantConnect) {
            throw $this->createNotFoundException('No etudiant found for the current user.');
        }

        $idEtudiant = $etudiantConnect->getId();
        $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(['id' => $idEtudiant]);
        if (!$etudiant) {
            throw $this->createNotFoundException('No etudiant found for id ' . $idEtudiant);
        }
        // Trouver l'entité Offre
        $offre = $entityManager->getRepository(Offre::class)->find($id);
        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée.');
        }
        // Si une postulation existe déjà, afficher un message flash et rediriger
        if ($etudiant->aDejaPostulePourOffre($offre)) {
            $this->addFlash('warning', 'Vous avez déjà postulé pour cette offre.');
            return $this->redirectToRoute('app_notification');
        }


        // Créer une nouvelle postulation pour l'étudiant connecté
        $postulation = new Postulation();
        $postulation->setDatePostulation(new \DateTime('now'));
        $postulation->setOffre($offre);
        $postulation->setEtudiant($etudiant);

        $entityManager->persist($postulation);
        $entityManager->flush();

        // Rediriger vers une page de confirmation ou toute autre page
        $this->addFlash('success', 'Votre postulation a été envoyée avec succès.');

        return $this->redirectToRoute('app_notification');
        return $this->render('postulation/index.html.twig', [
            'controller_name' => 'PostulationController',
        ]);
    }

    #[Route('/postulation/retain/{id}', name: 'postulation_retain', methods: ['POST'])]
    public function retain(Postulation $postulation, EntityManagerInterface $em/*, EmailSender $emailSender, LoggerInterface $logger*/): JsonResponse
    {

        $postulation->setEtat(true);
        $em->persist($postulation);
        $em->flush();

        /*$studentEmail = $postulation->getEtudiant()->getUser()->getEmail();
        $emailSender->sendEmailToStudent($studentEmail);*/

        return new JsonResponse(['status' => 'success', 'message' => 'Postulant retenu avec succès.']);
    }

    #[Route('/retenu', name: 'postulant_retained')]
    public function etudiantRetenu(Request $request, PostulationRepository $postulationRepository, EntityManagerInterface $em): Response
    {
        $entrepriseNom = $request->query->get('entreprise');
        $tpOffre = $request->query->get('offre');
        $departement = $request->query->get('departement');
        $word = $request->query->getBoolean('word', false);

        // Passez les paramètres à la méthode retained
        $retenus = $postulationRepository->retained($entrepriseNom, $tpOffre, $departement);

        $offre = $em->getRepository(TypeOffre::class)->findAll();
        $offreRepository = $em->getRepository(Offre::class);
        $depart = $em->getRepository(Departement::class)->findAll();
        $entreprises = $offreRepository->findCompanyNames();

        if ($word) {
            // Génération du contenu HTML du document Word
            $html = $this->renderView('admin/tableau_retenu_pdf.html.twig', [
                'retenus' => $retenus,
                'offre' => $offre,
                'entreprises' => $entreprises,
                'depart' => $depart,
                'selectedEntreprise' => $entrepriseNom,
                'departement' => $departement,
                'selectedOffre' => $tpOffre,
                'offre_min' => strtolower($tpOffre),
            ]);
            return new Response($html, 200, [
                'Content-Type' => 'application/vnd.ms-word',
                'Content-Disposition' => 'attachment; filename="rapport.doc"'
            ]);
        }

        $context = [
            'retenus' => $retenus,
            'offre' => $offre,
            'entreprises' => $entreprises,
            'depart' => $depart,
            'selectedEntreprise' => $entrepriseNom,
            'departement' => $departement,
            'selectedOffre' => $tpOffre,
            'offre_min' => strtolower($tpOffre),
        ];

        return $this->render('postulation/retenus.html.twig', $context);
    }
    #[Route('/send-email', name: 'send_email', methods: ['POST'])]
    public function sendEmail(Request $request, MailerInterface $mailer, LoggerInterface $logger): Response
    {
        $studentEmail = $request->request->get('email');

        $logger->info('Received email:', ['email' => $studentEmail]); // Log pour vérifier l'email reçu

        if ($studentEmail) {
            // Envoi de l'email à l'étudiant
            $email = (new Email())
                ->from('medtoure79@gmail.com') // Remplacez par votre adresse email
                ->to($studentEmail)
                ->subject('Objet de l\'email')
                ->text('Contenu de l\'email.');

            $mailer->send($email);

            return new Response('Email envoyé avec succès', Response::HTTP_OK);
        }

        return new Response('Adresse email non fournie', Response::HTTP_BAD_REQUEST);
    }
}
