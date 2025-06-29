<?php

namespace RasaTestCase\ReviewService\Application\Command\SubmitReview;

use RasaTestCase\ReviewService\Domain\Review\Review;
use RasaTestCase\ReviewService\Domain\Review\Rating;
use RasaTestCase\ReviewService\Domain\Review\Comment;
use RasaTestCase\ReviewService\Domain\Review\ReviewRepositoryInterface;

final class SubmitReviewHandler
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository
    ) {}

    public function handle(SubmitReviewCommand $command): void
    {
        $rating = new Rating($command->rating);

        $comment = $command->comment !== null
            ? new Comment($command->comment)
            : null;

        $review = new Review(
            clientId: $command->clientId,
            rating: $rating,
            comment: $comment
        );

        $this->reviewRepository->save($review);
    }
}

