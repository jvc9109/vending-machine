<?php


namespace VendingMachine\Machine\Items\Application\Obtain;


use VendingMachine\Shared\Domain\Bus\Query\QueryHandler;

final class ObtainItemQueryHandler implements QueryHandler
{


    public function __construct(
        private ItemObtainer $obtainer
    )
    {
    }

    public function __invoke(ObtainItemQuery $query): ItemResponse
    {
        $item = $this->obtainer->__invoke($query->itemName());

        return ItemResponseConverter::fromItem($item);
    }


}
