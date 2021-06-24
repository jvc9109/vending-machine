<?php
declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus;

use InvalidArgumentException;
use PcComponentes\ElasticAPM\Symfony\Component\Messenger\NameExtractor;

final class ApmNameExtractor implements NameExtractor
{
    public function execute($message): string
    {
        if (false === is_string($message::class)) {
            throw new InvalidArgumentException('The parameter must be of type string');
        }

        return $message::class;
    }
}
