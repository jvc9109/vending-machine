<?php


namespace VendingMachine\Apps\Vending\Backend\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use VendingMachine\Machine\User\Application\AddCoin\AddCoinCommand;
use VendingMachine\Machine\User\Application\Find\FindUserQuery;
use VendingMachine\Machine\User\Application\Find\UserResponse;
use VendingMachine\Machine\User\Application\InitSession\InitSessionCommand;
use VendingMachine\Machine\User\Application\ReturnCoins\ReturnCoinsCommand;
use VendingMachine\Shared\Domain\Bus\Command\CommandBus;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\UuidGenerator;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinNotAcceptDomainError;

final class UseMachineCommand extends Command
{

    private const EXIT = 'exit';

    public function __construct(
        private CommandBus $commandBus,
        private UuidGenerator $generator,
        private QueryBus $queryBus
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('vending:machine:use')
            ->setDescription('Start to use the vending machine. Add the set of commands for the machine.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = $this->generator->generate();
        $this->commandBus->dispatch(new InitSessionCommand($userId));
        $helper = $this->getHelper('question');
        $output->writeln('<info>Welcome to the Vending Machine. Insert your coins and select your item</info>');
        $exit = false;

        do {
            $action = $helper->ask($input, $output, new Question(''));
            $result = match (true) {
                preg_match('/^\d+.?(\d+)?$/', $action) === 1 => $this->insertCoin((float)$action, $userId),
                preg_match('/^GET-\w+$/i', $action) === 1 => $this->obtainItem($action, $userId),
                preg_match('/^service$/i', $action) === 1 => $this->enterServiceMode($input, $output, $userId),
                preg_match('/^RETURN-COINS$/i', $action) === 1 => $this->returnUserCoins($userId),
                self::EXIT === $action => $exit = true,
                default => null
            };
            if ($exit) {
                $output->writeln('Good bye!');
                $output->writeln($this->returnUserCoins($userId));
                continue;
            }

            if ($result === null) {
                $output->writeln('Sorry I did not understand you');
                continue;
            }

            $output->writeln($result);

        } while (!$exit);

        return Command::SUCCESS;
    }

    private function insertCoin(float $value, string $userId): array
    {
        try {
            $this->commandBus->dispatch(new AddCoinCommand($userId, $value));
        } catch (CoinNotAcceptDomainError $e) {
            return [$e->getMessage()];
        }

        return ['Accepted!'];
    }

    private function obtainItem(string $action, string $userId): array
    {
        [$action, $item] = explode($action, '-');
        return ['Here there is your item'];
    }

    private function enterServiceMode(InputInterface $input, OutputInterface $output, string $userId): array
    {
    }

    private function returnUserCoins(string $userId): array
    {
        /** @var UserResponse $user */
        $user = $this->queryBus->ask(new FindUserQuery($userId));

        $result = $user->coins();

        $this->commandBus->dispatch(new ReturnCoinsCommand($user->id()));

        $result[] = 'All coins returned';

        return $result;

    }

}
