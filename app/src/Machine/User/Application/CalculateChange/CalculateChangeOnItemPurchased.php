<?php


namespace VendingMachine\Machine\User\Application\CalculateChange;


use VendingMachine\Machine\Items\Domain\ItemPurchasedDomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CalculateChangeOnItemPurchased implements DomainEventSubscriber
{

    public function __construct(private ChangeCalculator $calculator)
    {
    }

    public static function subscribedTo(): array
    {
        return [ItemPurchasedDomainEvent::class];
    }

    public function __invoke(ItemPurchasedDomainEvent $event): void
    {
        $itemPrice = $event->itemPrice();
        $userId = $event->userId();

        $this->calculator->__invoke($userId, $itemPrice);
    }


}
