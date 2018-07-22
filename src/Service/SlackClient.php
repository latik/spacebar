<?php

namespace App\Service;

use Nexy\Slack\Client as Slack;

class SlackClient
{
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
     * @throws \Http\Client\Exception
     */
    public function sendMessage(string $from, string $message)
    {
        $slackMessage = $this->slack->createMessage()
          ->from($from)
          ->setText($message);

        $this->slack->sendMessage($slackMessage);
    }
}