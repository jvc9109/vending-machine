<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Command;

use VendingMachine\Shared\Domain\Bus\Command\Command;
use VendingMachine\Shared\Domain\Utils;
use RuntimeException;

final class CommandJsonDeserializer
{
    public function deserialize(string $command): Command
    {
        $commandData = Utils::jsonDecode($command);
        $commandName = $commandData['data']['type'];

        if (null === $commandName) {
            throw new RuntimeException("The command <$commandName> doesn't exist or has no handler");
        }

        return $commandName::fromPrimitives(
            $commandData['data']['attributes'],
        );
    }
}
