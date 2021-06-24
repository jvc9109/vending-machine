<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure;

use VendingMachine\Shared\Domain\RandomNumberGenerator;

final class ConstantRandomNumberGenerator implements RandomNumberGenerator
{
    public function generate(): int
    {
        return 1;
    }
}
