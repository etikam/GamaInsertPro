<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EmailSender
{
    private $mailer;
    private $params;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $params)
    {
        $this->mailer = $mailer;
        $this->params = $params;
    }

    public function sendEmailToStudent(string $studentEmail)
    {
        $fromEmail = $this->params->get('MAILER_FROM_EMAIL');

        $email = (new Email())
            ->from($fromEmail)
            ->to($studentEmail)
            ->subject('Félicitations !')
            ->text('Vous avez été retenu pour la prochaine étape du processus de sélection.');

        $this->mailer->send($email);
    }
}