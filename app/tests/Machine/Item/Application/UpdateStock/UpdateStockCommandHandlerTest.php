<?php


namespace VendingMachine\Tests\Machine\Item\Application\UpdateStock;


use VendingMachine\Machine\Items\Application\UpdateStock\StockUpdater;
use VendingMachine\Machine\Items\Application\UpdateStock\UpdateStockCommand;
use VendingMachine\Machine\Items\Application\UpdateStock\UpdateStockCommandHandler;
use VendingMachine\Tests\Machine\Item\Domain\ItemMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStockMother;
use VendingMachine\Tests\Machine\Item\ItemModuleUnitTestCase;

final class UpdateStockCommandHandlerTest extends ItemModuleUnitTestCase
{
    private UpdateStockCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new UpdateStockCommandHandler(new StockUpdater(
            $this->repository(),
        ));
    }

    /** @test  */
    public function it_should_set_new_stock_count(): void
    {
        $item = ItemMother::create();
        $command = UpdateStockCommandMother::create($item->id());

        $expectedItem = ItemMother::create(
            $item->id(),
            $item->name(),
            $item->price(),
            $item->status(),
            ItemStockMother::create($command->stock())
        );

        $this->shouldSearch($item->id(), $item);

        $this->shouldSave($expectedItem);

        $this->dispatch($command, $this->handler);

    }
}
