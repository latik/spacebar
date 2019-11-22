<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Command\RegisterUserCommand;
use App\CommandHandler\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
final class UserController
{
    /**
     * @Route(methods={"POST"})
     *
     * @param RegisterUserCommand $command
     * @param RegisterUser        $handler
     *
     * @return Response
     */
    public function createAction(RegisterUserCommand $command, RegisterUser $handler): Response
    {
        $user = $handler->handle($command);

        return new JsonResponse($user);
    }
}
