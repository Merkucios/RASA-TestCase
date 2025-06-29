<?php

namespace RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Client;

use RasaTestCase\ReviewService\Domain\Client\Client;

final class ClientMapper
{
    public static function toDomain(ClientORMRecord $record): Client
    {
        return new Client($record->id);
    }

    public static function toRecord(Client $client): ClientORMRecord
    {
        $record = new ClientORMRecord();
        $record->id = $client->getId();

        return $record;
    }
}
