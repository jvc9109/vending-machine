<?php


namespace VendingMachine\Machine\CoinsCounter\Application\RemoveCoinFromCounter;


use VendingMachine\Machine\User\Domain\UserCoinGivenDomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class RemoveCoinFromCounterOnUserCoinGiven implements DomainEventSubscriber
{
    public function __construct(private CoinFromCounterRemover $remover)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserCoinGivenDomainEvent::class];
    }

    public function __invoke(UserCoinGivenDomainEvent $event): void
    {
        $this->remover->__invoke($event->coinCounterId());
    }


}
