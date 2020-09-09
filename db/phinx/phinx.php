<?php

use Symfony\Component\Dotenv\Dotenv;

function makeConfig(string $envFilePath, bool $overrideByEnvs = false): ?array
{
    $envs = (new Dotenv())->parse(file_get_contents($envFilePath), $envFilePath);

    if ($overrideByEnvs === true) {
        $envs = array_filter($envs, static fn($envKey) => getenv($envKey) === false, ARRAY_FILTER_USE_KEY);
    }

    return [
        'dsn' => $envs['DATABASE_URL'] ?? getenv('DATABASE_URL'),
    ];
}

$phinxDir = '%%PHINX_CONFIG_DIR%%';

$appRootDir = __DIR__ . '/../..';

return [
    'paths' => [
        'migrations' => $phinxDir . '/migrations',
        'seeds' => $phinxDir . '/seeds'
    ],
    'templates' => [
        'file' => $phinxDir . '/MigrationClass.template',
    ],
    'environments' => [
        'default_migration_table' => 'phinx_log',
        'default_environment' => 'app',
        'app' => makeConfig($appRootDir . '/.env', true),
        'test' => makeConfig($appRootDir . '/.env.test'),
    ],
    'version_order' => 'execution',
];
