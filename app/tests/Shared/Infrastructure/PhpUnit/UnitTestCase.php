<?php
declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\PhpUnit;


use VendingMachine\Shared\Domain\Bus\Command\Command;
use VendingMachine\Shared\Domain\Bus\Command\CommandBus;
use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\EventBus;
use VendingMachine\Shared\Domain\Bus\Query\Query;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\Bus\Query\Response;
use VendingMachine\Shared\Domain\UuidGenerator;
use VendingMachine\Tests\Shared\Domain\TestUtils;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\MatcherAbstract;
use Mockery\MockInterface;
use function Lambdish\Phunctional\map;

abstract class UnitTestCase extends MockeryTestCase
{
    private EventBus|MockInterface|null $eventBus;
    private QueryBus|MockInterface|null $queryBus;
    private CommandBus|MockInterface|null $commandBus;
    private UuidGenerator|MockInterface|null $uuidGenerator;

    protected function shouldPublishDomainEvents(DomainEvent ...$domainEvents): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->with(... map(fn(DomainEvent $domainEvent) => $this->similarTo($domainEvent), $domainEvents))
            ->andReturnNull();
    }

    protected function eventBus(): EventBus|MockInterface
    {
        return $this->eventBus = $this->eventBus ?? $this->mock(EventBus::class);
    }

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function similarTo($value, $delta = 0.0): MatcherAbstract
    {
        return TestUtils::similarTo($value, $delta);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->andReturnNull();
    }

    protected function commandBus(): CommandBus|MockInterface
    {
        return $this->commandBus = $this->commandBus ?? $this->mock(CommandBus::class);
    }

    protected function shouldNotPublishDomainEvent(): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->withNoArgs()
            ->andReturnNull();
    }

    protected function queryBus(): QueryBus|MockInterface
    {
        return $this->queryBus = $this->queryBus ?? $this->mock(QueryBus::class);
    }

    protected function shouldGenerateUuid(string $uuid): void
    {
        $this->uuidGenerator()
            ->shouldReceive('generate')
            ->once()
            ->withNoArgs()
            ->andReturn($uuid);
    }

    protected function uuidGenerator(): UuidGenerator|MockInterface
    {
        return $this->uuidGenerator = $this->uuidGenerator ?? $this->mock(UuidGenerator::class);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }

    protected function dispatch(Command $command, callable $commandHandler): void
    {
        $commandHandler($command);
    }

    protected function assertAskResponse(Response $expected, Query $query, callable $queryHandler): void
    {
        $actual = $queryHandler($query);

        self::assertEquals($expected, $actual);
    }

    protected function assertAskThrowsException(string $expectedErrorClass, Query $query, callable $queryHandler): void
    {
        $this->expectException($expectedErrorClass);

        $queryHandler($query);
    }

    protected function isSimilar($expected, $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function queryBusShouldNotBeenCalled(): void
    {
        $this->queryBus->shouldNotHaveBeenCalled();
    }

    protected function shouldDispatchCommand(Command $command): void
    {
        $this->commandBus()
            ->shouldReceive('dispatch')
            ->with($this->similarTo($command))
            ->andReturnNull();
    }
}
