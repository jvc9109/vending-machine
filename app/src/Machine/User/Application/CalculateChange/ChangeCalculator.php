<?php


namespace VendingMachine\Machine\User\Application\CalculateChange;


use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponse;
use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCountersResponse;
use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\GetAllCountersQuery;
use VendingMachine\Machine\User\Domain\UserFinder;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserRepository;
use VendingMachine\Shared\Domain\Bus\Event\EventBus;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use function Lambdish\Phunctional\repeat;

final class ChangeCalculator
{
    private UserFinder $finder;

    public function __construct(
        private UserRepository $repository,
        private QueryBus $queryBus,
        private EventBus $eventBus
    )
    {
        $this->finder = new UserFinder($this->repository);
    }

    public function __invoke(string $userId, float $itemPrice): void
    {
        $user = $this->finder->__invoke(new UserId($userId));

        $totalMoney = array_sum($user->coins()->toPrimitives());

        $totalChange = (int)($totalMoney - $itemPrice) * 1000;
        $change      = [];

        foreach (CoinValueObject::VALID_COINS as $coin) {
            $numberOfCoins         = (int)$totalChange / ((int)$coin * 1000);
            $change[(string)$coin] = $numberOfCoins;
            $totalChange           = $totalChange - (int)$numberOfCoins * $coin * 1000;

            if ($totalChange <= 0) {
                break;
            }
        }

        $user->digestCoins();

        if (!count($change) === 0) {
            /** @var CoinsCountersResponse $availableCoins */
            $availableCoins = $this->queryBus->ask(
                new GetAllCountersQuery()
            );

            /** @var CoinsCounterResponse $availableCoin */
            foreach ($availableCoins as $availableCoin) {
                repeat(function () use ($user, $availableCoin){
                    $user->recordChangeCoin($availableCoin);
                    },
                    $change[(string)$availableCoin->coinValue()]
                );
            }
        }

        $this->repository->save($user);
        $this->eventBus->publish(...$user->pullDomainEvents());
    }


}
