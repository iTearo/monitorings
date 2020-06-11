<?php

declare(strict_types=1);

namespace Monitorings\User\Data;

use App\Doctrine\Repository;
use Monitorings\User\Domain\User;
use Monitorings\User\Domain\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DoctrineUserRepository extends Repository implements UserRepository, PasswordUpgraderInterface
{
    public const TABLE = 'user';

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);

        $this->save($user);
    }
}
