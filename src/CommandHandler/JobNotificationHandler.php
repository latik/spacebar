<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\JobNotification;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class JobNotificationHandler implements MessageHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param JobNotification $message
     */
    public function __invoke(JobNotification $message): void
    {
        sleep(5);

        $this->logger->debug('New job received '.time().'. Payload:'.$message->getPayload());
    }
}
