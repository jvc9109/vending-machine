<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\Aggregate\AggregateRoot;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinsCollection;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use const Lambdish\Phunctional\map;

final class Item extends AggregateRoot
{

    public function __construct(
        private ItemId $id,
        private ItemName $name,
        private ItemPrice $price,
        private ItemStatus $status,
        private ItemStock $stock
    )
    {
        parent::__construct();
    }

    public static function create(string $id, string $name, float $price, int $stock)
    {
       return new self(
            new ItemId($id),
            new ItemName($name),
            new ItemPrice($price),
            ItemStatus::available(),
            new ItemStock($stock)
        );

    }

    public function purchaseItem(CoinsCollection $userCoins, string $userId): void
    {
        $availableMoney = 0;
        foreach ($userCoins as $coin) {
            /** @var CoinValueObject $coin */
            $availableMoney += $coin->value();
        }

        if ($availableMoney < $this->price->value()) {
            //TODO add domain eRRor
            throw new \Exception();
        }

        $this->stock = $this->stock->reduceOne();

        if ($this->stock->isEmpty()) {
            $this->status = ItemStatus::outOfStock();
        }

        $this->record(
            new ItemPurchasedDomainEvent($this->id->value(), $this->price->value(), $userId)
        );
    }

    public function makeStock(int $stock): void
    {
        $this->stock = new ItemStock($stock);
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function id(): ItemId
    {
        return $this->id;
    }

    public function name(): ItemName
    {
        return $this->name;
    }

    public function price(): ItemPrice
    {
        return $this->price;
    }

    public function status(): ItemStatus
    {
        return $this->status;
    }

    public function stock(): ItemStock
    {
        return $this->stock;
    }


}
