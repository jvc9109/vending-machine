<?php


namespace VendingMachine\Tests\Machine\CoinsCounter;


use Mockery\MockInterface;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class CoinsCounterModuleUnitTestCase extends UnitTestCase
{

    protected function shouldSave(CoinsCounter $coinsCounter): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($coinsCounter))
            ->andReturnNull();
    }

    protected function shouldSearch(?CoinsCounterId $coinsCounterId, ?CoinsCounter $coinsCounter): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->with($this->similarTo($coinsCounterId))
            ->andReturn($coinsCounter);
    }

    protected function shouldSearchByValue(?CoinsCounterCoinValue $coinValue, ?CoinsCounter $coinsCounter): void
    {
        $this->repository()
            ->shouldReceive('searchByCoinValue')
            ->once()
            ->with($this->similarTo($coinValue))
            ->andReturn($coinsCounter);
    }

    protected function repository(): CoinsCounterRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(CoinsCounterRepository::class);
    }

}
