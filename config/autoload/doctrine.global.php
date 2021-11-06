<?php

$doctrineLocal = require __DIR__
    . DIRECTORY_SEPARATOR
    . 'doctrine.local'
    . '.php';

$dbConnectionParams = $doctrineLocal['doctrine']['connection']['orm_default']['params'];

return [
    'dependencies' => [
        'factories' => [
            \Doctrine\ORM\EntityManagerInterface::class
                => \Roave\PsrContainerDoctrine\EntityManagerFactory::class,

            'doctrine.connection.orm_default'
                => \Roave\PsrContainerDoctrine\ConnectionFactory::class,

            'doctrine.configuration.orm_default'
                => \Roave\PsrContainerDoctrine\ConfigurationFactory::class,

            'doctrine.driver.orm_default'
                => \Roave\PsrContainerDoctrine\DriverFactory::class,

            \Doctrine\Migrations\Configuration\Migration\ConfigurationLoader::class
                => \Roave\PsrContainerDoctrine\Migrations\ConfigurationLoaderFactory::class,

            \Doctrine\Migrations\DependencyFactory::class
                => \Roave\PsrContainerDoctrine\Migrations\DependencyFactoryFactory::class,

            \Doctrine\Migrations\Tools\Console\Command\ExecuteCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\GenerateCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\LatestCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\MigrateCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\DiffCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\UpToDateCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\StatusCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\VersionCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\ListCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\RollupCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
            \Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand::class
                => \Roave\PsrContainerDoctrine\Migrations\CommandFactory::class,
        ],
    ],

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'array',
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'hydration_cache' => 'array',
                'driver' => 'orm_default',
                'auto_generate_proxy_classes' => true,
                'proxy_dir' => 'var/cache/DoctrineEntityProxy',
                'proxy_namespace' => 'DoctrineEntityProxy',
                'entity_namespaces' => ['src/App/Entity',],
                'datetime_functions' => [],
                'string_functions' => [],
                'numeric_functions' => [],
                'filters' => [],
                'named_queries' => [],
                'named_native_queries' => [],
                'custom_hydration_modes' => [],
                'naming_strategy' => null,
                'quote_strategy' => null,
                'default_repository_class_name' => null,
                'repository_factory' => null,
                'class_metadata_factory_name' => null,
                'entity_listener_resolver' => null,
                'second_level_cache' => [
                    'enabled' => false,
                    'default_lifetime' => 3600,
                    'default_lock_lifetime' => 60,
                    'file_lock_region_directory' => '',
                    'regions' => [],
                ],
                'sql_logger' => null,
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driver_class' => \Doctrine\DBAL\Driver\PDO\PgSQL\Driver::class,
                'pdo' => \PDO::class,
                'configuration' => 'orm_default',
                'event_manager' => 'orm_default',
                'wrapper_class' => null,
                'params' => $dbConnectionParams,
                'doctrine_mapping_types' => [],
                'doctrine_commented_types' => [],
            ],
        ],
        'entity_manager' => [
            'orm_default' => [
                'connection' => 'orm_default',
                'configuration' => 'orm_default',
            ],
        ],
        'event_manager' => [
            'orm_default' => [
                'subscribers' => [],
                'listeners' => [],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Persistence\Mapping\Driver\MappingDriverChain::class,
                'paths' => [],
                'extension' => null,
                'drivers' => ['App\Entity' => 'entities',],
                'global_basename' => null,
                'default_driver' => null,
            ],
            'entities' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => ['src/App/Entity'],
            ],
        ],
        'types' => [],
        'migrations' => [
            'orm_default' => [
                'table_storage' => [
                    'table_name' => 'doctrine_migration_versions',
                    'version_column_name' => 'version',
                    'version_column_length' => 1024,
                    'executed_at_column_name' => 'executed_at',
                    'execution_time_column_name' => 'execution_time',
                ],
                'migrations_paths' => ['App\Migrations' => 'db/migrations'],
                'all_or_nothing' => true,
                'check_database_platform' => true,
            ],
        ],

    ],
];
