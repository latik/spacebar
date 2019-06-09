<?php declare(strict_types=1);

namespace App\Repository;

use App\Contract\UserFinder;
use App\Query\QueryObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Query\QueryBuilder;

class SqlUserFinder implements UserFinder
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * SqlUserFinder constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param QueryObject $queryObject
     * @return Collection
     * @throws DBALException
     */
    public function execute(QueryObject $queryObject): Collection
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*');
        $queryBuilder->from('user');

        foreach ($queryObject->criteria as $filter) {
            $queryBuilder = $queryBuilder->andWhere(
              sprintf("%s %s '%s'", $filter->fieldName, $filter->operator, $filter->fieldValue)
            );
        }
        foreach ($queryObject->orders as $order) {
            $queryBuilder = $queryBuilder->orderBy($order->fieldName, $order->type);
        }

        if (0 !== $queryObject->offset) {
            $queryBuilder = $queryBuilder->setFirstResult($queryObject->offset);
        }

        if (-1 !== $queryObject->limit) {
            $queryBuilder = $queryBuilder->setMaxResults($queryObject->limit);
        }

        return new ArrayCollection($this->connection->executeQuery($queryBuilder->getSQL())->fetchAll());
    }
}
