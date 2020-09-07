<?php

declare(strict_types=1);

namespace TestTools;

use App\Kernel;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    private static Kernel $kernel;

    private static ContainerInterface $container;

    public static function setKernel(Kernel $kernel): void
    {
        self::$kernel = $kernel;

        $container = static::$kernel->getContainer();

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        static::$container = $container->has('test.service_container')
            ? $container->get('test.service_container')
            : $container;
    }

    protected static function getContainer(): ContainerInterface
    {
        return self::$container;
    }
}
