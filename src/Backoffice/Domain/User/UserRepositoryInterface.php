<?php

namespace App\Backoffice\Domain\User;

interface UserRepositoryInterface
{
    public function store(User $user);

    public function remove($user);
}