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

// Fetch user by email
public function getUserByEmail($email) {
    echo "<br> In UserModel-getUserByEmail";  // Confirm method is called

    $query = "SELECT * FROM Users WHERE Email = ?";
    echo "<br> Query to execute: " . $query;

    $stmt = $this->db->query($query, [$email]); // Call query() method
    echo "<br> Query executed. Checking if statement is valid...";

    if (!$stmt) {
        echo "<br> Query execution failed!";
        return null;
    }

    echo "<br> Query executed successfully. Fetching results...";

    $userEmail = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch result
    echo "<br> UserEmail result: " . print_r($userEmail, true);

    if (!$userEmail) {
        echo "<br> No user found with email: " . $email;
        return null;
    }

    echo "<br> User found! Returning data...";
    return $userEmail;
}


    // Fetch user by ID
    public function getUserById($userId) {
        return $this->db->query("SELECT * FROM Users WHERE UserID = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    // TODO: Complete
    // public function registerUser($name, $email, $password) {
    //     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //     $this->db->query("INSERT INTO Users (name, email, password) VALUES (?, ?, ?)", [$name, $email, $hashedPassword]);
    //     return $this->db->lastInsertId();
    // }
}
?>
