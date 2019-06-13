<?php declare(strict_types=1);

namespace App\Backoffice\Domain\User;

use App\Backoffice\Domain\QueryObjectInterface;
use Doctrine\Common\Collections\Collection;

interface UserFinder
{
    public function execute(QueryObjectInterface $queryObject): Collection;
}
