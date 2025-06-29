<?php

namespace RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Client;

use Cycle\ORM\ORMInterface;
use RasaTestCase\ReviewService\Domain\Client\Client;
use RasaTestCase\ReviewService\Domain\Client\ClientRepositoryInterface;

final class CycleClientRepository implements ClientRepositoryInterface
{
    public function __construct(private ORMInterface $orm) {}

    public function findById(string $id): ?Client
    {
        $record = $this->orm
            ->getRepository(ClientORMRecord::class)
            ->findOne(['id' => $id]);

        if (!$record) {
            return null;
        }

        return ClientMapper::toDomain($record);
    }

}