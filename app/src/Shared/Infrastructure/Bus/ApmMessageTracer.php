<?php
declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus;

use VendingMachine\Shared\Domain\Bus\MessageTracer;
use Throwable;
use ZoiloMora\ElasticAPM\ElasticApmTracer;
use ZoiloMora\ElasticAPM\Events\Common\Message;
use ZoiloMora\ElasticAPM\Events\Common\Message\Queue;
use ZoiloMora\ElasticAPM\Events\Span\Context;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

final class ApmMessageTracer implements MessageTracer
{
    private const SPAN_ACTION     = 'message';
    private const STACKTRACE_SKIP = 2;
    private const MAX_SPANS       = 25;

    public function __construct(
        private ElasticApmTracer $elasticApmTracer,
        private ?Transaction $transaction,
        private array $spans = [],
        private int $spanCounter = 0,
    )
    {
    }

    public function start(string $queue): void
    {
        if (false === $this->elasticApmTracer->active()) {
            return;
        }

        $this->transaction = $this->elasticApmTracer->startTransaction(
            $queue,
            'message',
        );
    }

    public function recordSpan(string $name, string $body, string $type, string $subtype): void
    {
        if ($this->spanCounter >= self::MAX_SPANS) {
            return;
        }
        try {
            $this->spans[$name] = $this->elasticApmTracer->startSpan(
                $name,
                $type,
                $subtype,
                self::SPAN_ACTION,
                $this->getContext($name, $body),
                self::STACKTRACE_SKIP,
            );
            $this->spanCounter++;
        } catch (Throwable) {
        }
    }

    private function getContext(string $queue, string $body): Context
    {
        return Context::fromMessage(
            new Message(
                new Queue($queue),
                null,
                $body
            )
        );
    }

    public function stopSpan(string $name): void
    {
        if (isset($this->spans[$name])) {
            $this->spans[$name]->stop();
            unset($this->spans[$name]);
        }
    }

    public function end(string $status): void
    {
        if ($this->transaction !== null) {
            $this->transaction->stop($status);
            $this->transaction = null;
        }
        $this->elasticApmTracer->flush();
    }

    public function registerError(Throwable $error): void
    {
        if (false === $this->elasticApmTracer->active()) {
            return;
        }

        $this->elasticApmTracer->captureException(
            $error,
        );
    }
}
