<?php

namespace RasaTestCase\ReviewService\Application\Command\SubmitReview;

final class SubmitReviewCommand
{
    public function __construct(
        public readonly int $clientId,
        public readonly int $rating,
        public readonly ?string $comment = null
    ) {}
}

