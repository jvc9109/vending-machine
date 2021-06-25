<?php


namespace VendingMachine\Tests\Machine\User\Application\AddCoin;


use VendingMachine\Machine\User\Application\AddCoin\AddCoinCommandHandler;
use VendingMachine\Machine\User\Application\AddCoin\CoinIncreaser;
use VendingMachine\Machine\User\Domain\UserCoins;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use VendingMachine\Tests\Machine\User\Domain\UserCoinsMother;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;
use VendingMachine\Tests\Machine\User\Domain\UserMother;
use VendingMachine\Tests\Machine\User\Domain\UserTypeMother;
use VendingMachine\Tests\Machine\User\UserModuleUnitTestCase;

final class AddCoinCommandHandlerTest extends UserModuleUnitTestCase
{

    private AddCoinCommandHandler $handler;

    /** @test */
    public function it_should_init_a_new_session(): void
    {
        $command = AddCoinCommandMother::create();
        $user    = UserMother::create(
            UserIdMother::create($command->userId()),
            UserCoinsMother::createWithCoins(),
            UserTypeMother::createUser()
        );

        $this->shouldSearch($user->id(), $user);

        $resultCoins = $user->coins()->items();
        $resultCoins[] = new CoinValueObject($command->value());

        $expectedUser = UserMother::create(
            $user->id(),
            new UserCoins($resultCoins),
            $user->type()
        );

        $this->shouldSave($expectedUser);

        $this->dispatch($command, $this->handler);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new AddCoinCommandHandler(new CoinIncreaser($this->repository()));
    }
}
