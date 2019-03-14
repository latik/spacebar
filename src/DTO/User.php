<?php

declare(strict_types=1);

namespace App\DTO;

use App\ArgumentResolver\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

class User extends RequestObject
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
}