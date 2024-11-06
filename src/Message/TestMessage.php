<?php

namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TestMessage
{

    public function __construct(
        #[Assert\NotBlank(message: "Username cannot be empty.")]
        public readonly string $username,

        #[Assert\NotBlank(message: "Priority cannot be empty.")]
        #[Assert\PositiveOrZero(message: "Priority must be 0 or a positive integer.")]
        public readonly int $priority
    )
    {

    }

}