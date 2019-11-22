<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\SlackClient;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homePage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render(
          'article/homepage.html.twig',
          [
            'articles' => $articles,
          ]
        );
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, SlackClient $slack)
    {
        $slack->sendMessage('Kahn', 'Ah, Kirk, my old friend...');

        $comments = $article->getNonDeletedComments();

        return $this->render(
          'article/show.html.twig',
          [
            'article' => $article,
            'comments' => $comments,
          ]
        );
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     *
     * @throws Exception
     */
    public function toggleArticleHeart(Article $article)
    {
        $article->incrementHeartCount();

        return $this->json(
          [
            'hearts' => $article->getHeartCount(),
          ]
        );
    }
}