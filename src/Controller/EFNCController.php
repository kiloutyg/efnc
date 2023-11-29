<?php

namespace App\Controller;

use App\Entity\EFNC;
use App\Entity\ImmediateConservatoryMeasures;

use App\Form\FormCreationType;
use App\Form\ImCoMeType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Common\Collections\ArrayCollection;


#[Route('/', name: 'app_')]
class EFNCController extends BaseController
{


    #[Route('/form_creation', name: 'form_creation')]
    public function formCreation(Request $request): Response
    {
        $efnc = new EFNC();
        $form1 = $this->createForm(FormCreationType::class, $efnc);

        $imcome = new ImmediateConservatoryMeasures();
        $imcomeForm = $this->createForm(ImCoMeType::class, $imcome);

        if ($request->getMethod() == 'POST') {

            $form1->handleRequest($request);
            $this->logger->info('full request from the form1: ' . json_encode($request->request->all()));
            $imcomeForm->handleRequest($request);
            $this->logger->info('full request from the imcomeform: ' . json_encode($request->request->all()));

            if (
                $form1->isSubmitted() && $form1->isValid()
                && $imcomeForm->isSubmitted() && $imcomeForm->isValid()
            ) {
                $result = $this->formCreationService->createNCForm(
                    $efnc,
                    $request,
                    $form1
                );
                $this->imcomeService->imcomeCreation($efnc, $imcome, $imcomeForm, $request);
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
                'imcomeForm' => $imcomeForm->createView(),
            ]);
        }
    }




    #[Route('/form{efncID}_modification_display', name: 'form_modification_display')]
    public function formModificationDisplay(int $efncID, Request $request): Response
    {
        $efnc = $this->EFNCRepository->find($efncID);
        if (!$efnc) {
            throw $this->createNotFoundException('No EFNC found for id ' . $efncID);
        }

        $originalImcomes = new ArrayCollection();
        // Create an ArrayCollection of the current ImmediateConservatoryMeasures objects in the database
        foreach ($efnc->getImmediateConservatoryMeasures() as $imcome) {
            $originalImcomes->add($imcome);
        }

        $form1 = $this->createForm(FormCreationType::class, $efnc);

        // Create a form for each ImmediateConservatoryMeasures entity
        $imcomeForms = [];
        foreach ($efnc->getImmediateConservatoryMeasures() as $key => $imcome) {
            $imcomeForms[$key] = $this->createForm(ImCoMeType::class, $imcome)->createView();
        }

        if ($request->getMethod() == 'GET') {
            return $this->render('/services/efnc/modification/form_modification.html.twig', [
                'form1' => $form1->createView(),
                'imcomeForms' => $imcomeForms,
                'EFNC' => $efnc,
            ]);
        } else {
            $form1->handleRequest($request);

            // Handle request for each imcomeForm
            foreach ($efnc->getImmediateConservatoryMeasures() as $key => $imcome) {
                $imcomeForm = $this->createForm(ImCoMeType::class, $imcome);
                $imcomeForm->handleRequest($request);
                if ($imcomeForm->isSubmitted() && $imcomeForm->isValid()) {
                    $this->imcomeService->imcomeCreation($efnc, $imcome, $imcomeForm, $request);
                }
            }


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