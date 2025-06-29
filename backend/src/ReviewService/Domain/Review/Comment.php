<?php

namespace RasaTestCase\ReviewService\Domain\Review;

final class Comment{
    public function __construct(private string $text){}

    public function getText():string
    {
        return $this->text;
    }
}

