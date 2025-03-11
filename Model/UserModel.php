<?php
require_once __DIR__ . '/../Core/Model.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserByEmail($email) {
        return $this->db->query("SELECT * FROM users WHERE email = ?", [$email])->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch user by ID
    public function getUserById($userId) {
        return $this->db->query("SELECT * FROM users WHERE userid = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", [$name, $email, $hashedPassword]);
        return $this->db->lastInsertId();
    }
}
?>
