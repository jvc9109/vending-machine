<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus\Command;

use VendingMachine\Shared\Domain\Bus\Command\Command;
use VendingMachine\Shared\Infrastructure\Bus\Command\CommandNotRegisteredError;
use VendingMachine\Shared\Infrastructure\Bus\Command\InMemory\InMemorySymfonyCommandBus;
use VendingMachine\Tests\Shared\Infrastructure\Bus\FakeMiddlewareHandler;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;
use RuntimeException;

final class InMemorySymfonyCommandBusTest extends UnitTestCase
{
    private ?InMemorySymfonyCommandBus $commandBus;

    /** @test */
    public function it_should_be_able_to_handle_a_command(): void
    {
        $this->expectException(RuntimeException::class);

        $this->commandBus->dispatch(new FakeCommand());
    }

    /** @test */
    public function it_should_raise_an_exception_dispatching_a_non_registered_command(): void
    {
        $this->expectException(CommandNotRegisteredError::class);

        $this->commandBus->dispatch($this->command());
    }

    /** @return Command| MockInterface */
    private function command()
    {
        return $this->mock(Command::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = new InMemorySymfonyCommandBus([$this->commandHandler()], new FakeMiddlewareHandler());
    }

    private function commandHandler(): object
    {
        return new class {
            public function __invoke(FakeCommand $command)
            {
                throw new RuntimeException('This works fine!');
            }
        };
    }
}
