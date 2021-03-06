<?php


namespace VendingMachine\Machine\Items\Application\Obtain;


use VendingMachine\Shared\Domain\Bus\Query\Response;

final class ItemResponse implements Response
{

    public function __construct(
        private string $id,
        private string $name,
        private float $value,
        private int $status,
        private int $stock
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function stock(): int
    {
        return $this->stock;
    }

}
