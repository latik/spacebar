<?php

namespace App\Service;

use App\Helper\LoggerTrait;
use Nexy\Slack\Client as Slack;

class SlackClient
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
     * @throws \Http\Client\Exception
     */
    public function sendMessage(string $from, string $message)
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