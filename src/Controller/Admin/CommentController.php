<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{
    private $commentsPerPage = 10;

    /**
     * @Route("/admin/comment", name="admin_comment")
     * @Template
     */
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $query = $request->query->get('q');

        $queryBuilder = $repository->getWithSearchQueryBuilder($query);
        $pagination = $paginator->paginate(
          $queryBuilder,
          $request->query->getInt('page', 1) /*page number*/,
          $this->commentsPerPage
        );

        return [
          'pagination' => $pagination,
        ];
    }
}
