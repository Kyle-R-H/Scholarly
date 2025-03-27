<?php
require_once 'Core/Database.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch user by email
    public function getUserByEmail($email) {
        // echo "<br> In getUserByEmail  // Confirm method is called
    
        $query = "SELECT * FROM Users WHERE Email = ?";
        // echo "<br> Query to execute: " . $query;
    
        $stmt = $this->db->query($query, [$email]); // Call query() method
        // echo "<br> Query executed. Checking if statement is valid...";
    
        if (!$stmt) {
            // echo "<br> Query execution failed!";
            return null;
        }
    
        // echo "<br> Query executed successfully. Fetching results...";
    
        $userEmail = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch result
        // echo "<br> UserEmail result: " . print_r($userEmail, true);
    
        if (!$userEmail) {
            // echo "<br> No user found with email: " . $email;
            return null;
        }
    
        // echo "<br> User found! Returning data...";
        return $userEmail;
    }
    
}
?>
