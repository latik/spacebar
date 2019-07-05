<?php

declare(strict_types=1);

namespace App\Backoffice\Presentation\Console;

use App\Backoffice\Application\Command\RegisterUserCommand;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class UserRegisterCommand extends Command
{
    protected static $defaultName = 'UserRegister';

    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    protected function configure()
    {
        $this
            ->setDescription('Register user')
            ->addArgument('email', InputArgument::REQUIRED, 'The email')
            ->addArgument('password', InputArgument::REQUIRED, 'The user password')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text');
    }

    public function __construct(
        MessageBusInterface $commandBus,
        DenormalizerInterface $denormalizer,
        SerializerInterface $serializer
    ) {
        parent::__construct(static::$defaultName);
        $this->commandBus = $commandBus;
        $this->denormalizer = $denormalizer;
        $this->serializer = $serializer;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $command = $this->denormalizer->denormalize($input->getArguments(), RegisterUserCommand::class);

        $user = $this->commandBus->dispatch($command);

        $io->write($this->serializer->serialize($user, JsonEncoder::FORMAT));
    }
}
