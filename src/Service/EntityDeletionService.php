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
use App\Repository\ImmediateConservatoryMeasuresRepository;



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
    private $imcomeRepository;

    private $logger;


    public function __construct(
        EntityManagerInterface          $em,

        UserRepository                  $userRepository,
        TeamRepository                  $teamRepository,
        ProjectRepository               $projectRepository,
        UapRepository                   $uapRepository,
        OriginRepository                $originRepository,
        PlaceRepository                 $placeRepository,
        AnomalyTypeRepository           $anomalyTypeRepository,
        ImmediateConservatoryMeasuresRepository $imcomeRepository,

        LoggerInterface                 $logger
    ) {
        $this->em                           = $em;

        $this->userRepository               = $userRepository;
        $this->teamRepository               = $teamRepository;
        $this->projectRepository            = $projectRepository;
        $this->uapRepository                = $uapRepository;
        $this->originRepository             = $originRepository;
        $this->placeRepository              = $placeRepository;
        $this->anomalyTypeRepository        = $anomalyTypeRepository;
        $this->imcomeRepository             = $imcomeRepository;

        $this->logger                       = $logger;
    }

    // This function is responsible for deleting an entity and its related entities from the database and the server filesystem
    public function deleteEntity(string $entityType, int $id): bool
    {
        // Get the repository for the entity type
        $repository = null;
        switch ($entityType) {

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
                $repository = $this->imcomeRepository;
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

            $this->logger->info('user name: ' . $entity->getUsername());
        }

        $this->logger->info('entity Type: ' . $entityType);
        $this->em->remove($entity);
        $this->em->flush();

        return true;
    }
}