<?php declare(strict_types=1);

namespace App\Backoffice\Domain;

use App\Backoffice\Application\Query\Criteria;
use App\Backoffice\Application\Query\Order;

interface QueryObjectInterface
{
    public function addCriteria(Criteria $criteria);

    public function addOrder(Order $order);

    public function setLimitAndOffset(int $limit, int $offset);
}