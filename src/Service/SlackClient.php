<?php

namespace App\Service;

use Nexy\Slack\Client as Slack;
use Psr\Log\LoggerInterface;

class SlackClient
{
    /**
     * @var Slack
     */
    private $slack;
    /**
     * @var LoggerInterface|null
     */
    private $logger;

    public function __construct(Slack $slack)
    {
        $this->slack = $slack;
    }

    /**
     * @param string $from
     * @param string $message
     * @throws \Http\Client\Exception
     */
    public function sendMessage(string $from, string $message)
    {
        if ($this->logger) {
            $this->logger->info('Beaming a message to Slack!');
        }

        $slackMessage = $this->slack->createMessage()
          ->from($from)
          ->setText($message);

        $this->slack->sendMessage($slackMessage);
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}