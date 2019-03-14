<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\DTO\User as UserDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserDTOResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return UserDTO::class === $argument->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        if (in_array(
          $request->getMethod(),
          [
            Request::METHOD_GET,
            Request::METHOD_HEAD,
            Request::METHOD_DELETE,
          ],
          true
        )) {
            $data = $request->query->all();
        } else {
            $data = array_merge(
              $request->request->all(),
              $request->files->all()
            );
        }

        $userDTO = UserDTO::fromRequest($data);

        $errors = $this->validator->validate($userDTO);

        if (count($errors)) {
            throw new \InvalidArgumentException();
        }

        yield $userDTO;
    }
}
