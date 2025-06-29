<?php

namespace RasaTestCase\ReviewService\Application\Command\CheckClientExists;

final class CheckClientExistsCommand
{
    public function __construct(public readonly string $clientId) {}
}