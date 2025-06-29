<?php

namespace RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Client;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'clients')]
class ClientORMRecord
{
    #[Column(type: 'primary')]
    public int $id;
}
