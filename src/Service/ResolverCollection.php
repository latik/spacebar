<?php

declare(strict_types=1);

namespace App\Service;

class ResolverCollection
{
    /**
     * @var iterable
     */
    public $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }
}
