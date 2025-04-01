<?php
require_once 'Core/Database.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch user by email
    public function getUserByEmail($email) {    
        $query = "SELECT * FROM Users WHERE Email = ?";
    
        $stmt = $this->db->query($query, [$email]); // Call query() method
    
        if (!$stmt) return null;

        $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$userEmail) return null;
    
        return $userEmail;
    }

    // Fetch user by ID
    public function getUserById($userId) {
        return $this->db->query("SELECT * FROM Users WHERE UserID = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemsByBusiness($businessName) {
        return $this->db->query("SELECT * FROM Item WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatsByBusiness($businessName) {
        return $this->db->query("SELECT * FROM businessstats WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
