<?php

use App\Controllers\AuthController;

$authController = new AuthController();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'POST' && $uri === '/prolance/api/register') {

    $authController->register();

    exit;
}

if ($method === 'POST' && $uri === '/prolance/api/login') {

    $authController->login();

    exit;
}

http_response_code(404);

echo json_encode([
    'success' => false,
    'message' => 'Route not found'
]);