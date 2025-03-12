<?php
class Database {
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host=localhost;dbname=scholarlytest;charset=utf8mb4";
        $user = "root";  // Change if using a different MySQL user
        $password = "";  // Set password if applicable

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}

// Based off Dani Krossing Php OOP tutorial