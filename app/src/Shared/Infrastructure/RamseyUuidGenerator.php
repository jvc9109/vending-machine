<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure;

use VendingMachine\Shared\Domain\UuidGenerator;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
