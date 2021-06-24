<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Domain;

final class TextMother
{
    public static function random(int $chars): string
    {
        return MotherCreator::random()->text($chars);
    }
}
