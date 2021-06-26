<?php


namespace VendingMachine\Tests\Machine\Item\Application\Purchase;


use VendingMachine\Machine\Items\Application\Purchase\ItemPurchaser;
use VendingMachine\Machine\Items\Application\Purchase\PurchaseItemCommandHandler;
use VendingMachine\Machine\Items\Domain\ItemStock;
use VendingMachine\Machine\User\Application\Find\FindUserQuery;
use VendingMachine\Tests\Machine\Item\Domain\ItemIdMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPriceMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPurchasedDomainEventMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStatusMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemStockMother;
use VendingMachine\Tests\Machine\Item\ItemModuleUnitTestCase;
use VendingMachine\Tests\Machine\User\Application\Find\UserResponseMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;

final class PurchaseItemCommandHandlerTest extends ItemModuleUnitTestCase
{
    private PurchaseItemCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new PurchaseItemCommandHandler(new ItemPurchaser(
            $this->repository(),
            $this->eventBus(),
            $this->queryBus()
        ));
    }

    /** @test */
    public function it_should_correctly_purchase_an_item_no_change(): void
    {
        $command = PurchaseItemCommandMother::create();
        $userResponse = UserResponseMother::create(
            id: UserIdMother::create($command->userId()),
            coins: UserCoinsMother::create([0.25, 0.25])
        );

        $item = ItemMother::create(
            id: ItemIdMother::create($command->itemId()),
            price: ItemPriceMother::create(0.50),
            stock: ItemStockMother::create(10)
        );

        $this->shouldAskQuery(new FindUserQuery($userResponse->id()), $userResponse);
        $this->shouldSearch($item->id(), $item);

        $expectedItem = ItemMother::create(
            $item->id(),
            $item->name(),
            $item->price(),
            $item->status(),
            new ItemStock($item->stock()->value()-1)
        );

        $this->shouldSave($expectedItem);

        $this->shouldPublishDomainEvent(
            ItemPurchasedDomainEventMother::create(
                $item->id(), $item->price(), UserIdMother::create($userResponse->id())
            )
        );

        $this->dispatch($command, $this->handler);

    }

}
