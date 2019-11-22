<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Exception\ApiProblemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestObjectResolver implements ArgumentValueResolverInterface
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
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() instanceof RequestObject;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ExceptionInterface
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $data = $request->request->all();
        if (Request::METHOD_GET === $request->getMethod()) {
            $data = $request->query->all();
        }

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(\is_array($data) ? $data : []);
        }

        $dto = $this->denormalizer->denormalize($data, $argument->getType());

        $this->validateDTO($dto);

        yield $dto;
    }

    private function validateDTO($dto): void
    {
        $errors = $this->validator->validate($dto);

        if (0 !== \count($errors)) {
            throw new ApiProblemException($errors);
        }
    }
}
