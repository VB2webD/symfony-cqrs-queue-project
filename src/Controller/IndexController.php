<?php

namespace App\Controller;

use App\Form\TestMessageFormType;
use App\Message\TestMessage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\throwException;

class IndexController extends AbstractController
{


    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly ValidatorInterface $validator
    )
    {
    }


    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $form1 = $this->createForm(TestMessageFormType::class);

        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid() && $form1->getName()) {
            $this->processFormSubmission($form1->getData());
        }

        return $this->render('index.html.twig', [
            'form1' => $form1->createView(),
        ]);
    }


    private function processFormSubmission(array $data): void
    {

        for ($i = 0; $i < $data['amount_prio1']; $i++) {
            $message = new TestMessage($this->generateRandomUsername(), 0);
            $validationErrors = $this->validator->validate($message);

            if (count($validationErrors) > 0) {
                throw new ValidatorException($validationErrors[0]->getMessage());
                }
            $this->bus->dispatch($message);
        }

        for ($i = 0; $i < $data['amount_prio2']; $i++) {
            $message = new TestMessage($this->generateRandomUsername(), 2);
            $validationErrors = $this->validator->validate($message);

            if (count($validationErrors) > 0) {
                throw new ValidatorException($validationErrors[0]->getMessage());
            }
            $this->bus->dispatch($message);
        }


        $this->addFlash('success', sprintf('%d messages of prio1 send, %d of prio2 send', $data['amount_prio1'], $data['amount_prio2']));
    }


    private function generateRandomUsername(): string
    {
        $usernames = ['Sergei', 'BranskToTheY', 'Nikolai', 'Hamza', 'Richard', 'ChatGPT'];

        return $usernames[ array_rand($usernames) ];
    }
}
