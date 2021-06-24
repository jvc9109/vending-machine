<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Command\InMemory;

use VendingMachine\Shared\Domain\Bus\Command\Command;
use VendingMachine\Shared\Domain\Bus\Command\CommandBus;
use VendingMachine\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use VendingMachine\Shared\Infrastructure\Bus\Command\CommandNotRegisteredError;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

final class InMemorySymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers, ?MiddlewareInterface $middlewareHandler)
    {
        $this->bus = new MessageBus(
            [
                $middlewareHandler,
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($commandHandlers))
                ),
            ]
        );
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredError($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
