<?php

use RasaTestCase\ReviewService\Controller\SubmitReviewController;
use RasaTestCase\ReviewService\Application\Command\SubmitReview\SubmitReviewHandler;
use RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Review\CycleReviewRepository;
use RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Client\ClientORMRecord;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$clientId = $input['clientId'] ?? null;
$rating = $input['rating'] ?? null;

if ($clientId === null || $rating === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Client ID and review rating are required']);
    exit;
}

if (!is_numeric($clientId) || !is_numeric($rating)) {
    http_response_code(400);
    echo json_encode(['error' => 'Client ID and review rating must be numeric']);
    exit;
}

$clientId = (int)$clientId;
$rating = (int)$rating;

$orm = require __DIR__ . '/../config/cycle.php';

$client = $orm->getRepository(ClientORMRecord::class)->findByPK($clientId);
if (!$client) {
    http_response_code(404);
    echo json_encode(['error' => 'Client not found']);
    exit;
}

$repository = new CycleReviewRepository($orm);
$handler = new SubmitReviewHandler($repository);
$controller = new SubmitReviewController($handler);

$response = $controller([
    'clientId' => $clientId,
    'rating' => $rating,
    'comment' => $input['comment'] ?? null,
]);

$registry = new CollectorRegistry(new InMemory());
$counter = $registry->getOrRegisterCounter(
    'review_service',
    'review_submitted_total',
    'Количество успешно отправленных отзывов',
    ['client_id']
);

$counter->inc([$clientId]);
echo json_encode($response);
