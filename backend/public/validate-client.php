<?php

use RasaTestCase\ReviewService\Infrastructure\Persistence\CycleORM\Client\CycleClientRepository;
use Dotenv\Dotenv;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$clientId = $_GET['id'] ?? null;

if (!is_numeric($clientId)) {
    http_response_code(400);
    echo json_encode(['error' => 'client_id должен быть числом']);
    exit;
}

$orm = require __DIR__ . '/../config/cycle.php';

$repository = new CycleClientRepository($orm);
$client = $repository->findById((int) $clientId);

if ($client === null) {
    http_response_code(404);
    echo json_encode(['valid' => false, 'error' => 'Клиент не найден']);
    exit;
}

echo json_encode(['valid' => true]);
