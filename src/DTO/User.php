<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="7")
     */
    public $password;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    public static function fromRequest(array $requestData): self
    {
        $self = new self();
        $self->password = $requestData['password'] ?? null;
        $self->email = $requestData['email'] ?? null;

        return $self;
    }
}