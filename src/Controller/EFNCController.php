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
        $product = new Product();
        $riskWeighting = new RiskWeighting();

        $efnc->getImmediateConservatoryMeasures()->add($imcome);
        $efnc->getProduct($product);
        $efnc->getRiskWeighting($riskWeighting);
        $form1 = $this->createForm(FormCreationType::class, $efnc);

        if ($request->getMethod() == 'POST') {
            $form1->handleRequest($request);
            if (
                $form1->isSubmitted() && $form1->isValid()
            ) {
                $result1 = $this->formCreationService->createNCForm($efnc, $request, $form1);
                if (
                    $result1 === true
                ) {
                    $result2 = $this->mailerService->notificationEmail($efnc);
                    if ($result2 === true) {
                        $this->addFlash('success', 'Fiche correctement créée et envoyée par mail!');
                        return $this->redirectToRoute('app_base', []);
                    } else {
                        $this->addFlash('error', 'Erreur lors de l\'envoi du mail!');
                        return $this->redirectToRoute('app_base', []);
                    }
                } else {
                    $this->addFlash('error', 'Erreur lors de l\'enregistrement de la fiche!');
                    return $this->redirectToRoute('app_base', []);
                }
            } else {
                $this->addFlash('error', 'Erreur lors de la création de la fiche!');
                return $this->redirectToRoute('app_base', []);
            }
        } else {

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

        if ($request->getMethod() == 'POST') {
            if ($this->getUser() !== null) {
                if ($this->authChecker->isGranted('ROLE_ADMIN')) {
                    if ($efnc->isArchived() !== true || $efnc->isClosed() !== true) {
                        $user = $this->getUser()->getUsername();
                        $form1->handleRequest($request);
                        if ($form1->isValid() && $form1->isSubmitted()) {
                            $result = $this->formModificationService->modifyNCForm(
                                $efnc,
                                $request,
                                $form1,
                                $user
                            );
                        }
                        if ($result === true) {

                            $this->addFlash('success', 'Fiche correctement modifiée!');
                            return $this->redirectToRoute('app_base', []);
                        } else {
                            $this->addFlash('error', 'Erreur lors de la modification de la fiche!');
                            return $this->redirectToRoute('app_base', []);
                        }
                    } else {
                        $this->addFlash('error', 'Vous ne pouvez pas modifier une fiche archivée ou cloturée!');
                        return $this->redirectToRoute('app_base', []);
                    }
                } else {
                    $this->addFlash('error', 'Vous n\'avez pas les droits pour modifier cette fiche!');
                    return $this->redirectToRoute('app_base', []);
                }
            } else {
                $this->addFlash('error', 'Vous devez êtres connecté pour modifier cette fiche!');
                return $this->redirectToRoute('app_base', []);
            }
        } else {
            return $this->render('/services/efnc/modification/form_modification.html.twig', [
                'form1' => $form1->createView(),
                'EFNC' => $efnc,
            ]);
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
