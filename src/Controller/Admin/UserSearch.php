<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Contract\UserFinder;
use App\Query\QueryObjectFactory;
use App\Responders\ListUsersResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSearch
{
    /**
     * @var QueryObjectFactory
     */
    private $queryObjectFactory;

    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @var ListUsersResponder
     */
    private $response;

    /**
     * @param QueryObjectFactory $queryObjectFactory
     * @param UserFinder $userFinder
     * @param ListUsersResponder $response
     */
    public function __construct(
        QueryObjectFactory $queryObjectFactory,
        UserFinder $userFinder,
        ListUsersResponder $response
    ) {
        $this->queryObjectFactory = $queryObjectFactory;
        $this->userFinder = $userFinder;
        $this->response = $response;
    }

    /**
     * @Route("/user/search", name="user_search")
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $queryObject = $this->queryObjectFactory::fromArray($request->query->all());

        $users = $this->userFinder->execute($queryObject);

        return $this->response->send($users);
    }
}
