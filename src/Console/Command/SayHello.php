<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Command\SayHelloCommand;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SayHello extends Command
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @param LoggerInterface     $logger
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus, LoggerInterface $logger)
    {
        parent::__construct();

        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
          ->setName('latik:test:say-hello')
          ->setDescription('Just my test.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $recipients = ['user@email.dev', 'user2@email.dev'];
        foreach ($recipients as $recipient) {
            $this->messageBus->dispatch(new SayHelloCommand($recipient));
        }
    }
}
