<?php



namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

use Psr\Log\LoggerInterface;

use App\Repository\UserRepository;
use App\Repository\TeamRepository;
use App\Repository\ProjectRepository;
use App\Repository\UAPRepository;
use App\Repository\OriginRepository;
use App\Repository\PlaceRepository;
use App\Repository\AnomalyTypeRepository;
use App\Repository\ImmediateConservatoryMeasuresListRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductColorRepository;
use App\Repository\ProductVersionRepository;
use App\Repository\EFNCRepository;


// This class is responsible for managing the deletion of entities, their related entities from the database
// It also refer to the logic for deleting the folder and files from the server filesystem
class EntityDeletionService
{
    private $em;

    private $userRepository;
    private $teamRepository;
    private $projectRepository;
    private $uapRepository;
    private $originRepository;
    private $placeRepository;
    private $anomalyTypeRepository;
    private $imcomeListRepository;
    private $productCategoryRepository;
    private $productColorRepository;
    private $productVersionRepository;
    private $EFNCRepository;

    private $logger;


    public function __construct(
        EntityManagerInterface                          $em,

        UserRepository                                  $userRepository,
        TeamRepository                                  $teamRepository,
        ProjectRepository                               $projectRepository,
        UapRepository                                   $uapRepository,
        OriginRepository                                $originRepository,
        PlaceRepository                                 $placeRepository,
        AnomalyTypeRepository                           $anomalyTypeRepository,
        ImmediateConservatoryMeasuresListRepository     $imcomeListRepository,
        ProductCategoryRepository                       $productCategoryRepository,
        ProductColorRepository                          $productColorRepository,
        ProductVersionRepository                        $productVersionRepository,
        EFNCRepository                                  $efncRepository,


        LoggerInterface                                 $logger
    ) {
        $this->em                           = $em;

        $this->userRepository               = $userRepository;
        $this->teamRepository               = $teamRepository;
        $this->projectRepository            = $projectRepository;
        $this->uapRepository                = $uapRepository;
        $this->originRepository             = $originRepository;
        $this->placeRepository              = $placeRepository;
        $this->anomalyTypeRepository        = $anomalyTypeRepository;
        $this->imcomeListRepository         = $imcomeListRepository;
        $this->productCategoryRepository    = $productCategoryRepository;
        $this->productColorRepository       = $productColorRepository;
        $this->productVersionRepository     = $productVersionRepository;
        $this->EFNCRepository               = $efncRepository;

        $this->logger                       = $logger;
    }

    // This function is responsible for deleting an entity and its related entities from the database and the server filesystem
    public function archivedEntity(string $entityType, int $id, string  $commentary = null, string $user = null): bool
    {
        // Get the repository for the entity type
        $repository = null;
        switch ($entityType) {

            case 'efnc':
                $repository = $this->EFNCRepository;
                break;
            case 'user':
                $repository = $this->userRepository;
                break;
            case 'team':
                $repository = $this->teamRepository;
                break;
            case 'project':
                $repository = $this->projectRepository;
                break;
            case 'uap':
                $repository = $this->uapRepository;
                break;
            case 'origin':
                $repository = $this->originRepository;
                break;
            case 'place':
                $repository = $this->placeRepository;
                break;
            case 'anomalyType':
                $repository = $this->anomalyTypeRepository;
                break;
            case 'imcome':
                $repository = $this->imcomeListRepository;
                break;
            case 'productCategory':
                $repository = $this->productCategoryRepository;
                break;
            case 'productColor':
                $repository = $this->productColorRepository;
                break;
            case 'productVersion':
                $repository = $this->productVersionRepository;
                break;
        }
        // If the repository is not found or the entity is not found in the database, return false
        if (!$repository) {
            return false;
        }
        // Get the entity from the database
        $entity = $repository->find($id);
        if (!$entity) {
            return false;
        }

        // Deletion logic for related entities, folder and files
        if ($entityType === 'user') {
            $this->em->remove($entity);
        }
        if ($entityType === 'efnc') {
            $entity->setLastModifier($user);
            $entity->setArchivingCommentary($commentary);
            $entity->setArchived(true);
        }
        if ($entityType === 'team') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'project') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'uap') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'origin') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'place') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'anomalyType') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'imcome') {
            $entity->setArchived(true);
            $midEntities = $entity->getImmediateConservatoryMeasures();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }
        if ($entityType === 'productCategory') {
            $entity->setArchived(true);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }
        if ($entityType === 'productColor') {
            $entity->setArchived(true);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }
        if ($entityType === 'productVersion') {
            $entity->setArchived(true);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }


        $this->em->flush();

        return true;
    }
    public function deleteEntity(string $entityType, int $id): bool
    {
        // Get the repository for the entity type
        $repository = null;
        switch ($entityType) {

            case 'efnc':
                $repository = $this->EFNCRepository;
                break;
            case 'user':
                $repository = $this->userRepository;
                break;
            case 'team':
                $repository = $this->teamRepository;
                break;
            case 'project':
                $repository = $this->projectRepository;
                break;
            case 'uap':
                $repository = $this->uapRepository;
                break;
            case 'origin':
                $repository = $this->originRepository;
                break;
            case 'place':
                $repository = $this->placeRepository;
                break;
            case 'anomalyType':
                $repository = $this->anomalyTypeRepository;
                break;
            case 'imcome':
                $repository = $this->imcomeListRepository;
                break;
            case 'productCategory':
                $repository = $this->productCategoryRepository;
                break;
            case 'productColor':
                $repository = $this->productColorRepository;
                break;
            case 'productVersion':
                $repository = $this->productVersionRepository;
                break;
        }
        // If the repository is not found or the entity is not found in the database, return false
        if (!$repository) {
            return false;
        }
        // Get the entity from the database
        $entity = $repository->find($id);
        if (!$entity) {
            return false;
        }

        // Deletion logic for related entities, folder and files
        if ($entityType === 'user') {
            $this->em->remove($entity);
        }
        if ($entityType === 'efnc') {
            $entity->setArchived(true);
        }
        if ($entityType === 'team') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'project') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'uap') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'origin') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'place') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'anomalyType') {
            $entity->setArchived(true);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(true);
            }
        }
        if ($entityType === 'imcome') {
            $entity->setArchived(true);
            $midEntities = $entity->getImmediateConservatoryMeasures();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }
        if ($entityType === 'productCategory') {
            $entity->setArchived(true);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }
        if ($entityType === 'productColor') {
            $entity->setArchived(true);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }
        if ($entityType === 'productVersion') {
            $entity->setArchived(true);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(true);
                }
            }
        }


        $this->em->flush();

        return true;
    }


    public function unarchiveEntity(string $entityType, int $id): bool
    {
        // Get the repository for the entity type
        $repository = null;
        switch ($entityType) {

            case 'efnc':
                $repository = $this->EFNCRepository;
                break;
            case 'user':
                $repository = $this->userRepository;
                break;
            case 'team':
                $repository = $this->teamRepository;
                break;
            case 'project':
                $repository = $this->projectRepository;
                break;
            case 'uap':
                $repository = $this->uapRepository;
                break;
            case 'origin':
                $repository = $this->originRepository;
                break;
            case 'place':
                $repository = $this->placeRepository;
                break;
            case 'anomalyType':
                $repository = $this->anomalyTypeRepository;
                break;
            case 'imcome':
                $repository = $this->imcomeListRepository;
                break;
            case 'productCategory':
                $repository = $this->productCategoryRepository;
                break;
            case 'productColor':
                $repository = $this->productColorRepository;
                break;
            case 'productVersion':
                $repository = $this->productVersionRepository;
                break;
        }
        // If the repository is not found or the entity is not found in the database, return false
        if (!$repository) {
            return false;
        }
        // Get the entity from the database
        $entity = $repository->find($id);
        if (!$entity) {
            return false;
        }

        // Deletion logic for related entities, folder and files
        if ($entityType === 'user') {
            $this->em->remove($entity);
        }
        if ($entityType === 'efnc') {
            $entity->setArchived(false);
        }
        if ($entityType === 'team') {
            $entity->setArchived(false);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(false);
            }
        }
        if ($entityType === 'project') {
            $entity->setArchived(false);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(false);
            }
        }
        if ($entityType === 'uap') {
            $entity->setArchived(false);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(false);
            }
        }
        if ($entityType === 'origin') {
            $entity->setArchived(false);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(false);
            }
        }
        if ($entityType === 'place') {
            $entity->setArchived(false);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(false);
            }
        }
        if ($entityType === 'anomalyType') {
            $entity->setArchived(false);
            $forms = $entity->getEFNCs();
            foreach ($forms as $form) {
                $form->setArchived(false);
            }
        }
        if ($entityType === 'imcome') {
            $entity->setArchived(false);
            $midEntities = $entity->getImmediateConservatoryMeasures();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(false);
                }
            }
        }
        if ($entityType === 'productCategory') {
            $entity->setArchived(false);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(false);
                }
            }
        }
        if ($entityType === 'productColor') {
            $entity->setArchived(false);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(false);
                }
            }
        }
        if ($entityType === 'productVersion') {
            $entity->setArchived(false);
            $midEntities = $entity->getProducts();
            foreach ($midEntities as $midEntity) {
                $forms = $midEntity->getEFNC();
                foreach ($forms as $form) {
                    $form->setArchived(false);
                }
            }
        }


        $this->em->flush();

        return true;
    }


    public function closeEntity(string $entityType, int $id, string $commentary = null, string $user = null): bool
    {
        $repository = null;
        switch ($entityType) {
            case "efnc":
                $repository = $this->EFNCRepository;
                break;
        }

        // If the repository is not found or the entity is not found in the database, return false
        if (!$repository) {
            return false;
        }
        // Get the entity from the database
        $entity = $repository->find($id);
        if (!$entity) {
            return false;
        }

        if ($entityType === 'efnc') {
            $entity->setLastModifier($user);
            $entity->setArchived(true);
            $entity->setStatus(true);
        }

        $this->em->flush();

        return true;
    }
}
