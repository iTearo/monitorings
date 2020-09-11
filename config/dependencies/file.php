<?php

declare(strict_types=1);

use Monitorings\File\Domain\File;
use Monitorings\File\Domain\FileRepository;
use Monitorings\File\Domain\FileService;
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
