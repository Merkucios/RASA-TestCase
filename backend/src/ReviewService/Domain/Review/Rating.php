<?php

namespace RasaTestCase\ReviewService\Domain\Review;


final class Rating{
    private int $value;

    public function __construct(int $value){
        if ($value < 1 || $value > 5){
            throw new InvalidRatingException("Оценка должна быть от 1 до 5.");
        }
        $this->value = $value;
    }

    public function getValue():int {
        return $this->value;
    } 

}


