<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Project;
use App\Entity\Origin;
use App\Entity\UAP;
use App\Entity\AnomalyType;
use App\Entity\Place;

use App\Form\TeamType;
use App\Form\ProjectType;
use App\Form\OriginType;
use App\Form\UAPType;
use App\Form\AnomalyForm;
use App\Form\PlaceType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_')]
class AdminController extends FrontController
{

    #[Route('/admin/view', name: 'admin_page')]
    public function adminPage(): Response
    {
        return $this->render('services/admin/admin_page.html.twig', []);
    }

    #[Route('admin/services/team_creation', name: 'team_creation')]
    public function teamCreation(Request $request): Response
    {
        $team = new Team();
        $teamForm = $this->createForm(TeamType::class, $team);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $teamForm->handleRequest($request);
            if ($teamForm->isSubmitted() && $teamForm->isValid()) {
                $this->teamService->createTeam(
                    $team,
                    $request,
                    $teamForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/team/team_creation.html.twig', [
                'teamForm' => $teamForm->createView(),
            ]);
        }
    }


    #[Route('admin/services/project_creation', name: 'project_creation')]
    public function projectCreation(Request $request): Response
    {
        $project = new Project();
        $projectForm = $this->createForm(ProjectType::class, $project);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $projectForm->handleRequest($request);
            if ($projectForm->isSubmitted() && $projectForm->isValid()) {
                $this->projectService->createProject(
                    $project,
                    $request,
                    $projectForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/project/project_creation.html.twig', [
                'projectForm' => $projectForm->createView(),
            ]);
        }
    }

    #[Route('admin/services/origin_creation', name: 'origin_creation')]
    public function originCreation(Request $request): Response
    {
        $origin = new Origin();
        $originForm = $this->createForm(OriginType::class, $origin);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $originForm->handleRequest($request);
            if ($originForm->isSubmitted() && $originForm->isValid()) {
                $this->originService->createOrigin(
                    $origin,
                    $request,
                    $originForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/origin/origin_creation.html.twig', [
                'originForm' => $originForm->createView(),
            ]);
        }
    }

    #[Route('admin/services/uap_creation', name: 'uap_creation')]
    public function uapCreation(Request $request): Response
    {
        $uap = new UAP();
        $uapForm = $this->createForm(UAPType::class, $uap);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $uapForm->handleRequest($request);
            if ($uapForm->isSubmitted() && $uapForm->isValid()) {
                $this->uapService->createUAP(
                    $uap,
                    $request,
                    $uapForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/uap/uap_creation.html.twig', [
                'uapForm' => $uapForm->createView(),
            ]);
        }
    }

    #[Route('admin/services/anomalyType_creation', name: 'anomalyType_creation')]
    public function anomalyTypeCreation(Request $request): Response
    {
        $anomalyType = new AnomalyType();
        $anomalyTypeForm = $this->createForm(AnomalyForm::class, $anomalyType);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $anomalyTypeForm->handleRequest($request);
            if ($anomalyTypeForm->isSubmitted() && $anomalyTypeForm->isValid()) {
                $this->anomalyTypeService->createAnomalyType(
                    $anomalyType,
                    $request,
                    $anomalyTypeForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/anomalyType/anomalyType_creation.html.twig', [
                'anomalyTypeForm' => $anomalyTypeForm->createView(),
            ]);
        }
    }

    #[Route('admin/services/place_creation', name: 'place_creation')]
    public function placeCreation(Request $request): Response
    {
        $place = new Place();
        $placeForm = $this->createForm(PlaceType::class, $place);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $placeForm->handleRequest($request);
            if ($placeForm->isSubmitted() && $placeForm->isValid()) {
                $this->placeService->createPlace(
                    $place,
                    $request,
                    $placeForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/place/place_creation.html.twig', [
                'placeForm' => $placeForm->createView(),
            ]);
        }
    }

    #[Route('admin/services/imcome_creation', name: 'imcome_creation')]
    public function imcomeCreation(Request $request): Response
    {
        $imcome = new Place();
        $imcomeForm = $this->createForm(PlaceType::class, $imcome);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $imcomeForm->handleRequest($request);
            if ($imcomeForm->isSubmitted() && $imcomeForm->isValid()) {
                $this->imcomeService->createPlace(
                    $imcome,
                    $request,
                    $imcomeForm
                );
                $this->addFlash('success', 'C\'est bon khey!');
                return $this->redirect($originUrl);
            } else {
                $this->addFlash('error', 'C\'est pas bon khey!');
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/place/place_creation.html.twig', [
                'placeForm' => $placeForm->createView(),
            ]);
        }
    }
}