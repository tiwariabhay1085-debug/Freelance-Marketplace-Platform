CREATE DATABASE IF NOT EXISTS prolance;

USE prolance;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM('admin', 'client', 'freelancer')
        NOT NULL DEFAULT 'freelancer',

    profile_image VARCHAR(255) NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE freelancer_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL UNIQUE,

    bio TEXT NULL,

    hourly_rate DECIMAL(10,2) DEFAULT 0,

    experience_years INT DEFAULT 0,

    location VARCHAR(100) NULL,

    portfolio_url VARCHAR(255) NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE client_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL UNIQUE,

    company_name VARCHAR(150) NULL,

    company_description TEXT NULL,

    website VARCHAR(255) NULL,

    location VARCHAR(100) NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE freelancer_skills (
    freelancer_id INT UNSIGNED NOT NULL,

    skill_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (freelancer_id, skill_id),

    FOREIGN KEY (freelancer_id)
        REFERENCES freelancer_profiles(id)
        ON DELETE CASCADE,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE
);

CREATE TABLE projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    client_id INT UNSIGNED NOT NULL,

    title VARCHAR(200) NOT NULL,

    description TEXT NOT NULL,

    budget DECIMAL(10,2) NOT NULL,

    deadline DATE NULL,

    status ENUM(
        'open',
        'in_progress',
        'completed',
        'cancelled'
    ) DEFAULT 'open',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (client_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE proposals (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    project_id INT UNSIGNED NOT NULL,

    freelancer_id INT UNSIGNED NOT NULL,

    cover_letter TEXT NOT NULL,

    bid_amount DECIMAL(10,2) NOT NULL,

    estimated_days INT NOT NULL,

    status ENUM(
        'pending',
        'accepted',
        'rejected'
    ) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE CASCADE,

    FOREIGN KEY (freelancer_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    UNIQUE(project_id, freelancer_id)
);

