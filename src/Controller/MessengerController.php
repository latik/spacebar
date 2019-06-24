<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\JobNotification;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(MessageBusInterface $messageBus, LoggerInterface $logger)
    {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    /**
     * @Route("/messenger", name="messenger")
     */
    public function __invoke()
    {
        $this->messageBus->dispatch(new JobNotification('A string to be sent...'.time()));

        $this->logger->info('Sending new notification');

        return $this->json(
          [
            'msg' => 'Sending new notification',
          ]
        );
    }
}
