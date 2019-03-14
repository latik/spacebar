<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestObjectResolver implements ArgumentValueResolverInterface
{
    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
      DenormalizerInterface $denormalizer,
      ValidatorInterface $validator
    ) {
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_subclass_of($argument->getType(), RequestObject::class);
    }

    /**
     * {@inheritdoc}
     * @throws ExceptionInterface
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $data = $request->request->all();
        if (Request::METHOD_GET === $request->getMethod()) {
            $data = $request->query->all();
        }

        $dto = $this->denormalizer->denormalize($data, $argument->getType());

        $this->validateDTO($dto);

        yield $dto;
    }

    private function validateDTO($dto): void
    {
        $errors = $this->validator->validate($dto);

        if (0 !== count($errors)) {
            throw new InvalidArgumentException('');
        }
    }
}