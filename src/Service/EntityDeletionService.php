<?php



namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;

use Psr\Log\LoggerInterface;

use App\Entity\EFNC;

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
use Doctrine\Common\Collections\ArrayCollection;

// This class is responsible for managing the deletion of entities, their related entities from the database
// It also refer to the logic for deleting the folder and files from the server filesystem
class EntityDeletionService extends AbstractController
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
    public function archivedEntity(
        string $entityType,
        int $id,
        ?string  $commentary = null,
    ): bool {
        $entity = $this->entityObjectRetrieving($entityType, $id);
        if (!$entity) {
            return false;
        }
        // Deletion logic for related entities, folder and files
        if ($entityType === 'user') {
            $this->em->remove($entity);
        }
        if ($entityType === 'efnc') {
            $entity->setArchiver($this->getUser()->getUsername());
            $entity->setArchivingCommentary($commentary);
            $entity->setArchived(true);
        } else {
            $this->basicEntityManagement($entity, true);
        }

        $this->em->flush();

        return true;
    }

    public function deleteEntity(
        string $entityType,
        int $id
    ): bool {
        $entity = $this->entityObjectRetrieving($entityType, $id);
        if (!$entity) {
            return false;
        }
        // Deletion logic for related entities, folder and files
        if ($entityType === 'user') {
            $this->em->remove($entity);
        }
        if ($entityType === 'efnc') {
            $entity->setArchived(true);
        } else {
            $this->basicEntityManagement($entity, true);
        }

        $this->em->flush();

        return true;
    }


    public function unarchiveEntity(
        string $entityType,
        int $id
    ): bool {
        $entity = $this->entityObjectRetrieving($entityType, $id);
        if (!$entity) {
            return false;
        }
        // Deletion logic for related entities, folder and files
        if ($entityType === 'user') {
            $this->em->remove($entity);
        }
        if ($entityType === 'efnc') {
            $entity->setArchived(false);
        } else {
            $this->basicEntityManagement($entity, false);
        }

        $this->em->flush();

        return true;
    }


    public function closeEntity(
        string $entityType,
        int $id,
        ?string $commentary = null,
        ?string $user = null
    ): bool {

        $entity = $this->entityObjectRetrieving($entityType, $id);
        if (!$entity) {
            return false;
        }
        
        if ($entityType === 'efnc') {
            $entity->setCloser($user);
            $entity->setClosingCommentary($commentary);
            $entity->setArchived(true);
            $entity->setClosed(true);
        }

        $this->em->flush();

        return true;
    }

    public function entityObjectRetrieving(
        string $entityType,
        int $id
    ): Object|Bool {
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
        // Get the entity from the database
        $entity = $repository->find($id);

        return $entity;
    }


    public function basicEntityManagement($entity, Bool $flag): void
    {
        $entity->setArchived($flag);
        if (($forms = $entity->getEFNCs()) !== null) {
            $this->formArchiving($forms, $flag);
        } else {
            $this->basicEntityManagementWithMidEntities($entity, $flag);
        }
    }

    public function basicEntityManagementWithMidEntities($entity, Bool $flag): void
    {
        $midEntities = ($entity->getImmediateConservatoryMeasures() !== null) ? $entity->getImmediateConservatoryMeasures() : $entity->getProducts();
        foreach ($midEntities as $midEntity) {
            $this->formArchiving($midEntity->getEFNC(), $flag);
        }
    }

    public function formArchiving(ArrayCollection $efncs, Bool $flag): void
    {
        foreach ($efncs as $efnc) {
            $efnc->setArchived($flag);
            $this->setStatusFlag($efnc);
        }
    }

    public function setStatusFlag(EFNC $efnc): void
    {
        $status = $efnc->getStatus();
        $archived = $efnc->isArchived();
        $closed = $efnc->isClosed();

        if ($status === null) {
            if ($closed === true) {
                $efnc->setStatus('closed');
            } else if ($archived === true) {
                $efnc->setStatus('archived');
            } else {
                $efnc->setStatus('open');
            }
        }
    }
}
