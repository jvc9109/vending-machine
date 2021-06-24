<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\Aggregate\AggregateRoot;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;

final class User extends AggregateRoot
{
    public function __construct(
        private UserId $id,
        private UserCoins $coins,
        private UserType $type
    )
    {
        parent::__construct();
    }

    public static function initSession(string $id): self
    {
        return new self(new UserId($id), new UserCoins([]), UserType::user());
    }

    public function insertCoin(float $coin): void
    {
        $this->coins = $this->coins->add(new CoinValueObject($coin));
    }

    public function serviceMachine(): void
    {
        $this->type = UserType::service();
    }

    public function returnCoins(): UserCoins
    {
        $coins = $this->coins;
        $this->coins = new UserCoins([]);

        return $coins;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function coins(): UserCoins
    {
        return $this->coins;
    }

    public function type(): UserType
    {
        return $this->type;
    }

}
