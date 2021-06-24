<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use function Lambdish\Phunctional\first;
use function Lambdish\Phunctional\map;

final class MySqlDatabaseCleaner
{
    public function __invoke(EntityManagerInterface $entityManager): void
    {
        $connection = $entityManager->getConnection();

        $tables            = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($tables);

        $connection->executeStatement($truncateTablesSql);
    }

    private function tables(Connection $connection): array
    {
        return $connection->executeQuery('SHOW TABLES')->fetchAllAssociative();
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $truncateTables = map($this->truncateTableSql(), $tables);

        return sprintf('SET FOREIGN_KEY_CHECKS = 0; %s SET FOREIGN_KEY_CHECKS = 1;', implode(' ', $truncateTables));
    }

    private function truncateTableSql(): callable
    {
        return static function (array $table): string {
            return !str_contains(first($table), 'migrations') ? sprintf('TRUNCATE TABLE `%s`;', first($table)) : '';
        };
    }
}
