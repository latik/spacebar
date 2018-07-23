<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class AdminArticleController extends Controller
{
    /**
     * @Route("/", name="admin_article_index", methods="GET")
     * @param ArticleRepository $articleRepository
     * @Template
     */
    public function index(ArticleRepository $articleRepository)
    {
        return ['articles' => $articleRepository->findAll()];
    }

    /**
     * @Route("/new", name="admin_article_new", methods="GET|POST")
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @Template
     */
    public function new(Request $request, ArticleRepository $articleRepository)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->store($article);

            return $this->redirectToRoute('admin_article_index');
        }

        return [
          'article' => $article,
          'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}", name="admin_article_show", methods="GET")
     * @param Article $article
     * @Template
     */
    public function show(Article $article)
    {
        return ['article' => $article];
    }

    /**
     * @Route("/{id}/edit", name="admin_article_edit", methods="GET|POST")
     * @param Request $request
     * @param Article $article
     * @param ArticleRepository $articleRepository
     * @Template
     */
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->store($article);

            return $this->redirectToRoute('admin_article_edit', ['id' => $article->getId()]);
        }

        return [
          'article' => $article,
          'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}", name="admin_article_delete", methods="DELETE")
     * @param Request $request
     * @param Article $article
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article);
        }

        return $this->redirectToRoute('admin_article_index');
    }
}

