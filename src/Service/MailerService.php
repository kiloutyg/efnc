<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Doctrine\Common\Collections\Collection;



use App\Entity\User;


class MailerService extends AbstractController
{
    private $security;
    private $mailer;
    private $approbationRepository;

    public function __construct(
        Security $security,

    ) {
        $this->security             = $security;

    }

    
}