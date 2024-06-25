<?php

namespace App\Service;

use App\Entity\EFNC;
use App\Entity\User;

use App\Repository\UserRepository;
use App\Repository\EFNCRepository;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Bundle\SecurityBundle\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Psr\Log\LoggerInterface;

class MailerService extends AbstractController
{
    private $mailer;

    private $userRepository;
    private $EFNCRepository;

    private $senderEmail;

    private $logger;

    protected $projectDir;

    public function __construct(
        MailerInterface $mailer,

        UserRepository $userRepository,
        EFNCRepository $EFNCRepository,

        LoggerInterface $logger,

        ParameterBagInterface           $params,

        string $senderEmail
    ) {
        $this->mailer               = $mailer;

        $this->userRepository       = $userRepository;
        $this->EFNCRepository       = $EFNCRepository;

        $this->senderEmail              = $senderEmail;

        $this->logger               = $logger;
        $this->projectDir            = $params->get('kernel.project_dir');
    }

    public function notificationEmail(EFNC $EFNC)
    {


        $users = $this->userRepository->findAll();
        $recipientsEmail = [];
        foreach ($users as $user) {
            if ($user !== $this->getUser() && filter_var($user->getEmailAddress(), FILTER_VALIDATE_EMAIL) && in_array('ROLE_SUPER_ADMIN', $user->getRoles()) === false) {
                $recipientsEmail[] = $user->getEmailAddress();
            }
        }

        $pictures = $EFNC->getPictures();
        // Let's assume $NcPictures is an array of file paths for your NcPictures

        $NcPictureCids = [];
        $traceabilityPictureCids = [];

        $email = (new TemplatedEmail())
            ->from('lan.efnc@plasticomnium.com')
            ->to(...$recipientsEmail)
            ->subject('Nouvelle Fiche de Non-Conformité');


        foreach ($pictures as $picture) {
            // Generate a CID string for the embedded image
            $cid = 'cid_' . bin2hex(random_bytes(16)); // This creates a unique CID for each picture.

            // Attach the picture to the email
            $email
                // ->attachFromPath(
                //     $picture->getPath(),
                //     $picture->getFilename()
                // )
                ->embed(
                    fopen($picture->getPath(), 'r'),
                    $cid
                );

            // Depending on the category, add the CID to the appropriate array.
            if ($picture->getCategory() === 'NC') {
                $NcPictureCids[] = $cid;
            } else {
                $traceabilityPictureCids[] = $cid;
            }
        }

        // ... Render the email with the template and CIDs ...
        $email->htmlTemplate('services/email_templates/notificationEmail.html.twig')
            ->context([
                'EFNC' => $EFNC,
                'traceabilityPictureCids' => $traceabilityPictureCids,
                'NcPictureCids' => $NcPictureCids,
            ]);

        // Send the email as usual
        $this->mailer->send($email);
        return true;
    }



    public function sendEmail(User $recipient, string $subject, string $html)
    {

        $emailRecipientsAddress = $recipient->getEmailAddress();
        $email = (new Email())
            ->from($this->senderEmail)
            ->to($emailRecipientsAddress)
            ->subject($subject)
            ->html($html);
        try {
            $this->mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $e) {
            return $e->getMessage();
        }
    }

    public function sendReminderEmailToAdmin()
    {
        $today = new \DateTime();
        $fileName = 'email_sent.txt';
        $filePath = $this->projectDir . '/public/doc/' . $fileName;

        if ($today->format('d') % 1 == 0 && (!file_exists($filePath) || strpos(file_get_contents($filePath), $today->format('Y-m-d')) === false)) {

            $senderEmail = $this->senderEmail;

            $recipientsEmail = [];
            $users = $this->userRepository->findAll();
            foreach ($users as $user) {
                if ($user !== $this->getUser() && filter_var($user->getEmailAddress(), FILTER_VALIDATE_EMAIL) && in_array('ROLE_ADMIN', $user->getRoles()) === true) {
                    $recipientsEmail[] = $user->getEmailAddress();
                }
            }
            $monthOldEfnc = $this->EFNCRepository->getMonthOldLowLevelRiskEfnc();
            $this->logger->info('Month old efncs: ' . count($monthOldEfnc));
            $this->logger->info('month old efncs: ', [$monthOldEfnc]);

            $email = (new TemplatedEmail())
                ->from($senderEmail)
                ->to(...$recipientsEmail)
                // ->to('florian.dkhissi@opmobility.com')

                ->subject('EFNC - Rappel des fiches à cloturer.')
                ->htmlTemplate('/services/email_templates/reminderEmailToAdmin.html.twig')
                ->context([
                    'oldEfncs'                    => $monthOldEfnc,
                ]);

            try {
                $this->mailer->send($email);
                return true;
            } catch (TransportExceptionInterface $e) {
                return false;
            }
        }
    }
}
