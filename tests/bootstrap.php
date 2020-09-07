<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use TestTools\TestCase;
use TestTools\TestEnv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

Debug::enable();

$kernel = new Kernel($_SERVER['APP_ENV'], true);
$kernel->boot();

TestCase::setKernel($kernel);
TestEnv::setKernel($kernel);
