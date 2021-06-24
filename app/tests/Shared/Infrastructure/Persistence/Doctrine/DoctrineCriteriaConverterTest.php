<?php

declare(strict_types=1);

namespace VendingMachine\Tests\Shared\Infrastructure\Persistence\Doctrine;


use VendingMachine\Apps\Optimizer\Backend\OptimizerBackendKernel;
use VendingMachine\Optimizer\Feed\Domain\Feed;
use VendingMachine\Shared\Domain\Criteria\AndFilter;
use VendingMachine\Shared\Domain\Criteria\Filters;
use VendingMachine\Shared\Domain\Criteria\OrFilter;
use VendingMachine\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use VendingMachine\Tests\Shared\Domain\Criteria\CriteriaMother;
use VendingMachine\Tests\Shared\Domain\Criteria\FilterMother;
use VendingMachine\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

final class DoctrineCriteriaConverterTest extends InfrastructureTestCase
{
    private EntityManager|null $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->service(EntityManager::class);
    }
    /** @test */
    public function it_should_convert_criteria_to_query(): void
    {
        $dql = 'SELECT f FROM VendingMachine\Optimizer\Feed\Domain\Feed f WHERE f.maiores <> :maiores AND (f.ab < :ab OR (f.quasi = :quasi AND f.aut LIKE :aut))';
        $filter1 = FilterMother::fromValues([
            'field' => 'maiores',
            'operator' => '!=',
            'value' => 'maiores'
        ]);
        $filter2 = FilterMother::fromValues([
            'field' => 'ab',
            'operator' => '<',
            'value' => '5'
        ]);
        $filter3 = FilterMother::fromValues([
            'field' => 'quasi',
            'operator' => '=',
            'value' => '4'
        ]);
        $filter4 = FilterMother::fromValues([
            'field' => 'aut',
            'operator' => 'CONTAINS',
            'value' => 'aut'
        ]);

        $filters = new Filters(
            [
                $filter1,
                new OrFilter(
                    $filter2,
                    new AndFilter(
                        $filter3,
                        $filter4
                    )
                )
            ]
        );

        $criteria = CriteriaMother::create($filters);
        $conversion = DoctrineCriteriaConverter::convert($criteria);
        $qb = $this->entityManager->getRepository(Feed::class)->createQueryBuilder('f')->addCriteria($conversion)->getQuery();

        self::assertEquals($dql, $qb->getDQL());
    }

    protected function kernelClass(): string
    {
        return OptimizerBackendKernel::class;
    }
}
