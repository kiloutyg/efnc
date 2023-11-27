<?php

namespace App\Controller;

use App\Entity\EFNC;

use App\Form\FormCreationType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_')]
class FrontController extends BaseController
{
    #[Route('/', name: 'base')]
    public function base(): Response
    {
        return $this->render('base.html.twig', []);
    }


    #[Route('/form_creation', name: 'form_creation')]
    public function formCreation(Request $request): Response
    {
        $efnc = new EFNC();
        $form1 = $this->createForm(FormCreationType::class, $efnc);
        $form1->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if (
                $form1->isSubmitted() && $form1->isValid()
            ) {
                $result = $this->formCreationService->createNCForm(
                    $efnc,
                    $request,
                    $form1
                );
                if ($result === true) {
                    $this->addFlash('success', 'C\'est bon khey!');
                    return $this->redirectToRoute('app_base', []);
                }
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirectToRoute('app_base', []);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/efnc/creation/form_creation.html.twig', [
                'form1' => $form1->createView(),
            ]);
        }
    }



    #[Route('/form_list', name: 'form_list')]
    public function formList(): Response
    {
        return $this->render('/services/efnc/display/efnc_list.html.twig', []);
    }


    #[Route('/form{efncID}_display_modification', name: 'form_display_modification')]
    public function formModificationDisplay(int $efncID, Request $request): Response
    {
        $efnc = $this->EFNCRepository->find(['id' => $efncID]);
        $form1 = $this->createForm(FormCreationType::class, $efnc);
        if ($request->getMethod() == 'GET') {
            return $this->render('/services/efnc/modification/form_modification.html.twig', [
                'form1' => $form1->createView(),
                'EFNC' => $efnc,
            ]);
        } else {
            $form1->handleRequest($request);
            if ($form1->isSubmitted() && $form1->isValid()) {
                $result = $this->formModificationService->modifyNCForm(
                    $efnc,
                    $request,
                    $form1
                );
                if ($result === true) {
                    $this->addFlash('success', 'C\'est bon khey!');
                    return $this->redirectToRoute('app_base', []);
                } else {
                    $this->addFlash('error', 'C\'est pas bon khey!');
                    return $this->redirectToRoute('app_base', []);
                }
            }
        }
    }


    #[Route('/picture_view/{pictureID}', name: 'picture_view')]
    public function pictureView(int $pictureID): Response
    {
        // $picture = $this->pictureRepository->findOneBy(['id' => $pictureID]);
        $picture = $this->pictureRepository->find($pictureID);
        if (!$picture) {
            throw $this->createNotFoundException('No picture found for id ' . $pictureID);
        }
        $filePath = $picture->getPath();
        if (
            !file_exists($filePath) || !is_readable($filePath)
        ) {
            throw $this->createNotFoundException('File not found or not readable');
        }
        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE, // Use DISPOSITION_ATTACHMENT for download
            $picture->getFilename()
        );
        return $response;
    }
}