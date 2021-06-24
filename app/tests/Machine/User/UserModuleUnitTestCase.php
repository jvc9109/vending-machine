<?php


namespace VendingMachine\Tests\Machine\User;


use Mockery\MockInterface;
use VendingMachine\Machine\User\Domain\User;
use VendingMachine\Machine\User\Domain\UserRepository;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class UserModuleUnitTestCase extends UnitTestCase
{
    private UserRepository|MockInterface|null $repository;

    protected function shouldSave(User $user): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($user))
            ->andReturnNull();
    }

    protected function repository(): UserRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(UserRepository::class);
    }
}
