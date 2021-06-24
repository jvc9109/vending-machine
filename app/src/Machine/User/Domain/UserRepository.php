<?php


namespace VendingMachine\Machine\User\Domain;


interface UserRepository
{

    public function save(User $user): void;

    public function search(UserId $id): ?User;

}
