<?php


namespace VendingMachine\Tests\Machine\User\Application\InitSession;


use VendingMachine\Machine\User\Application\InitSession\InitSessionCommandHandler;
use VendingMachine\Machine\User\Application\InitSession\SessionInitializer;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;
use VendingMachine\Tests\Machine\User\Domain\UserMother;
use VendingMachine\Tests\Machine\User\Domain\UserTypeMother;
use VendingMachine\Tests\Machine\User\UserModuleUnitTestCase;

final class InitSessionCommandHandlerTestModule extends UserModuleUnitTestCase
{
    private InitSessionCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new InitSessionCommandHandler(new SessionInitializer($this->repository()));
    }

    /** @test */
    public function it_should_init_a_new_session(): void
    {
        $command = InitSessionCommandMother::create();
        $user = UserMother::create(
            id: UserIdMother::create($command->userId()),
            type: UserTypeMother::createUser()
        );

        $this->shouldSave($user);

        $this->dispatch($command, $this->handler);
    }
}
