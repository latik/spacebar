<?php

declare(strict_types=1);

namespace App\Service;

class ResolverCollection
{
    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            echo get_class($handler).PHP_EOL;
        }
    }
}
