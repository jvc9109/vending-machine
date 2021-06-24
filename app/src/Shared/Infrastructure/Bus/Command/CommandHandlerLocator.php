<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Infrastructure\Bus\Command;

use VendingMachine\Shared\Domain\Bus\Command\AsyncCommandHandler;
use VendingMachine\Shared\Domain\Bus\Command\Command;
use VendingMachine\Shared\Domain\Utils;
use VendingMachine\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use RuntimeException;
use Traversable;

final class CommandHandlerLocator
{
    private array $mapping;

    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function withCommand(Command $command): AsyncCommandHandler
    {
        $formattedLocator = CallableFirstParameterExtractor::forCallables($this->mapping);

        foreach ($formattedLocator as $locatorKey => $locator) {
            if ($locatorKey === get_class($command)) {
                return is_array($locator) ? $locator[0] : $locator;
            }
        }
        throw new RuntimeException('There are no handler for the command: <' . Utils::extractClassName($command::class) . '>');
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
