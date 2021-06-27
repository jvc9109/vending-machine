<?php


namespace VendingMachine\Machine\User\Application\CalculateChange;


use VendingMachine\Machine\User\Domain\UserFinder;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserRepository;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;

final class ChangeCalculator
{
    private UserFinder $finder;

    public function __construct(
        private UserRepository $repository,
        private QueryBus $queryBus
    )
    {
        $this->finder = new UserFinder($this->repository);
    }

    public function __invoke(string $userId, float $itemPrice): void
    {
        $user = $this->finder->__invoke(new UserId($userId));

        $totalMoney = array_sum($user->coins()->toPrimitives());

        $totalChange = (int)($totalMoney - $itemPrice)*1000;
        $change = [];

        foreach (CoinValueObject::VALID_COINS as $coin) {
            $numberOfCoins = (int)$totalChange/((int)$coin*1000);
            $change[(string)$coin] = array_fill(0, $numberOfCoins, $coin);
            $totalChange =  $totalChange - (int)$numberOfCoins*$coin*1000;

            if ($totalChange <= 0) {
                break;
            }
        }


    }


}
