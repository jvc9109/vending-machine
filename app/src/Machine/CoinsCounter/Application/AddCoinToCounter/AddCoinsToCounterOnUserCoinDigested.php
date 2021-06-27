<?php


namespace VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter;


use VendingMachine\Machine\User\Domain\UserCoinDigestedDomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class AddCoinsToCounterOnUserCoinDigested implements DomainEventSubscriber
{

    public function __construct(private CoinsCounterIncreaser $counterIncreaser)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserCoinDigestedDomainEvent::class];
    }

    public function __invoke(UserCoinDigestedDomainEvent $event): void
    {
        $this->counterIncreaser->__invoke($event->coinValue());
    }


}
