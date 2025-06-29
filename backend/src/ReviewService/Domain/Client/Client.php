<?php

namespace RasaTestCase\ReviewService\Domain\Client;

final class Client
{
    public function __construct(
        private string $id,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }


}
