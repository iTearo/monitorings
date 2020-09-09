<?php

use Symfony\Component\Dotenv\Dotenv;

function parseAgnosticDsn(string $dsn): ?array
{
    $regex = '#^(?P<adapter>[^\\:]+)\\://(?:(?P<user>[^\\:@]+)(?:\\:(?P<pass>[^@]*))?@)?'
        . '(?P<host>[^\\:@/]+)(?:\\:(?P<port>[1-9]\\d*))?/(?P<name>[^\?]+)(?:\?(?P<query>.*))?$#';

    if (preg_match($regex, trim($dsn), $parsedOptions)) {
        $additionalOpts = [];
        if (isset($parsedOptions['query'])) {
            parse_str($parsedOptions['query'], $additionalOpts);
        }
        $validOptions = ['adapter', 'user', 'pass', 'host', 'port', 'name'];
        $parsedOptions = array_filter(array_intersect_key($parsedOptions, array_flip($validOptions)));
        return array_merge($additionalOpts, $parsedOptions);
    }

    return null;
}

function makeConfig(string $envFilePath, bool $overrideByEnvs = false): ?array
{
    $envs = (new Dotenv())->parse(file_get_contents($envFilePath), $envFilePath);

    if ($overrideByEnvs === true) {
        $envs = array_filter($envs, fn($envKey) => getenv($envKey) === false, ARRAY_FILTER_USE_KEY);
    }

    return parseAgnosticDsn($envs['DATABASE_URL'] ?? getenv('DATABASE_URL'));
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
