<?php

namespace App\Controller;

use  \Psr\Log\LoggerInterface;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Repository\UserRepository;
use App\Repository\EFNCRepository;
use App\Repository\PictureRepository;

use App\Service\AccountService;
use App\Service\MailerService;
use App\Service\EntityDeletionService;
use App\Service\FolderCreationService;
use App\Service\FormCreationService;
use App\Service\FormModificationService;
use App\Service\PictureService;
use App\Service\TeamService;
use App\Service\ProjectService;
use App\Service\OriginService;
use App\Service\UAPService;
use App\Service\AnomalyTypeService;
use App\Service\PlaceService;

#[Route('/', name: 'app_')]

# This controller is extended to make it easier to access routes

class BaseController extends AbstractController
{
    protected $em;
    protected $request;
    protected $security;
    protected $passwordHasher;
    protected $requestStack;
    protected $session;
    protected $logger;
    protected $loggerInterface;
    protected $projectDir;
    protected $public_dir;
    protected $authChecker;

    // Repository methods

    protected $userRepository;
    protected $EFNCRepository;
    protected $pictureRepository;

    // Services methods

    protected $accountService;
    protected $mailerService;
    protected $entityDeletionService;
    protected $folderCreationService;
    protected $formCreationService;
    protected $formModificationService;
    protected $pictureService;
    protected $teamService;
    protected $projectService;
    protected $originService;
    protected $uapService;
    protected $anomalyTypeService;
    protected $placeService;

    // Variables used in the twig templates to display all the entities

    protected $users;



    public function __construct(

        EntityManagerInterface          $em,
        RequestStack                    $requestStack,
        Security                        $security,
        UserPasswordHasherInterface     $passwordHasher,
        LoggerInterface                 $loggerInterface,
        ParameterBagInterface           $params,
        AuthorizationCheckerInterface   $authChecker,

        // Repository methods

        UserRepository                  $userRepository,
        EFNCRepository                  $EFNCRepository,
        PictureRepository               $pictureRepository,

        // Services methods

        AccountService                  $accountService,
        MailerService                   $mailerService,
        EntityDeletionService           $entityDeletionService,
        FolderCreationService           $folderCreationService,
        FormCreationService             $formCreationService,
        FormModificationService         $formModificationService,
        PictureService                  $pictureService,
        TeamService                     $teamService,
        ProjectService                  $projectService,
        OriginService                   $originService,
        UAPService                      $uapService,
        AnomalyTypeService              $anomalyTypeService,
        PlaceService                    $placeService


    ) {

        $this->em                           = $em;
        $this->requestStack                 = $requestStack;
        $this->security                     = $security;
        $this->passwordHasher               = $passwordHasher;
        $this->logger                       = $loggerInterface;
        $this->request                      = $this->requestStack->getCurrentRequest();
        $this->session                      = $this->requestStack->getSession();
        $this->projectDir                   = $params->get('kernel.project_dir');
        $this->public_dir                   = $this->projectDir . '/public';
        $this->authChecker                  = $authChecker;

        // Variables related to the repositories

        $this->userRepository               = $userRepository;
        $this->EFNCRepository               = $EFNCRepository;
        $this->pictureRepository            = $pictureRepository;

        // Variables related to the services

        $this->accountService               = $accountService;
        $this->mailerService                = $mailerService;
        $this->entityDeletionService        = $entityDeletionService;
        $this->folderCreationService        = $folderCreationService;
        $this->formCreationService          = $formCreationService;
        $this->formModificationService      = $formModificationService;
        $this->pictureService               = $pictureService;
        $this->teamService                  = $teamService;
        $this->projectService               = $projectService;
        $this->originService                = $originService;
        $this->uapService                   = $uapService;
        $this->anomalyTypeService           = $anomalyTypeService;
        $this->placeService                 = $placeService;

        // Variables used in the twig templates to display all the entities

        $this->users                        = $this->userRepository->findAll();
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $commonParameters = [
            'users'                 => $this->users,
            'EFNCs'                 => $this->EFNCRepository->findAll(),
        ];

        $parameters = array_merge($commonParameters, $parameters);

        return parent::render($view, $parameters, $response);
    }
}