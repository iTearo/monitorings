<?php

declare(strict_types=1);

use Aws\S3\S3Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/** @var ContainerBuilder $container */

$container
    ->register('aws_client.s3', S3Client::class)
    ->setFactory([S3Client::class, 'factory'])
    ->addArgument(
        [
            'endpoint' => '%env(S3_ENDPOINT)%',
            'region' => '%env(S3_REGION)%',
            'version' => '%env(S3_VERSION)%',
            'credentials' => [
                'key' => '%env(S3_KEY)%',
                'secret' => '%env(S3_SECRET)%',
            ],
            'use_path_style_endpoint' => '%env(bool:S3_PATH_STYLE)%',
        ]
    )
;

$container->setAlias(S3Client::class, 'aws_client.s3');
