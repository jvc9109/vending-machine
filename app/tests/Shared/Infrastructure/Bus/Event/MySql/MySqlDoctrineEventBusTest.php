<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus\Event\MySql;

use VendingMachine\Apps\Optimizer\Backend\OptimizerBackendKernel;
use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;
use VendingMachine\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use VendingMachine\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineDomainEventsConsumer;
use VendingMachine\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use VendingMachine\Tests\Optimizer\Template\Domain\TemplateCreatedDomainEventMother;
use VendingMachine\Tests\Optimizer\TemplateObject\Domain\TemplateObjectCreatedDomainEventMother;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

final class MySqlDoctrineEventBusTest extends InfrastructureTestCase
{
    private ?MySqlDoctrineEventBus $bus;
    private ?MySqlDoctrineDomainEventsConsumer $consumer;

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_mysql(): void
    {
        $domainEvent        = TemplateObjectCreatedDomainEventMother::create();
        $anotherDomainEvent = TemplateCreatedDomainEventMother::random();

        $this->bus->publish($domainEvent, $anotherDomainEvent);

        $this->consumer->consume(
            fn(DomainEvent ...$expectedEvents) => $this->assertContainsEquals($domainEvent, $expectedEvents),
            $eventsToConsume = 2
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus      = new MySqlDoctrineEventBus($this->service(EntityManager::class));
        $this->consumer = new MySqlDoctrineDomainEventsConsumer(
            $this->service(EntityManager::class),
            $this->service(DomainEventMapping::class)
        );
    }

    protected function kernelClass(): string
    {
        return OptimizerBackendKernel::class;
    }
}
