<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\User;

use App\Repository\UserRepository;

use App\Service\EntityDeletionService;

// This class is responsible for managing the user accounts logic
class AccountService
{
    private $passwordHasher;
    private $userRepository;
    private $manager;
    private $entityDeletionService;
    private $logger;
    private $validator;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        EntityDeletionService $entityDeletionService,
        LoggerInterface $logger,
        ValidatorInterface $validator
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->entityDeletionService = $entityDeletionService;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    // This function is responsible for creating a new user account and persisting it to the database
    public function createAccount(Request $request)
    {
        $this->logger->info('full request: ' . json_encode($request->request->all()));
        if ($request->getMethod() == 'POST') {
            $name = $request->request->get('username');
            $password = $request->request->get('password');
            $emailAddress = $request->request->get('emailAddress');

            if ($request->request->get('role') == '') {
                $role = 'ROLE_USER';
            } else {
                $role = $request->request->get('role');
            };

            if ($role == 'ROLE_ADMIN' && $password == '') {
                throw new \Exception('Le mot de passe ne peut pas être vide.');
            }
            // check if the username is already in use
            $user = $this->userRepository->findOneBy(['username' => $name]);
            if ($user) {
                $error = 'Ce nom d\'utilisateur est déja utilisé.';
            } else {
                // create the user
                $user = new User();
                if ($password == '') {
                } else {
                    $password = $this->passwordHasher->hashPassword($user, $password);
                    $user->setPassword($password);
                }
                $user->setUsername($name);
                $user->setRoles([$role]);
                $user->setEmailAddress($emailAddress);
                $errors = $this->validator->validate($user);
                if (count($errors) > 0) {
                    $errorMessages = [];
                    foreach ($errors as $violation) {
                        // You can use ->getPropertyPath() if you need to show the field name
                        // $errorMessages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
                        $errorMessages[] = $violation->getMessage();
                    }

                    // Now you have an array of user-friendly messages you can display
                    // For example, you can separate them with new lines when displaying in text format:
                    $errorsString = implode("\n", $errorMessages);

                    // If you need to return JSON response:
                    // return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);

                    throw new \Exception($errorsString);
                }

                $this->manager->persist($user);
                $this->manager->flush();

                return  $user;
            }
        }
        return null;
    }

    // This function is responsible for modifying a user account and persisting the modification to the database
    public function modifyAccount(Request $request, UserInterface $currentUser, User $user)
    {
        if ($request->getMethod() == 'POST') {

            $emailAddress = $request->request->get('emailAddress');

            // Check if the current user is a super admin
            if (in_array('ROLE_SUPER_ADMIN', $currentUser->getRoles())) {

                // Get the user to be modified
                if ($user) {
                    if ($request->request->get('username') != '') {
                        $newName = $request->request->get('username');

                        if ($this->userRepository->findOneBy(['username' => $newName])) {
                            return 'Ce nom d\'utilisateur est déja utilisé.';
                        } else {
                            $password = $user->getPassword();
                            if ($password == '') {
                            } else {
                                $password = $this->passwordHasher->hashPassword($user, $password);
                                $user->setPassword($password);
                            }
                            $user->setUsername($newName); // Set the new username
                        }
                    };
                    if ($request->request->get('password') != '') {
                        $password = $request->request->get('password');
                        $password = $this->passwordHasher->hashPassword($user, $password);
                        $user->setPassword($password);
                    };
                    if ($request->request->get('role') != '') {
                        $role = $request->request->get('role');
                        $user->setRoles([$role]);
                    };

                    if ($request->request->get('emailAddress') != '') {
                        $emailAddress = $request->request->get('emailAddress');
                        $user->setEmailAddress($emailAddress);
                    };

                    $this->manager->persist($user);
                    $this->manager->flush();

                    return $user;
                }
            }
        }

        return null;
    }

    // This function is responsible for deleting a user account from the database
    public function deleteUser($id)
    {
        $user = $this->userRepository->find($id);
        $result = $this->entityDeletionService->deleteEntity('user', $id);
        if ($result) {
            $this->manager->remove($user);
            $this->manager->flush();
            return true;
        }
    }

    // This function is responsible for blocking a user account

    public function blockUser($id)
    {
        $user = $this->userRepository->find($id);
        $user->setPassword('');
        $user->setRoles(['ROLE_USER']);
        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function updateUserEmail(User $user)
    {
        $username = $user->getUsername();
        $emailAddress = $username . '@' . 'plasticomnium.com';
        $user->setEmailAddress($emailAddress);
        $this->manager->persist($user);
        $this->manager->flush();
        return;
    }
}
