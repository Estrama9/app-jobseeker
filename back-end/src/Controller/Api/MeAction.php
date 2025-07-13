<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class MeAction extends AbstractController
{
    public function __invoke(#[CurrentUser] ?User $user): ?User
    {
        return $user;
    }
}
