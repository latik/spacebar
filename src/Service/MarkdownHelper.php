<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface as Cache;

class MarkdownHelper
{
    /**
     * @var MarkdownInterface
     */
    private $markdown;
    /**
     * @var Cache
     */
    private $cache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var LoggerInterface
     */
    private $markdownLogger;

    public function __construct(MarkdownInterface $markdown, Cache $cache, LoggerInterface $logger, LoggerInterface $markdownLogger)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $logger;
        $this->markdownLogger = $markdownLogger;
    }

    public function parse(string $source): string
    {
        $this->logger->info('main channel');
        if (stripos($source, 'bacon') !== false) {
            $this->markdownLogger->info('They are talking about bacon again!');
        }

        $cacheItem = $this->cache->getItem('markdown_'.md5($source));
        if (!$cacheItem->isHit()) {
            $cacheItem->set($this->markdown->transform($source));
            $this->cache->save($cacheItem);
        }

        return $cacheItem->get();
    }
}