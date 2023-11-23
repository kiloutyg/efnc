<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Project;

use App\Form\TeamType;
use App\Form\ProjectType;

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
}