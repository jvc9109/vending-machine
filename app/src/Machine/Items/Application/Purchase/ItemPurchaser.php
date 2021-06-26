<?php


namespace VendingMachine\Machine\Items\Application\Purchase;


use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemNotFoundDomainError;
use VendingMachine\Machine\Items\Domain\ItemRepository;
use VendingMachine\Machine\User\Application\Find\FindUserQuery;
use VendingMachine\Machine\User\Application\Find\UserResponse;
use VendingMachine\Shared\Domain\Bus\Event\EventBus;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinsCollection;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use function Lambdish\Phunctional\map;

final class ItemPurchaser
{

    public function __construct(
        private ItemRepository $repository,
        private EventBus $eventBus,
        private QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $itemId,
        string $userId,
    ): void
    {
        /** @var UserResponse $user */
        $user = $this->queryBus->ask(
            new FindUserQuery($userId)
        );

        $item = $this->repository->search(new ItemId($itemId));

        if ($item === null) {
            throw new ItemNotFoundDomainError($itemId);
        }

        $userCoins = new CoinsCollection(
            map(fn(float $coin): CoinValueObject => new CoinValueObject($coin), $user->coins())
        );

        $item->purchaseItem($userCoins);

        $this->repository->save($item);

        $this->eventBus->publish(...$item->pullDomainEvents());
    }

}
