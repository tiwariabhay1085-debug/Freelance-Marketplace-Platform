<?php

require_once __DIR__ . '/AuthMiddleware.php';

class AdminMiddleware
{
    public static function handle(): void
    {
        # :: is used to access class without creating a object
        AuthMiddleware::handle();

        if (AuthMiddleware::role() !== 'admin') {
            http_response_code(403);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Admin access required.'
            ]);

            exit;
        }
    }
}