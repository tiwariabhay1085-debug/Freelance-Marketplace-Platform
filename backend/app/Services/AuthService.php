<?php

namespace App\Services;

use App\Models\User;
use Exception;

class AuthService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register(
        string $name,
        string $email,
        string $password,
        string $role
    ): int {

        $existingUser = $this->userModel->findByEmail($email);

        if ($existingUser) {
            throw new Exception("Email already registered");
        }

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        return $this->userModel->create(
            $name,
            $email,
            $hashedPassword,
            $role
        );
    }

    public function login(
        string $email,
        string $password
    ): array {

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            throw new Exception("Invalid email or password");
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception("Invalid email or password");
        }

        unset($user['password']);

        return $user;
    }
}