<?php

declare(strict_types=1);

use Monitorings\User\Data\DoctrineUserRepository;
use Monitorings\User\Domain\User;
use Monitorings\User\Domain\UserRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/** @var ContainerBuilder $container */

$container
    ->register(UserRepository::class, DoctrineUserRepository::class)
    ->setFactory([new Reference('doctrine.orm.default_entity_manager'), 'getRepository'])
    ->addArgument(User::class)
;
