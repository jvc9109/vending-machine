<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponse;
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

    public function serviceMachine(): void
    {
        $this->type      = UserType::service();
        $this->updatedOn = new \DateTimeImmutable();

    }

    public function returnCoins(): UserCoins
    {
        $coins           = $this->coins;
        $this->coins     = new UserCoins([]);
        $this->updatedOn = new \DateTimeImmutable();

        return $coins;
    }

    public function recordChangeCoin(CoinsCounterResponse $coin): void
    {
        $this->insertCoin($coin->coinValue());
        $this->record(
            new UserCoinGivenDomainEvent(
                $this->id->value(),
                $coin->id()
            )
        );
    }

    public function insertCoin(float $coin): void
    {
        $this->coins     = $this->coins->add(new CoinValueObject($coin));
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function digestCoins(): void
    {
        /** @var CoinValueObject $coin */
        foreach ($this->coins as $coin) {
            $this->record(
                new UserCoinDigestedDomainEvent(
                    $this->id->value(),
                    $coin->value()
                )
            );
        }
        $this->coins = new UserCoins([]);
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
