<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Project;
use App\Entity\Origin;
use App\Entity\UAP;
use App\Entity\AnomalyType;
use App\Entity\Place;
use App\Entity\ImmediateConservatoryMeasuresList;
use App\Entity\ProductCategory;
use App\Entity\ProductColor;
use App\Entity\ProductVersion;

use App\Form\TeamType;
use App\Form\ProjectType;
use App\Form\OriginType;
use App\Form\UAPType;
use App\Form\AnomalyForm;
use App\Form\PlaceType;
use App\Form\ImCoMeListType;
use App\Form\ProductCategoryType;
use App\Form\ProductColorType;
use App\Form\ProductVersionType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_')]
class AdminController extends FrontController
{

    #[Route('/admin/view', name: 'admin_page')]
    public function adminPage(): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('services/admin/admin_page.html.twig', []);
        }
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
                // Validation passed, you can proceed to save the entity
                $this->teamService->createTeam(
                    $team,
                    $request,
                    $teamForm
                );
                $this->addFlash('success', 'L\'équipe a bien été créée!');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $teamForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/team/team_creation.html.twig', [
                'teamForm' => $teamForm->createView(),
                'teams' => $this->teamRepository->findAll(),
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
                $this->addFlash('success', 'Le Projet a bien été ajouté.');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $projectForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/project/project_creation.html.twig', [
                'projectForm' => $projectForm->createView(),
                'projects' => $this->projectRepository->findAll(),
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
                $this->addFlash('success', 'Le lieu d\'origine a bien été ajouté');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $originForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/origin/origin_creation.html.twig', [
                'originForm' => $originForm->createView(),
                'origins' => $this->originRepository->findAll(),
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
                $this->addFlash('success', 'L\'UAP a bien été ajoutée');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $uapForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/uap/uap_creation.html.twig', [
                'uapForm' => $uapForm->createView(),
                'uaps' => $this->uapRepository->findAll(),
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
                $this->addFlash('success', 'Le Type d\'Anomalie a bien été ajouté');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $anomalyTypeForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/anomalyType/anomalyType_creation.html.twig', [
                'anomalyTypeForm' => $anomalyTypeForm->createView(),
                'anomalyTypes' => $this->anomalyTypeRepository->findAll(),
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
                $this->addFlash('success', 'Le lieu a bien été ajouté');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $placeForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/place/place_creation.html.twig', [
                'placeForm' => $placeForm->createView(),
                'places' => $this->placeRepository->findAll(),
            ]);
        }
    }

    #[Route('admin/services/imcomeList_creation', name: 'imcomeList_creation')]
    public function imcomeListCreation(Request $request): Response
    {
        $imcomeList = new ImmediateConservatoryMeasuresList();
        $imcomeListForm = $this->createForm(ImCoMeListType::class, $imcomeList);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $imcomeListForm->handleRequest($request);
            if ($imcomeListForm->isSubmitted() && $imcomeListForm->isValid()) {
                $this->imcomeService->imcomeListCreation(
                    $imcomeList,
                    $request,
                    $imcomeListForm
                );
                $this->addFlash('success', 'La Mesure Conservatoire Immédiate a bien été ajoutée');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $imcomeListForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/imcome/imcome_creation.html.twig', [
                'imcomeForm' => $imcomeListForm->createView(),
                'imcomes' => $this->imcomeRepository->findAll(),
            ]);
        }
    }

    #[Route('admin/services/productCategory_creation', name: 'productCategory_creation')]
    public function productCategoryCreation(Request $request): Response
    {
        $productCategory = new productCategory();
        $productCategoryForm = $this->createForm(productCategoryType::class, $productCategory);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $productCategoryForm->handleRequest($request);
            if ($productCategoryForm->isSubmitted() && $productCategoryForm->isValid()) {
                $this->productCategoryService->createProductCategory(
                    $productCategory,
                    $request,
                    $productCategoryForm
                );
                $this->addFlash('success', 'Le Type de Produit a bien été ajoutée');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $productCategoryForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/productCategory/product_category_creation.html.twig', [
                'productCategoryForm' => $productCategoryForm->createView(),
                'productCategories' => $this->productCategoryRepository->findAll(),
            ]);
        }
    }

    #[Route('admin/services/productColor_creation', name: 'productColor_creation')]
    public function productColorCreation(Request $request): Response
    {
        $productColor = new productColor();
        $productColorForm = $this->createForm(productColorType::class, $productColor);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $productColorForm->handleRequest($request);
            if ($productColorForm->isSubmitted() && $productColorForm->isValid()) {
                $this->productColorService->createProductColor(
                    $productColor,
                    $request,
                    $productColorForm
                );
                $this->addFlash('success', 'La Couleur Produit a bien été ajoutée');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $productColorForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/productColor/product_color_creation.html.twig', [
                'productColorForm' => $productColorForm->createView(),
                'productColors' => $this->productColorRepository->findAll(),
            ]);
        }
    }

    #[Route('admin/services/productVersion_creation', name: 'productVersion_creation')]
    public function productVersionCreation(Request $request): Response
    {
        $productVersion = new productVersion();
        $productVersionForm = $this->createForm(productVersionType::class, $productVersion);
        $originUrl = $request->headers->get('referer');
        if ($request->getMethod() == 'POST') {
            $productVersionForm->handleRequest($request);
            if ($productVersionForm->isSubmitted() && $productVersionForm->isValid()) {
                $this->productVersionService->createProductVersion(
                    $productVersion,
                    $request,
                    $productVersionForm
                );
                $this->addFlash('success', 'La Version Produit a bien été ajoutée');
                return $this->redirect($originUrl);
            } else {
                // Validation failed, get the error message and display it
                $errorMessage = $productVersionForm->getErrors(true)->current()->getMessage();
                $this->addFlash('danger', $errorMessage);
                return $this->redirect($originUrl);
            }
        } else if ($request->getMethod() == 'GET') {
            return $this->render('services/admin_services/productVersion/product_version_creation.html.twig', [
                'productVersionForm' => $productVersionForm->createView(),
                'productVersions' => $this->productVersionRepository->findAll(),
            ]);
        }
    }


    #[Route('admin/archive/{entityType}/{id}', name: 'archive_entity')]
    public function archiveEntity(Request $request, string $entityType, int $id): Response
    {
        $originUrl = $request->headers->get('referer');
        $user = $this->getUser()->getUsername();
        $commentary = $request->request->get('archivingCommentary');

        $this->logger->info($user . ' archived entity: ' . $entityType . ' ' . $id .  ' ' . 'commentaire: ' . $commentary . ' full request: ' . json_encode($request->getContent()));

        $result = $this->entityDeletionService->archivedEntity($entityType, $id, $commentary, $user);

        if ($result == false) {
            $this->addFlash('danger', 'L\'élément n\'a pas pu être archivé');
            return $this->redirect($originUrl);
        } else {
            $this->addFlash('success', 'L\'élément a bien été archivé');
            if ($entityType == "efnc") {
                return $this->redirectToRoute('app_base', []);
            } else {
                return $this->redirect($originUrl);
            }
        }
    }


    #[Route('admin/delete/{entityType}/{id}', name: 'delete_entity')]
    public function deleteEntity(Request $request, string $entityType, int $id): Response
    {
        $originUrl = $request->headers->get('referer');
        $result = $this->entityDeletionService->deleteEntity($entityType, $id);
        if ($result == false) {
            $this->addFlash('danger', 'L\'élément n\'a pas pu être supprimé');
            return $this->redirect($originUrl);
        } else {
            $this->addFlash('success', 'L\'élément a bien été supprimé');
            return $this->redirect($originUrl);
        }
    }


    #[Route('admin/unarchive/{entityType}/{id}', name: 'unarchive_entity')]
    public function unarchiveEntity(Request $request, string $entityType, int $id): Response
    {
        $originUrl = $request->headers->get('referer');
        $result = $this->entityDeletionService->unarchiveEntity($entityType, $id); // Implement this method in your service
        if ($result == false) {
            $this->addFlash('danger', 'L\'élément n\'a pas pu être restauré');
            return $this->redirect($originUrl);
        } else {
            $this->addFlash('success', 'L\'élément a bien été restauré');
            return $this->redirect($originUrl);
        }
    }
}
