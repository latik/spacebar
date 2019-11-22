<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Traversable;

final class ApiProblemException extends HttpException
{
    /**
     * @var Traversable
     */
    private $violations;

    public function __construct(Traversable $violations)
    {
        $this->violations = $violations;

        parent::__construct(400, 'There was a API error');
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        $data = [];

        /** @var ConstraintViolation $violation */
        foreach ($this->violations as $violation) {
            $data[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $data;
    }
}
