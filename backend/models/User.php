<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private PDO $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }


    // Find user by email

    public function findByEmail(string $email): ?array
    {
        $sql = "
            SELECT *
            FROM users
            WHERE email = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        return $user ?: null;
    }


    // Find user by ID

    public function findById(int $id): ?array
    {
        $sql = "
            SELECT *
            FROM users
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$id]);

        $user = $stmt->fetch();

        return $user ?: null;
    }


    // Create user

    public function create(
        string $name,
        string $email,
        string $password,
        string $role = 'seeker'
    ): int {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "
            INSERT INTO users
            (
                name,
                email,
                password,
                role
            )
            VALUES
            (?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            $hashedPassword,
            $role
        ]);

        return (int) $this->db->lastInsertId();
    }


    // Verify password

    public function verifyPassword(
        string $password,
        string $hashedPassword
    ): bool {

        return password_verify(
            $password,
            $hashedPassword
        );
    }
}