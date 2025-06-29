<?php

namespace RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Review;

use RasaTestCase\ReviewService\Domain\Review\Review;

final class ReviewMapper
{
    public static function toRecord(Review $review): ReviewORMRecord
    {
        $record = new ReviewORMRecord();
        $record->clientId = $review->getClientId();
        $record->rating = $review->getRating()->getValue();
        $record->comment = $review->getComment()?->getText();
        $record->createdAt = $review->getCreatedDate();

        return $record;
    }
}

