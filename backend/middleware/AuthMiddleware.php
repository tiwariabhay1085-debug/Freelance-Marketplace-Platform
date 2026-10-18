<?php

require_once __DIR__ . '/../config/config.php';

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Authentication required.'
            ]);

            exit;
        }
    }

    public static function userId(): int
    {
        return (int) $_SESSION['user_id'];
    }

    public static function role(): string
    {
        return $_SESSION['role'] ?? '';
    }
}