<?php

require_once __DIR__ . '/AuthMiddleware.php';

class SeekerMiddleware
{
    public static function handle(): void
    {
        AuthMiddleware::handle();

        if (AuthMiddleware::role() !== 'seeker') {
            http_response_code(403);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Job seeker access required.'
            ]);

            exit;
        }
    }
}
