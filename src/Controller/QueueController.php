<?php
namespace App\Controller;

use App\Message\TestMessage;
use App\Request\SendMessageRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dispatch')]
class QueueController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }


    /**
     * @throws \Symfony\Component\Messenger\Exception\ExceptionInterface
     */
    #[Route('/message', name: 'dispatch_message')]
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        [$amount, $priority] = $request->getValidatedInput();


            $this->messageBus->dispatch(new TestMessage($amount, $priority));


        return new JsonResponse(['status' => "Message dispatched with amount: $amount and priority: $priority"]);
    }
}
