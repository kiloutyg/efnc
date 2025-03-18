<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\EFNC;
use App\Entity\Picture;

use App\Repository\PictureRepository;

class PictureService extends AbstractController
{
    private $logger;
    private $projectDir;
    private $em;

    private $pictureRepository;

    public function __construct(
        LoggerInterface                     $logger,
        ParameterBagInterface               $params,
        EntityManagerInterface              $em,

        PictureRepository                   $pictureRepository,

    ) {
        $this->logger                       = $logger;
        $this->projectDir                   = $params->get('kernel.project_dir');
        $this->em                           = $em;

        $this->pictureRepository            = $pictureRepository;
    }
    public function formPictureManager(Request $request, EFNC $efnc, string $efncFolderName): bool
    {
        $response = true;
        $result = [];

        // Check if 'picture' key exists and is not null
        if (key_exists('picture', $request->files->all()) && $request->files->get('picture') != null) {
            $pictures = $request->files->all()['picture'];
            // Process TraceabilityPictures
            if (key_exists('TraceabilityPicture', $pictures)) {
                foreach ($pictures['TraceabilityPicture'] as $traceabilityPicture) {
                    $result[] = $this->pictureUpload($traceabilityPicture, $efnc, $efncFolderName, 'traceability');
                }
            }
            // Process NCpictures
            if (key_exists('NCpicture', $pictures)) {
                foreach ($pictures['NCpicture'] as $ncPicture) {
                    $result[] = $this->pictureUpload($ncPicture, $efnc, $efncFolderName, 'NC');
                }
            }
        }
        if (in_array(false, $result)) {
            $response = false;
        }
        return $response;
    }


    public function pictureUpload(UploadedFile $file, EFNC $efnc, $efncFolderName, string $category)
    {
        $result = true;

        $allowedExtensions = ['jpg', 'png', 'jpeg', 'gif'];
        $extension = $file->guessExtension();
        // Get MIME type and define allowed MIME types
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $mimeType = $file->getMimeType();

        if (!in_array($extension, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
            return $this->addFlash('error', 'Le fichier doit être un jpg, png, jpeg ou gif');
        }


        $public_dir = $this->projectDir . '/public';
        $folderPath = $public_dir . '/doc';
        $parts = explode('.', $efncFolderName);
        foreach ($parts as $part) {
            $folderPath .= '/' . $part;
        }

        do {
            // Generate a more secure unique ID and preserve only the file extension
            $extension = $file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $filename = uniqid('', true) . '_' . (new \DateTime())->format('YmdHis') . '.' . $extension;
            $existingFile = $this->pictureRepository->findOneBy(["filename" => $filename]);
        } while ($existingFile != null);

        $path = $folderPath . '/' . $filename;

        $maxSize = 6291456; // bytes

        // Check file size
        if ($file->getSize() > $maxSize) {
            return $this->addFlash('error', 'Le fichier doit être inférieur à 6MB');
        } else {
            try {
                $file->move($folderPath . '/', $filename);
            } catch (\Exception $e) {
                $this->logger->error('error in pictureService pictureUpload: ', [$e->getMessage()]);
                $result = false;
            }
        }

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

        return $result;
    }
}
