<?php

declare(strict_types=1);

namespace App\Backoffice\Application\CommandHandler;

use App\Backoffice\Application\Command\RegisterUserCommand;
use App\Backoffice\Domain\User\EmailAddress;
use App\Backoffice\Domain\User\Password;
use App\Backoffice\Domain\User\User;
use App\Backoffice\Domain\User\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RegisterUser implements MessageHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterUserCommand $command): User
    {
        $password = Password::fromString($command->password);
        $email = EmailAddress::fromString($command->email);

        $user = User::create($email, $password);

        $this->userRepository->store($user);

        return $user;
    }
}