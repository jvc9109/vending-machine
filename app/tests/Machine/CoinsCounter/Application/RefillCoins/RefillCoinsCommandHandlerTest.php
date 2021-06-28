<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\RefillCoins;


use VendingMachine\Machine\CoinsCounter\Application\RefillCoins\CoinsRefiller;
use VendingMachine\Machine\CoinsCounter\Application\RefillCoins\RefillCoinsCommandHandler;
use VendingMachine\Tests\Machine\CoinsCounter\CoinsCounterModuleUnitTestCase;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterTotalCoinsMother;

final class RefillCoinsCommandHandlerTest extends CoinsCounterModuleUnitTestCase
{
    private RefillCoinsCommandHandler $handler;

    /** @test */
    public function it_should_refill_a_counter(): void
    {
        $counter = CoinsCounterMother::create();
        $command = RefillCoinsCommandMother::create($counter->id());

        $expectedCounter = CoinsCounterMother::create(
            $counter->id(),
            $counter->coin(),
            CoinsCounterTotalCoinsMother::create($counter->totalCoins()->value()+$command->amount())
        );

        $this->shouldSearch($counter->id(), $counter);

        $this->shouldSave($expectedCounter);

        $this->dispatch($command, $this->handler);

    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new RefillCoinsCommandHandler(
            new CoinsRefiller($this->repository())
        );
    }
}
