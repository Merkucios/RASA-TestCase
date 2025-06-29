<?php
namespace RasaTestCase\ReviewService\Domain\Review;

use DateTimeImmutable;

final class Review{
    public function __construct(
        private int $clientId,
        private Rating $rating,
        private ?Comment $comment = null,
        private DateTimeImmutable $createdAt = new DateTimeImmutable()
    ) {}
    
    public function getClientId():int {
        return $this->clientId;
    }

    public function getRating():Rating{
        return $this->rating;
    }

    public function getComment():?Comment{
        return $this->comment;
    }

    public function getCreatedDate():DateTimeImmutable{
        return $this->createdAt;
    }
}

