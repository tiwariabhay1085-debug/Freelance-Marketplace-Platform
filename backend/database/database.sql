CREATE DATABASE IF NOT EXISTS prolance
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE prolance;


-- =========================================
-- USERS
-- =========================================

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM(
        'admin',
        'employer',
        'seeker'
    ) NOT NULL DEFAULT 'seeker',

    status ENUM(
        'active',
        'inactive',
        'blocked'
    ) NOT NULL DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);


-- =========================================
-- JOB SEEKERS
-- =========================================

CREATE TABLE job_seekers (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL UNIQUE,

    phone VARCHAR(20),

    address TEXT,

    city VARCHAR(100),

    state VARCHAR(100),

    qualification VARCHAR(150),

    skills TEXT,

    experience VARCHAR(100),

    resume VARCHAR(255),

    profile_image VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_seeker_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


-- =========================================
-- EMPLOYERS
-- =========================================

CREATE TABLE employers (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL UNIQUE,

    company_name VARCHAR(150) NOT NULL,

    company_email VARCHAR(150),

    phone VARCHAR(20),

    website VARCHAR(255),

    description TEXT,

    address TEXT,

    city VARCHAR(100),

    state VARCHAR(100),

    company_logo VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_employer_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


-- =========================================
-- CATEGORIES
-- =========================================

CREATE TABLE categories (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL UNIQUE,

    description TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- JOBS
-- =========================================

CREATE TABLE jobs (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    employer_id INT UNSIGNED NOT NULL,

    category_id INT UNSIGNED,

    title VARCHAR(200) NOT NULL,

    description TEXT NOT NULL,

    requirements TEXT,

    location VARCHAR(150),

    salary_min DECIMAL(10,2),

    salary_max DECIMAL(10,2),

    employment_type ENUM(
        'full_time',
        'part_time',
        'contract',
        'internship'
    ) DEFAULT 'full_time',

    experience_required VARCHAR(100),

    deadline DATE,

    status ENUM(
        'pending',
        'approved',
        'rejected',
        'closed'
    ) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_job_employer
        FOREIGN KEY (employer_id)
        REFERENCES employers(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_job_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE SET NULL
);


-- =========================================
-- APPLICATIONS
-- =========================================

CREATE TABLE applications (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    job_id INT UNSIGNED NOT NULL,

    seeker_id INT UNSIGNED NOT NULL,

    cover_letter TEXT,

    resume VARCHAR(255),

    status ENUM(
        'applied',
        'shortlisted',
        'interview',
        'selected',
        'rejected',
        'withdrawn'
    ) DEFAULT 'applied',

    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_application (
        job_id,
        seeker_id
    ),

    CONSTRAINT fk_application_job
        FOREIGN KEY (job_id)
        REFERENCES jobs(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_application_seeker
        FOREIGN KEY (seeker_id)
        REFERENCES job_seekers(id)
        ON DELETE CASCADE
);


-- =========================================
-- DEFAULT CATEGORIES
-- =========================================

INSERT INTO categories
(name, description)
VALUES

(
    'Web Development',
    'PHP, .NET, JavaScript and web development jobs'
),

(
    'Software Development',
    'Software development and programming jobs'
),

(
    'Data Science',
    'Data analysis and data science jobs'
),

(
    'Database',
    'Database administration and development jobs'
),

(
    'UI/UX Design',
    'UI and UX design jobs'
),

(
    'Marketing',
    'Digital marketing and marketing jobs'
),

(
    'Finance',
    'Accounting and finance jobs'
),

(
    'Human Resources',
    'HR and recruitment jobs'
);