<?php declare(strict_types=1);

namespace App\Contract;

use App\Query\QueryObject;
use Doctrine\Common\Collections\Collection;

interface UserFinder
{
    public function execute(QueryObject $queryObject): Collection;
}
