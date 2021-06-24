<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Doctrine;

use VendingMachine\Shared\Infrastructure\Doctrine\Dbal\DbalCustomTypesRegistrar;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Tools\Setup;
use RuntimeException;
use function Lambdish\Phunctional\dissoc;

final class DoctrineEntityManagerFactory
{
    private static array $sharedPrefixes = [
        __DIR__ . '/../../../Shared/Infrastructure/Persistence/Mappings' => 'VendingMachine\Shared\Domain',
    ];

    public static function create(
        array $parameters,
        array $contextPrefixes,
        bool $isDevMode,
        string $schemaFile,
        array $dbalCustomTypesClasses,
        ?SQLLogger $logger
    ): EntityManager
    {
        if ($isDevMode) {
            self::generateDatabaseIfNotExists($parameters, $schemaFile);
        }

        DbalCustomTypesRegistrar::register($dbalCustomTypesClasses);

        return EntityManager::create($parameters, self::createConfiguration($contextPrefixes, $isDevMode, $logger));
    }

    private static function generateDatabaseIfNotExists(array $parameters, string $schemaFile): void
    {
        self::ensureSchemaFileExists($schemaFile);

        $databaseName                  = $parameters['dbname'];
        $parametersWithoutDatabaseName = dissoc($parameters, 'dbname');
        $connection                    = DriverManager::getConnection($parametersWithoutDatabaseName);
        $schemaManager                 = new MySqlSchemaManager($connection);

        if (!self::databaseExists($databaseName, $schemaManager)) {
            $schemaManager->createDatabase($databaseName);
            $connection->executeStatement(sprintf('USE %s', $databaseName));
            $connection->executeStatement(file_get_contents(realpath($schemaFile)));
        }

        $connection->close();
    }

    private static function ensureSchemaFileExists(string $schemaFile): void
    {
        if (!file_exists($schemaFile)) {
            throw new RuntimeException(sprintf('The file <%s> does not exist', $schemaFile));
        }
    }

    private static function databaseExists($databaseName, MySqlSchemaManager $schemaManager): bool
    {
        return in_array($databaseName, $schemaManager->listDatabases(), true);
    }

    private static function createConfiguration(array $contextPrefixes, bool $isDevMode, ?SQLLogger $logger): Configuration
    {
        $cache  = $isDevMode ? new ArrayCache() : new ApcuCache();
        $config = Setup::createConfiguration($isDevMode, null, $cache);
        $config->setSQLLogger($logger);

        $config->setMetadataDriverImpl(new SimplifiedXmlDriver(array_merge(self::$sharedPrefixes, $contextPrefixes)));

        return $config;
    }
}
