<?php

declare(strict_types=1);

namespace App\Command;

final class JobNotification
{
    private $payload;

    /**
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }
}