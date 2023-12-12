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

        $EFNCTitle = $EFNC->getTitle();

        $users = $this->userRepository->findAll();
        $recipientsEmail = [];
        foreach ($users as $user) {
            if ($user !== $this->getUser() && filter_var($user->getEmailAddress(), FILTER_VALIDATE_EMAIL)) {
                $recipientsEmail[] = $user->getEmailAddress();
            }
        }




        $pictures = $EFNC->getPictures();
        // Let's assume $NcPictures is an array of file paths for your NcPictures
        $NcPicturePaths = [];
        $traceabilityPicturePaths = [];

        // foreach ($pictures as $picture) {
        //     if ($picture->getCategory() == 'NC') {
        //         $NcPicturePaths[] = $picture->getPath();
        //     } else {
        //         $traceabilityPicturePaths = $picture->getPath();
        //     }
        // }

        $NcPictureCids = [];
        $traceabilityPictureCids = [];

        $email = (new TemplatedEmail())
            ->from('lan.efnc@plasticomnium.com')
            ->to(...$recipientsEmail)
            ->subject('Nouvelle Fiche de Non-Conformité');

        // foreach ($NcPicturePaths as $NcPicturePath) {
        //     // Create a unique content ID for each NcPicture
        //     $cid = bin2hex(random_bytes(16)) . $EFNCTitle;
        //     $NcPicture = DataPart::fromPath($NcPicturePath);
        //     // Attach the NcPicture to the email and store the CID in an array
        //     $NcPictureCids[$NcPicturePath] = $email->embed($NcPicture, $cid);
        // }
        // foreach ($traceabilityPicturePaths as $traceabilityPicturePath) {
        //     // Create a unique content ID for each NcPicture
        //     $cid = bin2hex(random_bytes(16)) . $EFNCTitle;
        //     $traceabilityPicture = DataPart::fromPath($traceabilityPicturePath);
        //     // Attach the NcPicture to the email and store the CID in an array
        //     $traceabilityPictureCids[$traceabilityPicturePath] = $email->embed($traceabilityPicture, $cid);
        // }

        // foreach ($EFNC->getPictures() as $picture) {
        //     $cid = $email->embedFromPath($picture->getPath(), $picture->getFilename());
        //     if ($picture->getCategory() === 'NC') {
        //         $NcPictureCids[] = $cid;
        //     } else {
        //         $traceabilityPictureCids[] = $cid;
        //     }
        // }

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