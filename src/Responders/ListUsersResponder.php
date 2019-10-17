<?php

declare(strict_types=1);

namespace App\Responders;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ListUsersResponder
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * ListUsersResponder constructor.
     *
     * @param RequestStack $requestStack
     * @param Twig         $twig
     */
    public function __construct(RequestStack $requestStack, Twig $twig)
    {
        $this->requestStack = $requestStack;
        $this->twig = $twig;
    }

    /**
     * @param Collection $users
     *
     * @return string|JsonResponse
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function send(Collection $users): Response
    {
        if ($this->wantsJson()) {
            return JsonResponse::create(['users' => $users]);
        }

        return Response::create($this->twig->render('admin/users/index.html.twig', ['users' => $users]));
    }

    /**
     * @return bool
     */
    private function wantsJson()
    {
        $acceptable = $this->requestStack->getMasterRequest()->getAcceptableContentTypes();

        return isset($acceptable[0]) && false !== mb_strpos($acceptable[0], 'json');
    }
}
