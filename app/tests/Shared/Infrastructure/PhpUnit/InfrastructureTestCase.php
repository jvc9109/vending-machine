<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\PhpUnit;

use VendingMachine\Tests\Shared\Domain\TestUtils;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Throwable;

abstract class InfrastructureTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        $_SERVER['KERNEL_CLASS'] = $this->kernelClass();
        $_SERVER['APP_ENV'] = 'test';
        self::bootKernel(['environment' => 'test']);

        parent::setUp();
    }

    abstract protected function kernelClass(): string;

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function parameter($parameter)
    {
        return self::$container->getParameter($parameter);
    }

    protected function clearUnitOfWork(): void
    {
        $this->service(EntityManager::class)->clear();
    }

    protected function service(string $id)
    {
        return self::$container->get($id);
    }

    protected function eventually(callable $fn, $totalRetries = 3, $timeToWaitOnErrorInSeconds = 1, $attempt = 0): void
    {
        try {
            $fn();
        } catch (Throwable $error) {
            if ($totalRetries === $attempt) {
                throw $error;
            }

            sleep($timeToWaitOnErrorInSeconds);

            $this->eventually($fn, $totalRetries, $timeToWaitOnErrorInSeconds, $attempt + 1);
        }
    }
}
