<?php


namespace VendingMachine\Apps\Vending\Backend\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use VendingMachine\Machine\CoinsCounter\Application\FindByValue\FindCoinsCounterByValueQuery;
use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponse;
use VendingMachine\Machine\CoinsCounter\Application\RefillCoins\RefillCoinsCommand;
use VendingMachine\Machine\Items\Application\Obtain\ItemResponse;
use VendingMachine\Machine\Items\Application\Obtain\ObtainItemQuery;
use VendingMachine\Machine\Items\Application\Purchase\PurchaseItemCommand;
use VendingMachine\Machine\Items\Application\UpdateStock\UpdateStockCommand;
use VendingMachine\Machine\User\Application\AddCoin\AddCoinCommand;
use VendingMachine\Machine\User\Application\Find\FindUserQuery;
use VendingMachine\Machine\User\Application\Find\UserResponse;
use VendingMachine\Machine\User\Application\InitSession\InitSessionCommand;
use VendingMachine\Machine\User\Application\ReturnCoins\ReturnCoinsCommand;
use VendingMachine\Shared\Domain\Bus\Command\CommandBus;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\DomainError;
use VendingMachine\Shared\Domain\UuidGenerator;
use function Lambdish\Phunctional\map;

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
            ->setDescription('Start to use the vending machine. IncreaseStock the set of commands for the machine.');
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
                preg_match('/^SERVICE$/i', $action) === 1 => $this->enterServiceMode($input, $output, $helper),
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
        } catch (DomainError $e) {
            return $this->writeErrorMessages($e);
        }

        return ['Accepted!'];
    }

    private function writeErrorMessages(\Throwable $e): array
    {
        return ['Oops something went Wrong', $e->getMessage(), 'Try again!'];
    }

    private function obtainItem(string $action, string $userId): array
    {
        [$actionName, $itemName] = explode('-', $action);
        try {
            /** @var ItemResponse $item */
            $item = $this->queryBus->ask(new ObtainItemQuery(strtolower($itemName)));
            // Synchronous side effects of purchase: Add user coins to counters, calculate change and
            // reduce change coins from counters.
            $this->commandBus->dispatch(new PurchaseItemCommand($item->id(), $userId));

            /** @var UserResponse $userUpdated */
            $userUpdated = $this->queryBus->ask(new FindUserQuery($userId));
            $this->commandBus->dispatch(new ReturnCoinsCommand($userUpdated->id()));

            return [sprintf('%s, %s', strtoupper($item->name()), implode(',', $userUpdated->coins()))];
        } catch (DomainError $e) {
            return $this->writeErrorMessages($e);
        }

    }

    private function enterServiceMode(InputInterface $input, OutputInterface $output, HelperInterface $helper): array
    {
        $output->writeln('<info>Welcome to the Service MODE. You Can refill coins, reset coins or refill items Stock</info>');
        $exit = false;

        do {
            $action = $helper->ask($input, $output, new Question(''));
            $result = match (true) {
                0 === stripos($action, "SET-COINS") => $this->refillCoinsCounter($action),
                0 === stripos($action, "SET-") => $this->setItemStock($action),
                self::EXIT === $action => $exit = true,
                default => null
            };

            $output->writeln($result);

        } while (!$exit);

        return ['Service Mode Finished'];
    }

    private function returnUserCoins(string $userId): array
    {
        try {
            /** @var UserResponse $user */
            $user = $this->queryBus->ask(new FindUserQuery($userId));
            $this->commandBus->dispatch(new ReturnCoinsCommand($user->id()));
            return $user->coins();

        } catch (DomainError $e) {
            return $this->writeErrorMessages($e);
        }

    }

    private function refillCoinsCounter($action): array
    {
        try {
            [$commandSet, $coin, $quantity] = map(fn(string $item) => trim($item), explode(',', $action));
            /** @var CoinsCounterResponse $counter */
            $counter = $this->queryBus->ask(new FindCoinsCounterByValueQuery((float)$coin));
            $this->commandBus->dispatch(new RefillCoinsCommand($counter->id(), (int)$quantity));

        } catch (\Throwable $e) {
            return ['oops Something went bad, check your command'];
        }

        return [sprintf('Coins of value %s refilled with %s units', $counter->coinValue(), $quantity)];

    }

    private function setItemStock($action): array
    {
        try {
            [$commandSet, $quantity] = map(fn(string $item) => trim($item), explode(',', $action));
            [$set, $itemName] = explode('-', $commandSet);
            /** @var ItemResponse $item */
            $item = $this->queryBus->ask(new ObtainItemQuery(strtolower($itemName)));

            $this->commandBus->dispatch(new UpdateStockCommand($item->id(), (int)$quantity));

        } catch (\Throwable $e) {
            return ['oops Something went bad, check your command'];
        }

        return [sprintf('Item %s has been restocked to %s', $item->name(), $quantity)];

    }

}
