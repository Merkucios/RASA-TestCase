<?php

require __DIR__ . '/../vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

$registry = new CollectorRegistry(new InMemory());

$renderer = new RenderTextFormat();

header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
http_response_code(200);
echo $renderer->render($registry->getMetricFamilySamples());
