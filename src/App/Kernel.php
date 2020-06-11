<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getConfigDir(): string
    {
        return dirname(__DIR__, 2) . '/config';
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $confDir = $this->getConfigDir();

        $container->import($confDir . '/{packages}/*.yaml');
        $container->import($confDir . '/{packages}/' . $this->getEnvironment() . '/*.yaml');
        $container->import($confDir . '/{services}.yaml');
        $container->import($confDir . '/{services}_' . $this->getEnvironment() . '.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getConfigDir();

        $routes->import($confDir . '/{routes}/' . $this->getEnvironment() . '/*.yaml');
        $routes->import($confDir . '/{routes}/*.yaml');
        $routes->import($confDir . '/{routes}.yaml');
    }
}
