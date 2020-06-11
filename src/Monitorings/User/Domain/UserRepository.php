<?php

declare(strict_types=1);

namespace Monitorings\User\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserRepository
{
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void;

    public function save(User $user): void;
}
