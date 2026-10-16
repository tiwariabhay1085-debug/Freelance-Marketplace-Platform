<?php

require_once __DIR__ .
    '/../../config/config.php';

require_once __DIR__ .
    '/../../controllers/AuthController.php';


header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);

    exit;
}


$email = trim($_POST['email'] ?? '');

$password = $_POST['password'] ?? '';


if (
    empty($email) ||
    empty($password)
) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Email and password are required.'
    ]);

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid email address.'
    ]);

    exit;
}


$auth = new AuthController();


$result = $auth->login(
    $email,
    $password
);


if (!$result['success']) {

    http_response_code(401);
}


echo json_encode($result);