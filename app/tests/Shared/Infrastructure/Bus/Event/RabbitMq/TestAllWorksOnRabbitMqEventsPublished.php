<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use VendingMachine\Optimizer\Template\Domain\TemplateCreatedDomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class TestAllWorksOnRabbitMqEventsPublished implements DomainEventSubscriber
{
    public static function subscribedTo(): array
    {
        return [
            TemplateCreatedDomainEvent::class
        ];
    }

    public function __invoke(TemplateCreatedDomainEvent $event)
    {
    }
}
