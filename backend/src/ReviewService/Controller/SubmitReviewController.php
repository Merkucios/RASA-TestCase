<?php

namespace RasaTestCase\ReviewService\Controller;

use RasaTestCase\ReviewService\Application\Command\SubmitReview\SubmitReviewCommand;
use RasaTestCase\ReviewService\Application\Command\SubmitReview\SubmitReviewHandler;
use Throwable;

final class SubmitReviewController
{
    public function __construct(
        private SubmitReviewHandler $handler
    ) {}

    public function __invoke(array $data): array
    {
        $clientId = $data['clientId'] ?? null;
        $rating = $data['rating'] ?? null;
        $comment = $data['comment'] ?? null;

        if (!is_numeric($clientId) || !is_numeric($rating)) {
            http_response_code(422);
            return ['error' => 'clientId and rating являются обязательными параметрами. Их требуется передавать в виде чисел'];
        }

        try {
            $command = new SubmitReviewCommand(
                clientId: (int)$clientId,
                rating: (int)$rating,
                comment: $comment
            );

            $this->handler->handle($command);

            return ['status' => 'success'];
        } catch (Throwable $e) {
            http_response_code(500);
            return [
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];
        }
    }
}
