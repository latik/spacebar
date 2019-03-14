<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\DTO\User;
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
     * @param User $user
     *
     * @return Response
     */
    public function createAction(User $user): Response
    {
        return new JsonResponse($user);
    }
}