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
        dump($resolverCollection);
        die;
        return new Response();
    }
}
