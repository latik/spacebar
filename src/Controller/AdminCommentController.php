<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends Controller
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     * @Template
     */
    public function index(CommentRepository $repository)
    {
        return [
          'comments' => $repository->findBy([], ['createdAt' => 'DESC']),
        ];
    }
}
