<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use VendingMachine\Apps\Optimizer\Backend\OptimizerBackendKernel;
use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;
use VendingMachine\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use VendingMachine\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use VendingMachine\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use VendingMachine\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConnection;
use VendingMachine\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;
use VendingMachine\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqEventBus;
use VendingMachine\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use VendingMachine\Tests\Optimizer\Template\Domain\TemplateCreatedDomainEventMother;
use VendingMachine\Tests\Shared\Infrastructure\Bus\FakeMessageTracer;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use RuntimeException;
use Throwable;

final class RabbitMqEventBusTest extends InfrastructureTestCase
{
    private $connection;
    private $exchangeName;
    private $configurer;
    private $publisher;
    private $consumer;
    private $fakeSubscriber;
    private $consumerHasBeenExecuted;
    private $fakeMessageTracer;

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_rabbitmq(): void
    {
        $domainEvent = TemplateCreatedDomainEventMother::random();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        self::assertTrue($this->consumerHasBeenExecuted);
    }

    private function assertConsumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);

            $this->consumerHasBeenExecuted = true;
        };
    }

    /** @test */
    // TODO : MAKE THIS TEST WORK
    /*public function it_should_throw_an_exception_consuming_non_existing_domain_events(): void
    {
        $this->expectException(RuntimeException::class);

        $domainEvent = FakeDomainEvent::random();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        self::assertTrue($this->consumerHasBeenExecuted);
    }*/

    /** @test */
    public function it_should_retry_failed_domain_events(): void
    {
        $domainEvent = TemplateCreatedDomainEventMother::random();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->simulateErrorConsuming();

        sleep(1);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        self::assertTrue($this->consumerHasBeenExecuted);
    }

    private function simulateErrorConsuming(): void
    {
        try {
            $this->consumer->consume(
                $this->failingConsumer(),
                RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
            );
        } catch (Throwable $error) {
            self::assertInstanceOf(RuntimeException::class, $error);
        }
    }

    private function failingConsumer(): callable
    {
        return static function (DomainEvent $domainEvent): void {
            throw new RuntimeException('To test');
        };
    }

    /** @test */
    public function it_should_send_events_to_dead_letter_after_retry_failed_domain_events(): void
    {
        $domainEvent = TemplateCreatedDomainEventMother::random();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->simulateErrorConsuming();

        sleep(1);

        $this->simulateErrorConsuming();

        $this->assertDeadLetterContainsEvent(1);
    }

    private function assertDeadLetterContainsEvent(int $expectedNumberOfEvents): void
    {
        $totalEventsInDeadLetter = 0;

        while ($this->connection->queue(RabbitMqQueueNameFormatter::formatDeadLetter($this->fakeSubscriber))->get(
            AMQP_AUTOACK
        )) {
            $totalEventsInDeadLetter++;
        }

        self::assertSame($expectedNumberOfEvents, $totalEventsInDeadLetter);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection        = $this->service(RabbitMqConnection::class);
        $this->fakeMessageTracer = new FakeMessageTracer();

        $this->exchangeName            = 'test_domain_events';
        $this->configurer              = new RabbitMqConfigurer($this->connection, 1000);
        $this->publisher               = new RabbitMqEventBus(
            $this->connection,
            $this->exchangeName,
            $this->fakeMessageTracer,
            $this->service(MySqlDoctrineEventBus::class)
        );
        $this->consumer                = new RabbitMqDomainEventsConsumer(
            $this->connection,
            $this->service(DomainEventJsonDeserializer::class),
            $this->fakeMessageTracer,
            $this->exchangeName,
            $maxRetries = 1
        );
        $this->fakeSubscriber          = new TestAllWorksOnRabbitMqEventsPublished();
        $this->consumerHasBeenExecuted = false;

        $this->cleanEnvironment($this->connection);
    }

    private function cleanEnvironment(RabbitMqConnection $connection): void
    {
        $connection->queue(RabbitMqQueueNameFormatter::format($this->fakeSubscriber))->delete();
        $connection->queue(RabbitMqQueueNameFormatter::formatRetry($this->fakeSubscriber))->delete();
        $connection->queue(RabbitMqQueueNameFormatter::formatDeadLetter($this->fakeSubscriber))->delete();
    }

    protected function kernelClass(): string
    {
        return OptimizerBackendKernel::class;
    }
}
