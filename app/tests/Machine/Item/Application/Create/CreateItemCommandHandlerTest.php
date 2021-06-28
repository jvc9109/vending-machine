<?php


namespace VendingMachine\Tests\Machine\Item\Application\Create;


use VendingMachine\Machine\Items\Application\Create\CreateItemCommandHandler;
use VendingMachine\Machine\Items\Application\Create\ItemCreator;
use VendingMachine\Machine\Items\Domain\ItemStock;
use VendingMachine\Tests\Machine\Item\Domain\ItemIdMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemNameMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPriceMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStatusMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStockMother;
use VendingMachine\Tests\Machine\Item\ItemModuleUnitTestCase;

final class CreateItemCommandHandlerTest extends ItemModuleUnitTestCase
{
    private CreateItemCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new CreateItemCommandHandler(new ItemCreator(
            $this->repository(),
        ));
    }

    /** @test */
    public function it_should_create_an_item(): void
    {
        $command = CreateItemCommandMother::create();

        $expectedItem = ItemMother::create(
            ItemIdMother::create($command->itemId()),
            ItemNameMother::create($command->itemName()),
            ItemPriceMother::create($command->itemPrice()),
            ItemStatusMother::available(),
            ItemStockMother::create($command->stock())
        );

        $this->shouldSave($expectedItem);

        $this->dispatch($command, $this->handler);

    }
}
