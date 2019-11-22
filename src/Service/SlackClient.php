<?php

declare(strict_types=1);

namespace App\Service;

use App\Helper\LoggerTrait;
use Http\Client\Exception;
use Nexy\Slack\Client as Slack;

final class SlackClient
{
    use LoggerTrait;

    /**
     * @var Slack
     */
    private $slack;

    public function __construct(Slack $slack)
    {
        $this->slack = $slack;
    }

    /**
     * @param string $from
     * @param string $message
     *
     * @throws Exception
     */
    public function sendMessage(string $from, string $message): void
    {
        $this->logInfo(
          'Beaming a message to Slack!',
          [
            'message' => $message,
          ]
        );

        $slackMessage = $this->slack->createMessage()
          ->from($from)
          ->setText($message);

        $this->slack->sendMessage($slackMessage);
    }
}