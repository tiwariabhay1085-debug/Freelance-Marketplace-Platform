<?php

require_once __DIR__ . '/AuthMiddleware.php';

class EmployerMiddleware
{
    public static function handle(): void
    {
        AuthMiddleware::handle();

        if (AuthMiddleware::role() !== 'employer') {
            http_response_code(403);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Employer access required.'
            ]);

            exit;
        }
    }
}