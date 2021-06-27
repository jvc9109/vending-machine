<?php


namespace VendingMachine\Tests\Machine\User\Application\CalculateChange;


use VendingMachine\Machine\User\Application\CalculateChange\CalculateChangeOnItemPurchased;
use VendingMachine\Machine\User\Application\CalculateChange\ChangeCalculator;
use VendingMachine\Tests\Machine\Item\Domain\ItemPriceMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPurchasedDomainEventMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinDigestedDomainEventMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;
use VendingMachine\Tests\Machine\User\Domain\UserMother;
use VendingMachine\Tests\Machine\User\Domain\UserTypeMother;
use VendingMachine\Tests\Machine\User\UserModuleUnitTestCase;

final class CalculateChangeOnItemPurchasedTest extends UserModuleUnitTestCase
{
    private CalculateChangeOnItemPurchased $subscriber;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriber = new CalculateChangeOnItemPurchased(
            new ChangeCalculator($this->repository(), $this->queryBus(), $this->eventBus())
        );
    }

    /** @test */
    public function it_should_not_return_change(): void
    {
        $itemPurchasedEvent = ItemPurchasedDomainEventMother::create(
            price: ItemPriceMother::create(0.25)
        );

        $user = UserMother::create(
            UserIdMother::create($itemPurchasedEvent->userId()),
            UserCoinsMother::create([$itemPurchasedEvent->itemPrice()]),
            UserTypeMother::createUser()
        );

        $userExpected = UserMother::create(
            $user->id(),
            UserCoinsMother::empty(),
            $user->type()
        );

        $this->shouldSearch($user->id(), $user);

        $this->shouldSave($userExpected);

        $this->shouldPublishDomainEvent(
            UserCoinDigestedDomainEventMother::create(
                $user->id(),
                $itemPurchasedEvent->itemPrice()
            )
        );

        $this->notify($itemPurchasedEvent, $this->subscriber);
    }

}
