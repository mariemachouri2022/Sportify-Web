<?php

namespace App\Mailer;
use Twilio\Rest\Client;


use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use App\Entity\Matc;
use Symfony\Component\Mime\Email;


class MatchMailer
{
    private $mailer;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMatchDetails(Matc $matc, string $recipientEmail1,string $recipientEmail2,string $selectedCity,array $weatherData)
    {
        $equipe1 = $matc->getEquipe1();
        $recipientEmail1 = $equipe1->getIdUser()->getEmail();
        $equipe2 = $matc->getEquipe2();
        $recipientEmail2 = $equipe2->getIdUser()->getEmail(); // Supposons que getIdUser() retourne l'entité User associée

        $email1 = (new Email())
            ->from('gimmework3@gmail.com')
            ->to($recipientEmail1)
            ->subject('Match Details')
            ->html(
                $this->renderTemplate('emails/match_details.html.twig', ['matc' => $matc,'selectedCity' => $selectedCity,'weatherData' => $weatherData])
            );
            $email2 = (new Email())
            ->from('gimmework3@gmail.com')
            ->to($recipientEmail2)
            ->subject('Match Details')
            ->html(
                $this->renderTemplate('emails/match_details.html.twig', ['matc' => $matc,'selectedCity' => $selectedCity,'weatherData' => $weatherData,])
            );

        $this->mailer->send($email1);
        $this->mailer->send($email2);

    }

    private function renderTemplate(string $template, array $data): string
    {
        return $this->twig->render($template, $data);
    }
    public function sendSMS(Matc $matc, string $recipientPhoneNumber,string $selectedCity,array $weatherData)
{
    // Configurez Twilio
    $twilioAccountSid = "AC0f69d70af9a9cef6b659154defc47bd8";
    $twilioAuthToken = "9ce845ef8445e92738a3861fe182effa";
    $twilioFromNumber = "+14027188561";
    if (!$twilioAccountSid || !$twilioAuthToken || !$twilioFromNumber) {
        throw new \Exception('Twilio credentials are missing or invalid.');
    }
    
    // Initialisez le client Twilio avec les identifiants récupérés
    $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

    $messageContent = $this->renderTemplate('emails/match_details.txt.twig', ['matc' => $matc,'selectedCity' => $selectedCity,'weatherData' => $weatherData,]);

    // Envoyez le SMS
    $message = $twilioClient->messages->create(
        '+216' . $recipientPhoneNumber,
        [
            'from' => $twilioFromNumber, // Numéro Twilio expéditeur
            'body' => $messageContent , // Contenu du message

        ]
    );

    // Traitement des résultats, journalisation, etc.
}
}
