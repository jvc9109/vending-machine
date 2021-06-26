<?php


namespace VendingMachine\Tests\Machine\Item;


use Mockery\MockInterface;
use VendingMachine\Machine\Items\Domain\Item;
use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemRepository;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class ItemModuleUnitTestCase extends UnitTestCase
{
    private ItemRepository|MockInterface|null $repository;

    protected function shouldSave(Item $item): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($item))
            ->andReturnNull();
    }

    protected function shouldSearch(?ItemId $itemId, ?Item $item): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->with($this->similarTo($itemId))
            ->andReturn($item);
    }

    protected function repository(): ItemRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(ItemRepository::class);
    }
}
