<?php

declare(strict_types=1);

namespace App\Backoffice\Application\QueryHandler;

use App\Backoffice\Domain\User\UserFinder;

final class UserSearch
{
    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @param UserFinder $userFinder
     */
    public function __construct(
        UserFinder $userFinder
    ) {
        $this->userFinder = $userFinder;
    }

    public function __invoke($queryObject)
    {
        return $this->userFinder->execute($queryObject);
    }
}
