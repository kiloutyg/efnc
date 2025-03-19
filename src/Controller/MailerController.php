<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\UserRepository;
use App\Repository\EFNCRepository;

use App\Service\MailerService;


class MailerController extends FrontController
{
    private $logger;
    private $em;

    private $eFNCRepository;
    private $userRepository;

    private $mailerService;

    public function __construct(
        LoggerInterface             $logger,
        EntityManagerInterface      $em,

        UserRepository              $userRepository,
        EFNCRepository              $eFNCRepository,

        MailerService               $mailerService
    ) {
        $this->logger = $logger;
        $this->em = $em;

        $this->userRepository = $userRepository;
        $this->eFNCRepository = $eFNCRepository;

        $this->mailerService = $mailerService;
    }



    #[Route('/mailer/{id}', name: 'app_mailer')]
    public function mailTemplateTester(int $id)
    {
        $efnc = $this->eFNCRepository->findOneBy(['id' => $id]);
        $this->mailerService->notificationEmail($efnc);
        return $this->redirectToRoute('app_base');
    }



    #[Route('/mail/mailadupdate', name: 'mailadupdate')]
    public function updateEmailAddress(): Response
    {
        $usersUpdated = [];
        $htmlContent = "<h1>Email Address Updates</h1>"; // Start your HTML content

        foreach ($this->userRepository->findAll() as $user) {
            $username = $user->getUsername();
            $this->logger->info('username: ' . $username);
            $newEmail = "{$username}@opmobility.com";
            $oldEmail = $user->getEmailAddress();
            $this->logger->info('oldEmail: ' . $oldEmail);
            $this->logger->info('newEmail: ' . $newEmail);

            // Check if the new email already exists in the database
            $existingUser = $this->userRepository->findOneBy(['emailAddress' => $newEmail]);
            if ($existingUser && $existingUser->getId() !== $user->getId()) {
                $this->logger->warning("Email $newEmail already exists for another user.");
                continue; // Skip this user to avoid duplication
            }

            if ($oldEmail !== $newEmail) {
                $user->setEmailAddress($newEmail);
                $this->logger->info('user email now: ' . $user->getEmailAddress());
                $usersUpdated[] = $user;
                $emailAfterUpdate = $user->getEmailAddress();

                $htmlContent .= "<p>{$username}'s email address updated to {$emailAfterUpdate}</p>"; // Append to the HTML content
            }
        }
        if (!empty($usersUpdated)) {
            foreach ($usersUpdated as $updatedUser) {
                $this->em->persist($updatedUser);
            }
            $this->em->flush();
            // Send email or handle the response with the HTML content
            $subject = "Update Email Address";
            $recipient = $this->userRepository->findOneBy(['username' => 'florian.dkhissi']);
            if ($recipient) {
                $message = $this->mailerService->sendEmail($recipient, $subject, $htmlContent);
            }
            $this->addFlash('alert', 'Email addresses updated successfully' . $message);
            return $this->redirectToRoute('app_base'); // Optionally return the HTML content as a response
        }
        $this->addFlash('alert', 'No email addresses were updated');
        return $this->redirectToRoute('app_base');
    }


    #[Route('/mail/maildev', name: 'mailaddev')]
    public function devEmailAddress(): Response
    {
        $usersUpdated = [];
        $htmlContent = "<h1>Email Address Updates</h1>"; // Start your HTML content

        foreach ($this->userRepository->findAll() as $user) {
            $username = $user->getUsername();
            $this->logger->info('username: ' . $username);
            $newEmail = "florian.dkhissi+{$username}@opmobility.com";
            $oldEmail = $user->getEmailAddress();
            $this->logger->info('oldEmail: ' . $oldEmail);
            $this->logger->info('newEmail: ' . $newEmail);

            // Check if the new email already exists in the database
            $existingUser = $this->userRepository->findOneBy(['emailAddress' => $newEmail]);
            if ($existingUser && $existingUser->getId() !== $user->getId()) {
                $this->logger->warning("Email $newEmail already exists for another user. Skipping update for user $username.");
                continue; // Skip this user to avoid duplication
            }

            if ($oldEmail !== $newEmail) {
                $user->setEmailAddress($newEmail);
                $this->logger->info('user email now: ' . $user->getEmailAddress());

                $usersUpdated[] = $user;
                $emailAfterUpdate = $user->getEmailAddress();

                $htmlContent .= "<p>{$username}'s email address updated to {$emailAfterUpdate}</p>"; // Append to the HTML content
            }
        }

        // Persist and flush after all updates
        if (!empty($usersUpdated)) {
            foreach ($usersUpdated as $updatedUser) {
                $this->logger->info('updatedUser: ', [$updatedUser]);
                $this->em->persist($updatedUser);
            }
            $this->em->flush();

            // Send email or handle the response with the HTML content
            $subject = "Update Email Address";
            $recipient = $this->userRepository->findOneBy(['username' => 'florian.dkhissi']);
            if ($recipient) {
                $message = $this->mailerService->sendEmail($recipient, $subject, $htmlContent);
            }
            $this->addFlash('alert', 'Email addresses updated successfully. ' . $message);
            return $this->redirectToRoute('app_base'); // Optionally return the HTML content as a response
        }

        $this->addFlash('alert', 'No email addresses were updated');
        return $this->redirectToRoute('app_base');
    }
}
