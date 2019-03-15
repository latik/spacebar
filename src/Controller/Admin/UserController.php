<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\DTO\User as UserDTO;
use App\UseCase\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class UserController
{
    /**
     * @Route(methods={"POST"})
     *
     * @param UserDTO      $userDto
     * @param RegisterUser $useCase
     *
     * @return Response
     */
    public function createAction(UserDTO $userDto, RegisterUser $useCase): Response
    {
        $user = $useCase($userDto);

        return new JsonResponse($user);
    }
}