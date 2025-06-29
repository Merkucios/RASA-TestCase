<?php

namespace RasaTestCase\ReviewService\Domain\Review;

interface ReviewRepositoryInterface
{
    public function save(Review $review);
}

