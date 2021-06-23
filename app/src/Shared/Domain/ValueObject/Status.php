<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Domain\ValueObject;


abstract class Status extends IntValueObject
{
    private const ACTIVE = 1;
    private const DISABLED = 0;
    private const DELETED = 2;

    final public function __construct(int $value)
    {
        parent::__construct($value);
    }

    final public static function ACTIVE(): static
    {
        return new static(self::ACTIVE);
    }

    final public static function DELETED(): static
    {
        return new static(self::DELETED);
    }

    final public static function DISABLED(): static
    {
        return new static(self::DISABLED);
    }

    final public function isActive(): bool
    {
        return self::ACTIVE === $this->value;
    }

    final public function isDeleted(): bool
    {
        return self::DELETED === $this->value;
    }

    final public function isDisabled(): bool
    {
        return self::DISABLED === $this->value;
    }
}
