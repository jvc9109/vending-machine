<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Domain;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;

final class DateTimeImmutableMother
{
    public static function create(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable(MotherCreator::random()->dateTimeThisMonth());
    }

    public static function hourMinuteDow(int $hour, int $minute,
                                         DateTimeZone $timezone, string $dow = 'MONDAY'): DateTimeImmutable
    {
        $date = new DateTime('next ' . ucfirst($dow), $timezone);
        $date->setTime($hour, $minute);
        return DateTimeImmutable::createFromMutable($date);
    }
}
