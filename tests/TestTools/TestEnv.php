<?php

declare(strict_types=1);

namespace TestTools;

use App\Kernel;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestEnv
{
    protected static Kernel $kernel;

    public static function setKernel(Kernel $kernel): void
    {
        self::$kernel = $kernel;
    }

    protected static function getContainer(): ContainerInterface
    {
        return self::$kernel->getContainer();
    }

    protected static function getEntityManager(): EntityManager
    {
        return self::getContainer()->get('doctrine.orm.default_entity_manager');
    }
}
