<?php

namespace App\Twig;

use App\Repository\EFNCRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

use App\Repository\UserRepository;

class VariableExtension extends AbstractExtension implements GlobalsInterface
{
    private $userRepository;
    private $eFNCRepository;

    public function __construct(
        UserRepository             $userRepository,
        EFNCRepository             $eFNCRepository,
    ) {
        $this->userRepository          = $userRepository;
        $this->eFNCRepository          = $eFNCRepository;
    }

    public function getGlobals(): array
    {
        $usersExist = false;
        if (!empty($this->userRepository->findAll())) {
            $usersExist = true;
        }

        return [
            'usersExist'    => $usersExist,
            'EFNCs'         => $this->eFNCRepository->findAll(),

        ];
    }
}
