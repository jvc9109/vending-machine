<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus\Query;

use VendingMachine\Shared\Domain\Bus\Query\Query;
use VendingMachine\Shared\Infrastructure\Bus\Query\InMemory\InMemorySymfonyQueryBus;
use VendingMachine\Shared\Infrastructure\Bus\Query\QueryNotRegisteredError;
use VendingMachine\Tests\Shared\Infrastructure\Bus\FakeMiddlewareHandler;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;
use RuntimeException;

final class InMemorySymfonyQueryBusTest extends UnitTestCase
{
    private ?InMemorySymfonyQueryBus $queryBus;

    /** @test */
    public function it_should_return_a_response_successfully(): void
    {
        $this->expectException(RuntimeException::class);

        $this->queryBus->ask(new FakeQuery());
    }

    /** @test */
    public function it_should_raise_an_exception_dispatching_a_non_registered_query(): void
    {
        $this->expectException(QueryNotRegisteredError::class);

        $this->queryBus->ask($this->query());
    }

    /** @return Query | MockInterface */
    private function query()
    {
        return $this->mock(Query::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = new InMemorySymfonyQueryBus([$this->queryHandler()], new FakeMiddlewareHandler());
    }

    private function queryHandler(): object
    {
        return new class {
            public function __invoke(FakeQuery $query)
            {
                throw new RuntimeException('This works fine!');
            }
        };
    }
}
