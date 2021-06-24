<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Query;

use VendingMachine\Shared\Domain\Bus\Query\Query;
use RuntimeException;

final class QueryNotRegisteredError extends RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = get_class($query);

        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}
