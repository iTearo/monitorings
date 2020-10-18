<?php

declare(strict_types=1);

use Domain\File\Domain\File;
use Domain\File\Domain\FileRepository;
use Domain\File\Domain\FileService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/** @var ContainerBuilder $container */

$container
    ->register(FileRepository::class)
    ->setFactory([new Reference('doctrine.orm.default_entity_manager'), 'getRepository'])
    ->addArgument(File::class)
;

$container
    ->register(FileService::class)
    ->addArgument(new Reference('default.storage'))
    ->addArgument(new Reference(FileRepository::class))
;
