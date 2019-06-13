<?php declare(strict_types=1);

namespace App\Backoffice\Application\Query;

use App\Backoffice\Domain\QueryObjectInterface;

/**
 * @property-read Criteria[] $criteria
 * @property-read Order[] $orders
 * @property-read int $offset
 * @property-read int $limit
 */
final class QueryObject implements QueryObjectInterface
{
    /**
     * @var Criteria[]
     */
    public $criteria = [];

    /**
     * @var Order[]
     */
    public $orders = [];

    /**
     * @var int
     */
    public $offset = 0;

    /**
     * @var int
     */
    public $limit = -1;

    public function addCriteria(Criteria $criteria)
    {
        $this->criteria[] = $criteria;

        return $this;
    }

    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    public function setLimitAndOffset(int $limit, int $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }
}
