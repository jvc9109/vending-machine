<?php


namespace VendingMachine\Tests\Machine\User\Application\ReturnCoins;


use VendingMachine\Machine\User\Application\ReturnCoins\CoinsReturner;
use VendingMachine\Machine\User\Application\ReturnCoins\ReturnCoinsCommandHandler;
use VendingMachine\Machine\User\Domain\UserCoins;
use VendingMachine\Tests\Machine\User\Domain\UserCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserMother;
use VendingMachine\Tests\Machine\User\UserModuleUnitTestCase;

final class ReturnCoinsCommandHandlerTest extends UserModuleUnitTestCase
{
    private ReturnCoinsCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new ReturnCoinsCommandHandler(new CoinsReturner($this->repository()));
    }

    /** @test */
    public function it_should_return_all_coins(): void
    {
        $user = UserMother::create(
            coins: UserCoinsMother::createWithCoins()
        );

        $expectedUser = UserMother::create(
            $user->id(),
            UserCoinsMother::empty(),
            $user->type()
        );

        $command = ReturnCoinsCommandMother::create($user->id());

        $this->shouldSearch($user->id(), $user);

        $this->shouldSave($expectedUser);

        $this->dispatch($command, $this->handler);


    }

}
