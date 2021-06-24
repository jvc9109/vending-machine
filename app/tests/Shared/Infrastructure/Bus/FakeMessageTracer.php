<?php
declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Bus;

use VendingMachine\Shared\Domain\Bus\MessageTracer;
use Throwable;

final class FakeMessageTracer implements MessageTracer
{

    public function start(string $queue): void
    {
    }

    public function recordSpan(string $name, string $body, string $type, string $subtype): void
    {
    }

    public function stopSpan(string $name): void
    {
    }

    public function end(string $status): void
    {
    }

    public function registerError(Throwable $error): void
    {

    }
}
