<?php

namespace App\Doctrine;

use App\Entity\User;

interface OwnerableInterface
{
    public function getUser(): ?User;
    public function setUser(User $user): void;
}
