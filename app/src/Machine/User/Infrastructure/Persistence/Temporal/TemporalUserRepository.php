<?php


namespace VendingMachine\Machine\User\Infrastructure\Persistence\Temporal;


use DateTimeImmutable;
use VendingMachine\Machine\User\Domain\User;
use VendingMachine\Machine\User\Domain\UserCoins;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserRepository;
use VendingMachine\Machine\User\Domain\UserType;

final class TemporalUserRepository implements UserRepository
{

    public function save(User $user): void
    {
        file_put_contents($this->fileName($user->id()->value()), serialize($user));
    }

    public function search(UserId $id): ?User
    {
        return file_exists($this->fileName($id->value()))
            ? unserialize(file_get_contents($this->fileName($id->value())), [
                'allowed_classes' => [
                    User::class,
                    UserId::class,
                    UserCoins::class,
                    UserType::class,
                    DateTimeImmutable::class
                ]
            ])
            : null;
    }

    private function fileName(string $id): string
    {
        return sprintf('%s/%s.repo', sys_get_temp_dir(), $id);
    }
}
