<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Event\InMemory;

use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;
use VendingMachine\Shared\Domain\Bus\Event\EventBus;
use VendingMachine\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class InMemorySymfonyEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers, MiddlewareInterface $middlewareHandler)
    {
        $this->bus = new MessageBus(
            [
                $middlewareHandler,
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forPipedCallables($subscribers)
                    )
                ),
            ]
        );
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException) {
            }
        }
    }
}
