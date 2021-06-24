<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Query\InMemory;

use VendingMachine\Shared\Domain\Bus\Query\Query;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\Bus\Query\Response;
use VendingMachine\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use VendingMachine\Shared\Infrastructure\Bus\Query\QueryNotRegisteredError;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class InMemorySymfonyQueryBus implements QueryBus
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers, MiddlewareInterface $middlewareHandler)
    {
        $this->bus = new MessageBus(
            [
                $middlewareHandler,
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($queryHandlers))
                ),
            ]
        );
    }

    public function ask(Query $query): ?Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegisteredError($query);
        }
    }
}
