<?php


namespace VendingMachine\Tests\Machine\User\Application\CalculateChange;


use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCountersResponse;
use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\GetAllCountersQuery;
use VendingMachine\Machine\User\Application\CalculateChange\CalculateChangeOnItemPurchased;
use VendingMachine\Machine\User\Application\CalculateChange\ChangeCalculator;
use VendingMachine\Tests\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponseMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterCoinValueMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterIdMother;
use VendingMachine\Tests\Machine\CoinsCounter\Domain\CoinsCounterTotalCoinsMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPriceMother;
use VendingMachine\Tests\Machine\Item\Domain\ItemPurchasedDomainEventMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinDigestedDomainEventMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinGivenDomainEventMother;
use VendingMachine\Tests\Machine\User\Domain\UserCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;
use VendingMachine\Tests\Machine\User\Domain\UserMother;
use VendingMachine\Tests\Machine\User\Domain\UserTypeMother;
use VendingMachine\Tests\Machine\User\UserModuleUnitTestCase;

final class CalculateChangeOnItemPurchasedTest extends UserModuleUnitTestCase
{
    private CalculateChangeOnItemPurchased $subscriber;

    /** @test */
    public function it_should_return_change(): void
    {
        $coinUserInserted = 0.25;
        $itemPurchasedEvent = ItemPurchasedDomainEventMother::create(
            price: ItemPriceMother::create(0.6)
        );

        $user = UserMother::create(
            UserIdMother::create($itemPurchasedEvent->userId()),
            UserCoinsMother::create([$coinUserInserted, $coinUserInserted, $coinUserInserted]),
            UserTypeMother::createUser()
        );

        $userExpected = UserMother::create(
            $user->id(),
            UserCoinsMother::create([0.10, 0.05]),
            $user->type()
        );

        $coinsCounterTen = CoinsCounterResponseMother::create(
            coinValue: CoinsCounterCoinValueMother::create(0.10),
            totalCoins: CoinsCounterTotalCoinsMother::create(100)
        );

        $coinsCounterFive = CoinsCounterResponseMother::create(
            coinValue: CoinsCounterCoinValueMother::create(0.05),
            totalCoins: CoinsCounterTotalCoinsMother::create(100)
        );

        $this->shouldAskQuery(
            new GetAllCountersQuery(),
            new CoinsCountersResponse([$coinsCounterTen, $coinsCounterFive])
        );

        $this->shouldSearch($user->id(), $user);

        $this->shouldSave($userExpected);


        $domainEvents = [
            UserCoinDigestedDomainEventMother::create(
                $user->id(),
                $coinUserInserted
            ),
            UserCoinDigestedDomainEventMother::create(
                $user->id(),
                $coinUserInserted
            ),
            UserCoinDigestedDomainEventMother::create(
                $user->id(),
                $coinUserInserted
            ),
            UserCoinGivenDomainEventMother::create(
                $user->id(),
                CoinsCounterIdMother::create($coinsCounterTen->id())
            ),
            UserCoinGivenDomainEventMother::create(
                $user->id(),
                CoinsCounterIdMother::create($coinsCounterFive->id())
            )
        ];

        $this->shouldPublishDomainEvents(
            ...$domainEvents
        );

        $this->notify($itemPurchasedEvent, $this->subscriber);
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriber = new CalculateChangeOnItemPurchased(
            new ChangeCalculator($this->repository(), $this->queryBus(), $this->eventBus())
        );
    }

}
