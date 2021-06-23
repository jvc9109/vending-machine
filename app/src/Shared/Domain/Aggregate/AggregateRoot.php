<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Domain\Aggregate;


use DateTimeImmutable;
use VendingMachine\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];
    protected DateTimeImmutable $createdOn;
    protected DateTimeImmutable $updatedOn;

    public function __construct()
    {
        $this->createdOn = new DateTimeImmutable();
        $this->updatedOn = new DateTimeImmutable();
    }

    public function createdOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function updatedOn(): DateTimeImmutable
    {
        return $this->updatedOn;
    }

    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
