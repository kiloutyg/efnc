<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

use App\Repository\UserRepository;

class VariableExtension extends AbstractExtension implements GlobalsInterface
{
    private $userRepository;

    public function __construct(
        UserRepository             $userRepository,
    ) {
        $this->userRepository          = $userRepository;
    }

    public function getGlobals(): array
    {
        $usersExist = false;
        if (!empty($this->userRepository->findAll())) {
            $usersExist = true;
        }
        return [
            'usersExist'    => $usersExist,
        ];
    }
}
