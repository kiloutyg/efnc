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

class PictureService extends AbstractController
{
    // private $logger;

    private $projectDir;

    private $em;

    // private $imagine;


    public function __construct(
        // LoggerInterface                     $logger,

        ParameterBagInterface               $params,

        EntityManagerInterface              $em,


    ) {
        // $this->logger                       = $logger;

        $this->projectDir                   = $params->get('kernel.project_dir');

        $this->em                           = $em;

        // $this->imagine = new Imagine();
    }

    public function pictureUpload(UploadedFile $file, EFNC $efnc, $efncFolderName, string $category, $newFileName = null)
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

        // Initialize the filename using the provided new filename or original name.
        $filename = $newFileName ? $newFileName : $file->getClientOriginalName();

        $path = $folderPath . '/' . $filename;

        $maxSize = 6291456; // bytes

        // Check file size
        if ($file->getSize() > $maxSize) {
            // Always move the file first, then work off the moved file.
            // $movedFile = $file->move($folderPath, $filename);
            // $stablePath = $movedFile->getPathname(); // Get the new, stable file path
            // $image = $this->imagine->open($stablePath);
            // $image
            //     ->save($path, [
            //         'jpeg_quality' => 80,
            //         'format'       => 'jpeg'
            //     ]);
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
