<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\ImmediatePreventiveActionPlan;
use App\Entity\Picture;


use App\Repository\EFNCRepository;
use App\Repository\CorrectivePreventiveActionPlanRepository;
use App\Repository\PictureRepository;
use App\Repository\ImmediateConservatoryMeasuresRepository;
use App\Repository\AnomalyTypeRepository;

use App\Service\FolderCreationService;


class FormCreationService extends AbstractController
{
    private $efncRepository;
    private $correctivePreventiveActionPlanRepository;
    private $pictureRepository;
    private $immediateConservatoryMeasuresRepository;
    private $anomalyTypeRepository;

    private $logger;

    private $params;
    protected $projectDir;

    private $FolderCreationService;

    // private $file;

    private $em;

    public function __construct(
        EFNCRepository                              $efncRepository,
        CorrectivePreventiveActionPlanRepository    $correctivePreventiveActionPlanRepository,
        PictureRepository                           $pictureRepository,
        ImmediateConservatoryMeasuresRepository     $immediateConservatoryMeasuresRepository,
        AnomalyTypeRepository                       $anomalyTypeRepository,

        LoggerInterface                             $logger,

        ParameterBagInterface                       $params,

        FolderCreationService                       $FolderCreationService,

        // File                                        $file,

        EntityManagerInterface                      $em
    ) {
        $this->efncRepository                               = $efncRepository;
        $this->correctivePreventiveActionPlanRepository     = $correctivePreventiveActionPlanRepository;
        $this->pictureRepository                            = $pictureRepository;
        $this->immediateConservatoryMeasuresRepository      = $immediateConservatoryMeasuresRepository;
        $this->anomalyTypeRepository                        = $anomalyTypeRepository;

        $this->logger                                       = $logger;

        $this->params                                       = $params;

        $this->FolderCreationService                        = $FolderCreationService;

        // $this->file                                         = $file;
        $this->projectDir                                   = $params->get('kernel.project_dir');

        $this->em                                           = $em;
    }
    public function createNCForm(EFNC $efnc, Request $request, FormInterface $form)
    {
        $this->logger->info('full request and form data passed in the request just to see: ' . json_encode($request->request->all()));


        $now = new \DateTime();
        $this->logger->info('Current DateTime: ' . $now->format('Y-m-d H:i:s'));
        $efnc->setCreatedAt($now);


        $efncFolderName = $form->get('Project') . '.' . $now->format('Y-m-d H:i:s') . '.' . $form->get('Title');
        $this->logger->info('EFNC Folder Name: ' . $efncFolderName);
        $this->FolderCreationService->folderStructure($efncFolderName);

        // if ((key_exists('status', $request->request->all()) != true) && ($request->request->get('status') != true)) {
        //     $efnc->setStatus(false);
        // };
        if ($form->get('status')->getData() != true) {
            $efnc->setStatus(false);
        };

        // if ((key_exists('TraceabilityPicture', $request->request->all()) == true) && ($request->request->get('TraceabilityPicture')) != null) {
        //     $traceabilityPictures = $request->request->all('TraceabilityPicture');
        // };

        $traceabilityPictures = $form->get('TraceabilityPicture')->getData();
        $ncPictures = $form->get('NCpicture')->getData();

        // Process each file, e.g., save them to the server
        foreach ($traceabilityPictures as $picture) {
            // Save or process $pictures
            $result = $this->pictureUpload($picture, $efnc, $efncFolderName);
            if ($result === true) {
                $efnc->addPicture($picture);
            }
        }

        foreach ($ncPictures as $picture) {
            // Save or process $picture
            $result = $this->pictureUpload($picture, $efnc, $efncFolderName);

            if ($result === true) {
                $efnc->addPicture($picture);
            }
        }
        $this->em->persist($efnc);
        $this->em->flush();

        return true;
    }





    public function pictureUpload(UploadedFile $file, EFNC $efnc, $efncFolderName, $newFileName = null)
    {

        $public_dir = $this->projectDir . '/public';
        $folderPath = $public_dir . '/doc';
        $parts = explode('.', $efncFolderName);
        foreach ($parts as $part) {
            $folderPath .= '/' . $part;
        }

        $allowedExtensions = ['jpg', 'png', 'jpeg', 'gif'];
        $extension = $file->guessExtension();
        if (!in_array($extension, $allowedExtensions)) {
            return $this->addFlash('error', 'Le fichier doit être un jpg, png, jpeg ou gif');
        }

        // Get MIME type and define allowed MIME types
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $mimeType = $file->getMimeType();

        // Check if the MIME type is allowed
        if (!in_array($mimeType, $allowedMimeTypes)) {
            return $this->addFlash('error', 'Le fichier doit être un jpg, png, jpeg ou gif');
        }
        // Initialize the filename variable
        $filename = '';
        // Check if a new filename is provided
        if ($newFileName) {
            $filename = $newFileName;
        } else {
            // Use the original filename of the file
            $filename = $file->getClientOriginalName();
        }
        $path = $folderPath . '/' . $filename;

        $picture = new Picture();
        $picture->setFile(new File($path));
        $picture->setEFNC($efnc);
        $picture->setFilename($filename);
        $picture->setPath($path);
        $this->em->persist($picture);
        return true;
    }
}