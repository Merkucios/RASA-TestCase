<?php

namespace RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Review;

use RasaTestCase\ReviewService\Domain\Review\Review;
use RasaTestCase\ReviewService\Domain\Review\ReviewRepositoryInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\EntityManager;

final class CycleReviewRepository implements ReviewRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(ORM $orm)
    {
        $this->entityManager = new EntityManager($orm);
    }

    public function save(Review $review): void
    {
        $record = ReviewMapper::toRecord($review);
        $this->entityManager->persist($record);
        $this->entityManager->run();
    }
}
