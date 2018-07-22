<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment as Twig;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homePage(Twig $twig)
    {
        return new Response(
          $twig->render(
            'article/homepage.html.twig'
          )
        );
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(
      $slug,
      Twig $twig,
      SlackClient $slack,
      EntityManagerInterface $em
    ) {
        $slack->sendMessage('Kahn', 'Ah, Kirk, my old friend...');

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);
        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }
        $comments = [
          'first' => '1 comment',
          'second' => '2 comment',
          'third' => '3 comment',
        ];

        return new Response(
          $twig->render(
            'article/show.html.twig',
            [
              'article' => $article,
              'comments' => $comments,
            ]
          )
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