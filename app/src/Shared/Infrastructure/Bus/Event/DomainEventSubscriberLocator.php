<?php


namespace VendingMachine\Shared\Infrastructure\Bus\Event;


use Traversable;
use VendingMachine\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;

final class DomainEventSubscriberLocator
{
    private array $mapping;

    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);

        return $formatted[$eventClass];
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
