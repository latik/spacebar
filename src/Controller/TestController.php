<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResolverCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TestController extends AbstractController
{
    /**
     * @Route("/test")
     */
    public function testPage(ResolverCollection $resolverCollection)
    {
        foreach ($resolverCollection->handlers as $handler) {
            echo get_class($handler).PHP_EOL;
        }

        return new Response();
    }
}
