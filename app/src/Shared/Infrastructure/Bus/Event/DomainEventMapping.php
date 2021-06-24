<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Event;

use VendingMachine\Optimizer\Shared\Domain\OptimizerUtils;
use VendingMachine\Shared\Domain\Bus\Event\DomainEventSubscriber;
use ReflectionClass;
use RuntimeException;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;

final class DomainEventMapping
{
    private $mapping;

    public function __construct(iterable $mapping)
    {
        $this->mapping = reduce($this->eventsExtractor(), $mapping, []);
    }

    private function eventsExtractor(): callable
    {
        return fn(array $mapping, DomainEventSubscriber $subscriber) => array_merge(
            $mapping,
            reindex(
                $this->eventNameExtractor(),
                $subscriber::subscribedTo()
            )
        );
    }

    private function eventNameExtractor(): callable
    {
        return static fn(string $eventClass): string => self::reflectionEventNameExtractor($eventClass);
    }

    public static function reflectionEventNameExtractor(string $eventClass): string
    {
        $rEventClass = new ReflectionClass($eventClass);
        if ($rEventClass->getMethod('eventName')->isAbstract()) {
            $eventName = implode('.', [OptimizerUtils::COMPANY, OptimizerUtils::SERVICE, '*', '*', '*']);
        } else {
            $eventName = $eventClass::eventName();
        }

        return $eventName;
    }

    public function for(string $name)
    {
        if (!isset($this->mapping[$name])) {
            if (!$this->mappedWildcards($name)) {
                throw new RuntimeException("The Domain Event Class for <$name> doesn't exists or have no subscribers");
            }

            return $this->mapping['VendingMachine.optimizer.*.*.*'];
        }

        return $this->mapping[$name];
    }

    private function mappedWildcards(string $name): bool
    {
        return true;
        //$decomposedName = explode('.', $name);
    }

    public function all()
    {
        return $this->mapping;
    }
}
