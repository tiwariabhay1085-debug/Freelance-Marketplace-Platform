<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private User $user;


    public function __construct()
    {
        $this->user = new User();
    }


    // Register user

    public function register(
        string $name,
        string $email,
        string $password,
        string $role = 'seeker'
    ): array {

        $existingUser =
            $this->user->findByEmail($email);


        if ($existingUser !== null) {

            return [
                'success' => false,
                'message' => 'Email already registered.'
            ];
        }


        if (strlen($password) < 6) {

            return [
                'success' => false,
                'message' =>
                    'Password must be at least 6 characters.'
            ];
        }


        $userId = $this->user->create(
            $name,
            $email,
            $password,
            $role
        );


        return [
            'success' => true,
            'message' => 'Registration successful.',
            'user_id' => $userId
        ];
    }


    // Login user

    public function login(
        string $email,
        string $password
    ): array {

        $user =
            $this->user->findByEmail($email);


        if ($user === null) {

            return [
                'success' => false,
                'message' => 'Invalid email or password.'
            ];
        }


        if (
            $user['status'] !== 'active'
        ) {

            return [
                'success' => false,
                'message' => 'Your account is not active.'
            ];
        }


        if (
            !$this->user->verifyPassword(
                $password,
                $user['password']
            )
        ) {

            return [
                'success' => false,
                'message' => 'Invalid email or password.'
            ];
        }


        $_SESSION['user_id'] = $user['id'];

        $_SESSION['name'] = $user['name'];

        $_SESSION['email'] = $user['email'];

        $_SESSION['role'] = $user['role'];


        return [
            'success' => true,
            'message' => 'Login successful.',
            'role' => $user['role']
        ];
    }


    // Logout

    public function logout(): void
    {
        $_SESSION = [];

        session_destroy();
    }
}