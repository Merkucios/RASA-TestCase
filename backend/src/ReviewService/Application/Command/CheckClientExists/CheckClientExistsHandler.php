<?php

namespace RasaTestCase\ReviewService\Application\Command\CheckClientExists;

use RasaTestCase\ReviewService\Domain\Client\ClientRepositoryInterface;

final class CheckClientExistsHandler
{
    public function __construct(private ClientRepositoryInterface $clientRepository) {}

    public function __invoke(CheckClientExistsCommand $command): bool
    {
        return $this->clientRepository->findById($command->clientId) !== null;
    }
}