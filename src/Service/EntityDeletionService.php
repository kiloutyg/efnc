<?php



namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;


// use App\Repository\UserRepository;



// This class is responsible for managing the deletion of entities, their related entities from the database
// It also refer to the logic for deleting the folder and files from the server filesystem
class EntityDeletionService
{
    private $em;
    
    private $userRepository;

    private $logger;


    public function __construct(
        EntityManagerInterface          $em,

        // UserRepository                  $userRepository,

        LoggerInterface                 $logger
    ) {
        $this->em                           = $em;

        // $this->userRepository               = $userRepository;

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