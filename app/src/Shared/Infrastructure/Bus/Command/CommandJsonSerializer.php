<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Command;

use VendingMachine\Shared\Domain\Bus\Command\AsyncCommand;

final class CommandJsonSerializer
{
    public static function serialize(AsyncCommand $command): string
    {
        return json_encode([
            'data' => [
                'type'       => get_class($command),
                'attributes' => array_merge($command->toPrimitives()),
            ],
            'meta' => [],
        ], JSON_THROW_ON_ERROR);
    }
}
