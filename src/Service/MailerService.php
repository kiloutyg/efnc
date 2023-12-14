<?php

namespace App\Service;

use App\Entity\EFNC;

use App\Repository\UserRepository;
use App\Repository\EFNCRepository;

use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Bundle\SecurityBundle\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MailerService extends AbstractController
{
    private $mailer;

    private $userRepository;
    private $EFNCRepository;

    public function __construct(
        MailerInterface $mailer,

        UserRepository $userRepository,
        EFNCRepository $EFNCRepository
    ) {
        $this->mailer               = $mailer;

        $this->userRepository       = $userRepository;
        $this->EFNCRepository       = $EFNCRepository;
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
            $email->attachFromPath($picture->getPath(), $picture->getFilename())->embed(fopen($picture->getPath(), 'r'), $cid);

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
    }
}