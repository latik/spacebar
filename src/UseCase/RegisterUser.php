<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Entity\User;
use App\Repository\UserRepository;
use App\ValueObject\EmailAddress;
use App\ValueObject\Password;

final class RegisterUser
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke($userDto)
    {
        $password = Password::fromString($userDto->password);
        $email = EmailAddress::fromString($userDto->email);

        $user = User::create($email, $password);

        $this->userRepository->store($user);

        return $user;
    }
}