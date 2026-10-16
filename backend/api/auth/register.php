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


$name = trim($_POST['name'] ?? '');

$email = trim($_POST['email'] ?? '');

$password = $_POST['password'] ?? '';

$role = $_POST['role'] ?? 'seeker';


if (
    empty($name) ||
    empty($email) ||
    empty($password)
) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'All required fields are required.'
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


$allowedRoles = [
    'seeker',
    'employer'
];


if (!in_array($role, $allowedRoles, true)) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid user role.'
    ]);

    exit;
}


$auth = new AuthController();


$result = $auth->register(
    $name,
    $email,
    $password,
    $role
);


if (!$result['success']) {

    http_response_code(400);
}


echo json_encode($result);