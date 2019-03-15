<?php

declare(strict_types=1);

namespace App\ValueObject;
use const FILTER_VALIDATE_EMAIL;
use InvalidArgumentException;

final class EmailAddress
{
    /**
     * @var string
     */
    private $email;

    private function __construct()
    {
    }

    public static function fromString(string $string): self
    {
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid email "%s" provided', $string));
        }

        $instance = new self();

        $instance->email = $string;

        return $instance;
    }

    public function toString(): string
    {
        return $this->email;
    }
}