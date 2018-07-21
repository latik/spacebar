<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface as Cache;

class MarkdownHelper
{
    private $cache;
    private $markdown;

    public function __construct(MarkdownInterface $markdown, Cache $cache)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
    }

    public function parse(string $source): string
    {
        $cacheItem = $this->cache->getItem('markdown_'.md5($source));
        if (!$cacheItem->isHit()) {
            $cacheItem->set($this->markdown->transform($source));
            $this->cache->save($cacheItem);
        }

        return $cacheItem->get();
    }
}