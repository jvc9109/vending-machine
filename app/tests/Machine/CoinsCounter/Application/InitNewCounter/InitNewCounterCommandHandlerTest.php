<?php


namespace VendingMachine\Tests\Machine\CoinsCounter\Application\InitNewCounter;


use VendingMachine\Machine\CoinsCounter\Application\InitNewCounter\CounterInitializer;
use VendingMachine\Machine\CoinsCounter\Application\InitNewCounter\InitNewCounterCommandHandler;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Tests\Machine\CoinsCounter\CoinsCounterModuleUnitTestCase;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterCoinValueMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterIdMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterTotalCoinsMother;

final class InitNewCounterCommandHandlerTest extends CoinsCounterModuleUnitTestCase
{
    private InitNewCounterCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new InitNewCounterCommandHandler(
            new CounterInitializer($this->repository())
        );
    }

    /** @test */
    public function it_should_init_a_counter(): void
    {
        $command = InitNewCounterCommandMother::create();

        $expectedCounter = CoinsCounterMother::create(
            CoinsCounterIdMother::create($command->counterId()),
            CoinsCounterCoinValueMother::create($command->coinValue()),
            CoinsCounterTotalCoinsMother::initialize()
        );

        $this->shouldSave($expectedCounter);

        $this->dispatch($command, $this->handler);

    }


}
