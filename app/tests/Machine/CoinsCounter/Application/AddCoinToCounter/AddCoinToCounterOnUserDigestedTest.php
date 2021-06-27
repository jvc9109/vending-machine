<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\AddCoinToCounter;


use VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter\AddCoinsToCounterOnUserCoinDigested;
use VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter\CoinsCounterIncreaser;
use VendingMachine\Tests\Machine\CoinsCounter\CoinsCounterModuleUnitTestCase;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterTotalCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinDigestedDomainEventMother;

final class AddCoinToCounterOnUserDigestedTest extends CoinsCounterModuleUnitTestCase
{
    private AddCoinsToCounterOnUserCoinDigested $subscriber;
    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriber = new AddCoinsToCounterOnUserCoinDigested(
            new CoinsCounterIncreaser($this->repository())
        );
    }

    /** @test */
    public function it_should_add_a_coin_to_counter(): void
    {
        $counter = CoinsCounterMother::create();

        $event = UserCoinDigestedDomainEventMother::create(
            coinValue: $counter->coin()->value()
        );

        $expectedCounter = CoinsCounterMother::create(
            $counter->id(),
            $counter->coin(),
            CoinsCounterTotalCoinsMother::create($counter->totalCoins()->value() + 1)
        );

        $this->shouldSearchByValue($counter->coin(), $counter);
        $this->shouldSave($expectedCounter);

        $this->notify($event, $this->subscriber);

    }
}
