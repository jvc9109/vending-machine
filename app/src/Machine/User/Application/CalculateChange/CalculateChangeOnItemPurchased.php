<?php


namespace VendingMachine\Machine\User\Application\CalculateChange;


use VendingMachine\Machine\Items\Domain\ItemPurchasedDomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CalculateChangeOnItemPurchased implements DomainEventSubscriber
{

    public static function subscribedTo(): array
    {
        return [ItemPurchasedDomainEvent::class];
    }

    public function __invoke(ItemPurchasedDomainEvent $event): void
    {
        $itemId = $event->aggregateId();
        $itemPrice = $event->itemPrice();
    }


}
