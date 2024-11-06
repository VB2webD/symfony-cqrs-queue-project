<?php

namespace App\Message;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class TestMessageHandler
{

    public function __construct(private LoggerInterface $messengerLogger)
    {
    }


    public function __invoke(TestMessage $message): void
    {
        sleep(5 - $message->priority);
        print("Message received with username: " . $message->username . " and priority: " . $message->priority . "\n");
        $this->messengerLogger->info('Test message received', [
            'username' => $message->username,
            'priority' => $message->priority,
        ]);
    }
}