<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
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
    public function show($slug, LoggerInterface $logger, Twig $twig)
    {
        $comments = [
          'first' => '1 comment',
          'second' => '2 comment',
          'third' => '3 comment',
        ];

        $logger->info('Heeelo!!!');

        try {
            return new Response(
              $twig->render(
                'article/show.html.twig',
                [
                  'title' => $slug,
                  'comments' => $comments,
                ]
              )
            );
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }
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