<?php

namespace App\Controller;

use App\Entity\EFNC;
use App\Entity\ImmediateConservatoryMeasures;
use App\Entity\RiskWeighting;
use App\Entity\Product;

use App\Form\FormCreationType;
use App\Form\ImCoMeType;
use App\Form\RiskWeightingType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_')]
class EFNCController extends BaseController
{
    #[Route('/form_creation', name: 'form_creation')]
    public function formCreation(Request $request): Response
    {
        $efnc = new EFNC();
        $imcome = new ImmediateConservatoryMeasures();
        $riskWeighting = new RiskWeighting();
        $product = new Product();
        $efnc->getImmediateConservatoryMeasures()->add($imcome);
        $efnc->getProduct($product);
        $efnc->getRiskWeighting($riskWeighting);
        $form1 = $this->createForm(FormCreationType::class, $efnc);

        $this->logger->info('full request at creation controller level' . json_encode($request->request->all()));
        if ($request->getMethod() == 'POST') {
            $form1->handleRequest($request);
            $this->logger->info('full request at creation controller level' . json_encode($request->request->all()));
            if (
                $form1->isSubmitted() && $form1->isValid()
            ) {
                $result1 = $this->formCreationService->createNCForm($efnc, $request, $form1);
                if (
                    $result1 === true
                ) {
                    $this->mailerService->notificationEmail($efnc);
                    $this->addFlash('success', 'C\'est bon khey!');
                    return $this->redirectToRoute('app_base', []);
                } else {
                    $this->addFlash('error', 'C\'est pas bon khey!');
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




    #[Route('/form{efncID}_modification_display', name: 'form_modification_display')]
    public function formModificationDisplay(int $efncID, Request $request): Response
    {
        $efnc = $this->EFNCRepository->find($efncID);
        if (!$efnc) {
            throw $this->createNotFoundException('No EFNC found for id ' . $efncID);
        }
        if ($efnc->getImmediateConservatoryMeasures()->isEmpty()) {
            $measure = new ImmediateConservatoryMeasures();
            $efnc->getImmediateConservatoryMeasures()->add($measure);
        }

        $riskWeighting = $efnc->getRiskWeighting();
        $efnc->getRiskWeighting($riskWeighting);

        $form1 = $this->createForm(FormCreationType::class, $efnc);

        if ($request->getMethod() == 'GET') {
            return $this->render('/services/efnc/modification/form_modification.html.twig', [
                'form1' => $form1->createView(),
                'EFNC' => $efnc,
            ]);
        } else if ($request->getMethod() == 'POST') {

            $form1->handleRequest($request);
            if ($form1->isValid() && $form1->isSubmitted()) {
                $result = $this->formModificationService->modifyNCForm(
                    $efnc,
                    $request,
                    $form1
                );
            }
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