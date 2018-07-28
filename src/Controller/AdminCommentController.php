<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends Controller
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     * @Template
     */
    public function index(CommentRepository $repository, Request $request)
    {
        $query = $request->query->get('q');

        $comments = $repository->findAllWithSearch($query);

        return [
          'comments' => $comments,
          'query' => $query,
        ];
    }
}
