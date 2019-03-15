<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\RegisterUserCommand;
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

    public function handle(RegisterUserCommand $command)
    {
        $password = Password::fromString($command->password);
        $email = EmailAddress::fromString($command->email);

        $user = User::create($email, $password);

        $this->userRepository->store($user);

        return $user;
    }
}