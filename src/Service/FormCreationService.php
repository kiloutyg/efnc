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
    public function createNCForm(
        EFNC $efnc,
        Request $request,
        FormInterface $form1
    ) {
        $this->logger->info('full request and form data passed in the request just to see: ' . json_encode($request->request->all()));


        $now = new \DateTime();
        $efnc->setCreatedAt($now);

        $efncFolderName = $form1->get('Project')->getData() . '.' . $now->format('Y-m-d') . '.' . $form1->get('Title')->getData();
        // $this->FolderCreationService->folderStructure($efncFolderName);

        if ((key_exists('Status', $request->request->all()) == true) && ($request->request->get('Status')) != null) {
            $efnc->setStatus(true);
        };

        // Check if 'picture' key exists and is not null
        if (key_exists('picture', $request->files->all()) && $request->files->get('picture') != null) {
            $pictures = $request->files->all()['picture'];

            // Process TraceabilityPictures
            if (key_exists('TraceabilityPicture', $pictures)) {
                foreach ($pictures['TraceabilityPicture'] as $traceabilityPicture) {
                    $traceabilityPictures[] = $traceabilityPicture;
                }
            }

            // Process NCpictures
            if (key_exists('NCpicture', $pictures)) {
                foreach ($pictures['NCpicture'] as $ncPicture) {
                    $ncPictures[] = $ncPicture;
                }
            }
        }


        // Process each file, e.g., save them to the server
        foreach ($traceabilityPictures as $picture) {
            // Save or process $pictures
            $this->pictureUpload($picture, $efnc, $efncFolderName, 'traceability');
        }

        foreach ($ncPictures as $picture) {
            // Save or process $picture
            $this->pictureUpload($picture, $efnc, $efncFolderName, 'NC');
        }
        $this->em->persist($efnc);
        $this->em->flush();

        return true;
    }





    public function pictureUpload(UploadedFile $file, EFNC $efnc, $efncFolderName, string $category, $newFileName = null)
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

        $file->move($folderPath . '/', $filename);

        $picture = new Picture();
        $picture->setFile(new File($path));
        $picture->setEFNC($efnc);
        $picture->setFilename($filename);
        $picture->setPath($path);
        $picture->setCategory($category);
        $efnc->addPicture($picture);

        $this->em->persist($picture);
        $this->em->persist($efnc);
        $this->em->flush();
        return true;
    }
}