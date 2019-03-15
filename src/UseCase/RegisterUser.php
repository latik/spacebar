<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class RegisterUser
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(
      UserRepository $userRepository,
      UserPasswordEncoderInterface $encoder
    ) {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function __invoke($userDto)
    {
        $user = User::create($userDto->email, $userDto->password, $this->encoder);

        $this->userRepository->store($user);

        return $user;
    }
}