<?php

namespace Core;

use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->getConnection();
    }
}