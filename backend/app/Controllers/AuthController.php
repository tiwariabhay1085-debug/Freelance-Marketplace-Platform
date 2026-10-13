<?php

namespace App\Controllers;

use App\Services\AuthService;
use Exception;

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function register(): void
    {
        try {

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            $id = $this->authService->register(
                $data['name'],
                $data['email'],
                $data['password'],
                $data['role']
            );

            http_response_code(201);

            echo json_encode([
                'success' => true,
                'message' => 'Registration successful',
                'user_id' => $id
            ]);

        } catch (Exception $e) {

            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function login(): void
    {
        try {

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            $user = $this->authService->login(
                $data['email'],
                $data['password']
            );

            echo json_encode([
                'success' => true,
                'user' => $user
            ]);

        } catch (Exception $e) {

            http_response_code(401);

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}