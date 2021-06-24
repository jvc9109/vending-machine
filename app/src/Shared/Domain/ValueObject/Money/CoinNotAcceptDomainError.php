<?php


namespace VendingMachine\Shared\Domain\ValueObject\Money;


use VendingMachine\Shared\Domain\DomainError;

final class CoinNotAcceptDomainError extends DomainError
{

    public function __construct(private float $coin)
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf(
            'The coin %.2f is not a valid coin for this machine. Please use 0.25, 0.10 or 0.05 coins',
            $this->coin
        );
    }
}
