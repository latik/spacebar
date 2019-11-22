<?php

declare(strict_types=1);

namespace App\ValueObject;

use InvalidArgumentException;
use const PASSWORD_DEFAULT;

final class Password
{
    /**
     * @var string
     */
    private $password;

    private function __construct()
    {
    }

    public static function fromString(string $string): self
    {
        if ('' === $string) {
            throw new InvalidArgumentException('An empty password is not acceptable');
        }

        $instance = new self();

        $instance->password = $string;

        return $instance;
    }

    public function toHash(): string
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function matches(string $hash): bool
    {
        return password_verify($this->password, $hash);
    }
}