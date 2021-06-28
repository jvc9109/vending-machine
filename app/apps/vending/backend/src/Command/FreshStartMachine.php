<?php


namespace VendingMachine\Apps\Vending\Backend\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VendingMachine\Machine\CoinsCounter\Application\InitNewCounter\InitNewCounterCommand;
use VendingMachine\Machine\Items\Application\Create\CreateItemCommand;
use VendingMachine\Shared\Domain\Bus\Command\CommandBus;
use VendingMachine\Shared\Domain\UuidGenerator;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;

final class FreshStartMachine extends Command
{
    private const WATER_PRICE = 0.65;
    private const JUICE_PRICE = 1.00;
    private const SODA_PRICE  = 1.50;

    private const ITEM_UNITS = 1000;

    public function __construct(
        private CommandBus $commandBus,
        private UuidGenerator $generator,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('vending:machine:setup')
            ->setDescription('Fresh start of the machine. It would only work once. It would set 3 kinds of drinks:
            Water: 0.65 price, 1000 units. Juice: 1.00 price, 1000 units. Soda: 1.50 price, 1000 units. And start the counters for coins');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(
            new CreateItemCommand($this->generator->generate(), 'water', self::WATER_PRICE, self::ITEM_UNITS)
        );

        $this->commandBus->dispatch(
            new CreateItemCommand($this->generator->generate(), 'juice', self::JUICE_PRICE, self::ITEM_UNITS)
        );

        $this->commandBus->dispatch(
            new CreateItemCommand($this->generator->generate(), 'soda', self::SODA_PRICE, self::ITEM_UNITS)
        );

        foreach (CoinValueObject::VALID_COINS as $coin) {
            $this->commandBus->dispatch(
                new InitNewCounterCommand($this->generator->generate(), $coin)
            );
        }

        return Command::SUCCESS;
    }
}
