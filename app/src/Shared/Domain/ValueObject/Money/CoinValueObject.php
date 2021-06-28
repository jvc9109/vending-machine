<?php


namespace VendingMachine\Shared\Domain\ValueObject\Money;


class CoinValueObject
{
    public const VALID_COINS = [1.00, 0.25, 0.10, 0.05];

    final public function __construct(protected float $value)
    {
        $this->ensureValidValue($value);
    }

    public function value(): float
    {
        return $this->value;
    }

    private function ensureValidValue(float $value): void
    {
        if (!in_array($value, self::VALID_COINS)) {
            throw new CoinNotAcceptDomainError($value);
        }
    }

}
