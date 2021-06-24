<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Domain;

use function Lambdish\Phunctional\repeat;

final class Repeater
{
    public static function random(callable $function): array
    {
        return self::repeat($function, IntegerMother::lessThan(5));
    }

    public static function repeat(callable $function, $quantity): array
    {
        return repeat($function, $quantity);
    }
}
