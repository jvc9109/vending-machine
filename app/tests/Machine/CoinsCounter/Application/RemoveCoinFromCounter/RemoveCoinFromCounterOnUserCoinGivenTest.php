<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\RemoveCoinFromCounter;


use VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter\AddCoinsToCounterOnUserCoinDigested;
use VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter\CoinsCounterIncreaser;
use VendingMachine\Machine\CoinsCounter\Application\RemoveCoinFromCounter\CoinFromCounterRemover;
use VendingMachine\Machine\CoinsCounter\Application\RemoveCoinFromCounter\RemoveCoinFromCounterOnUserCoinGiven;
use VendingMachine\Tests\Machine\CoinsCounter\CoinsCounterModuleUnitTestCase;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterTotalCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinDigestedDomainEventMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinGivenDomainEventMother;

final class RemoveCoinFromCounterOnUserCoinGivenTest extends CoinsCounterModuleUnitTestCase
{
    private RemoveCoinFromCounterOnUserCoinGiven $subscriber;
    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriber = new RemoveCoinFromCounterOnUserCoinGiven(
            new CoinFromCounterRemover($this->repository())
        );
    }

    /** @test */
    public function it_should_remove_a_coin_to_counter(): void
    {
        $counter = CoinsCounterMother::create();

        $event = UserCoinGivenDomainEventMother::create(
            counterId: $counter->id()
        );

        $expectedCounter = CoinsCounterMother::create(
            $counter->id(),
            $counter->coin(),
            CoinsCounterTotalCoinsMother::create($counter->totalCoins()->value() - 1)
        );

        $this->shouldSearch($counter->id(), $counter);
        $this->shouldSave($expectedCounter);

        $this->notify($event, $this->subscriber);

    }
}
