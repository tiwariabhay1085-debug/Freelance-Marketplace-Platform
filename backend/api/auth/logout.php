<?php

require_once __DIR__ .
    '/../../config/config.php';

require_once __DIR__ .
    '/../../controllers/AuthController.php';


header('Content-Type: application/json');


$auth = new AuthController();

$auth->logout();


echo json_encode([
    'success' => true,
    'message' => 'Logout successful.'
]);