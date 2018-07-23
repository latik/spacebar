<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
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
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin_article/index.html.twig', ['articles' => $articleRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_article_new", methods="GET|POST")
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->store($article);

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render(
          'admin_article/new.html.twig',
          [
            'article' => $article,
            'form' => $form->createView(),
          ]
        );
    }

    /**
     * @Route("/{id}", name="admin_article_show", methods="GET")
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {
        return $this->render('admin_article/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/{id}/edit", name="admin_article_edit", methods="GET|POST")
     * @param Request $request
     * @param Article $article
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->store($article);

            return $this->redirectToRoute('admin_article_edit', ['id' => $article->getId()]);
        }

        return $this->render(
          'admin_article/edit.html.twig',
          [
            'article' => $article,
            'form' => $form->createView(),
          ]
        );
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

