<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\SayHelloCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SayHelloHandler implements MessageHandlerInterface
{
    public function __invoke(SayHelloCommand $command): void
    {
        echo sprintf('Send mail to %s'.PHP_EOL, $command->getRecipient());
    }
}
