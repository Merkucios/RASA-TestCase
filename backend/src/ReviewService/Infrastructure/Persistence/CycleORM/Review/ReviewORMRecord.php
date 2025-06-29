<?php

namespace RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Review;

use Cycle\Annotated\Annotation as Cycle;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
#[Entity(repository: ReviewRepository::class, table: 'reviews')]
class ReviewORMRecord
{
    #[Column(type: 'primary')]
    public int $id;

    #[Column(type: 'integer')]
    public int $clientId;

    #[Column(type: 'integer')]
    public int $rating;

    #[Column(type: 'text', nullable: true)]
    public ?string $comment = null;

    #[Column(type: 'datetime')]
    public \DateTimeImmutable $createdAt;
}

