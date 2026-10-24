<?php

class Profile
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get profile by user ID
    public function getByUserId($user_id)
    {
        $sql = "SELECT 
                    p.id,
                    p.user_id,
                    p.full_name,
                    p.bio,
                    p.profile_image,
                    p.location,
                    p.phone,
                    p.experience_years,
                    p.created_at,
                    p.updated_at
                FROM profiles p
                WHERE p.user_id = :user_id
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new profile
    public function create(
        $user_id,
        $full_name,
        $bio = null,
        $profile_image = null,
        $location = null,
        $phone = null,
        $experience_years = 0
    ) {
        $sql = "INSERT INTO profiles
                (
                    user_id,
                    full_name,
                    bio,
                    profile_image,
                    location,
                    phone,
                    experience_years
                )
                VALUES
                (
                    :user_id,
                    :full_name,
                    :bio,
                    :profile_image,
                    :location,
                    :phone,
                    :experience_years
                )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':profile_image', $profile_image);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(
            ':experience_years',
            $experience_years,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }

    // Update an existing profile
    public function update(
        $user_id,
        $full_name,
        $bio = null,
        $profile_image = null,
        $location = null,
        $phone = null,
        $experience_years = 0
    ) {
        $sql = "UPDATE profiles
                SET
                    full_name = :full_name,
                    bio = :bio,
                    profile_image = :profile_image,
                    location = :location,
                    phone = :phone,
                    experience_years = :experience_years
                WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':profile_image', $profile_image);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(
            ':experience_years',
            $experience_years,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }

    // Check whether a profile already exists
    public function exists($user_id)
    {
        $sql = "SELECT id
                FROM profiles
                WHERE user_id = :user_id
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}