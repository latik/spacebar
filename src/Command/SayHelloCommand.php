<?php

declare(strict_types=1);

namespace App\Command;

class SayHelloCommand
{
    /**
     * @var string
     */
    private $recipient;

    public function __construct(string $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }
}