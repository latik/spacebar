<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\MarkdownHelper;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters(): array
    {
        return [
          new TwigFilter('cached_markdown', function ($value): string {
              return $this->processMarkdown($value);
          }, ['is_safe' => ['html']]),
        ];
    }

    public function processMarkdown($value): string
    {
        return $this->container
          ->get(MarkdownHelper::class)
          ->parse($value);
    }

    /**
     * Returns an array of service types required by such instances, optionally keyed by the service names used internally.
     *
     * @return array The required service types, optionally keyed by service names
     */
    public static function getSubscribedServices()
    {
        return [
          MarkdownHelper::class,
        ];
    }
}
