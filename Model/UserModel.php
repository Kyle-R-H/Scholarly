<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

// echo "<br> In usermodel";

class UserModel {
    private $db;

    public function __construct() {
        // echo "<br> In USerMOdel ctor";
        $this->db = new Database();
        // echo "user: " . getUserByEmail('bob@gmail.com');
    }

    // Fetch user email
    public function getUserByEmail($email) {
        echo "<br> in getUSerbyEmial";
        $query = "SELECT * FROM users WHERE email = ?";
        echo "<br>" . $query;
        $userEmail =  $this->db->query($query, [$email])->fetch(PDO::FETCH_ASSOC);
        echo "user: " . $userEmail;
        return $userEmail;
    }

    // Fetch user by ID
    public function getUserById($userId) {
        return $this->db->query("SELECT * FROM users WHERE userid = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    // TODO: Complete
    public function registerUser($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", [$name, $email, $hashedPassword]);
        return $this->db->lastInsertId();
    }
}
?>
