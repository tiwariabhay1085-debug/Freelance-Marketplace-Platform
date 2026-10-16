<?php

define('APP_NAME', 'Prolance');

define(
    'BASE_URL',
    'http://localhost/Prolance/'
);

define(
    'BACKEND_URL',
    BASE_URL . 'backend/'
);

define(
    'RESUME_PATH',
    dirname(__DIR__) . '/uploads/resumes/'
);

define(
    'PROFILE_PATH',
    dirname(__DIR__) . '/uploads/profiles/'
);

define(
    'COMPANY_LOGO_PATH',
    dirname(__DIR__) . '/uploads/company_logos/'
);

define(
    'SESSION_NAME',
    'PROLANCE_SESSION'
);

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}