<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\SlackClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
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

        $comments = [
          'first' => '1 comment',
          'second' => '2 comment',
          'third' => '3 comment',
        ];

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
     * @throws \Exception
     */
    public function toggleArticleHeart($slug)
    {
        return $this->json(['hearts' => \random_int(5, 100)]);
    }
}