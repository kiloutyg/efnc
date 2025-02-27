<?php

namespace App\Service;

// use Imagine\Gd\Imagine;
// Add liip_imagine if needed


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// use Psr\Log\LoggerInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\EFNC;
use App\Entity\Picture;

use App\Repository\PictureRepository;

class PictureService extends AbstractController
{
    // private $logger;

    private $projectDir;

    private $em;

    private $pictureRepository;

    // private $imagine;


    public function __construct(
        // LoggerInterface                     $logger,

        ParameterBagInterface               $params,

        EntityManagerInterface              $em,

        PictureRepository                   $pictureRepository,


    ) {
        // $this->logger                       = $logger;

        $this->projectDir                   = $params->get('kernel.project_dir');

        $this->em                           = $em;

        $this->pictureRepository            = $pictureRepository;

        // $this->imagine = new Imagine();
    }

    public function pictureUpload(UploadedFile $file, EFNC $efnc, $efncFolderName, string $category)
    {

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
            return $this->addFlash('error', 'Le fichier doit être inférieur à 4MB');
        } else {
            $file->move($folderPath . '/', $filename);
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
        return true;
    }
}
