<?php

namespace RasaTestCase\ReviewService\Domain\Client;

interface ClientRepositoryInterface
{
    public function findById(string $id): ?Client;
}
