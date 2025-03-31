<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

class UserModel extends Model {
    // private $db;

    public function __construct() {
        parent::__construct();
        // $this->db = new Database();
    }

    // Fetch user by ID
    public function getUserById($userId) {
        return $this->db->query("SELECT * FROM Users WHERE UserID = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemsByBusiness($businessName) {
        return $this->db->query("SELECT * FROM Item WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusinessByBusinessName($businessName) {
        return $this->db->query("SELECT * FROM Business WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewByReviewID($ReviewID) {
        return $this->db->query("SELECT * FROM Review WHERE ReviewID = ?", [$ReviewID])->fetchAll(PDO::FETCH_ASSOC);
    }


    public function registerUser($firstName, $lastName, $email, $password) {
        // Generate UserID, max ID in user table + 1
        $maxUserID = $this->db->query("SELECT MAX(UserID) FROM Users")->fetch(PDO::FETCH_ASSOC);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "INSERT INTO Users (UserID, Email, Password, PermissionLevel, VerifiedCustomer, FirstName, LastName) VALUES (?, ?, ?, ?, ?, ?, ?)"
            ,[$maxUserID["MAX(UserID)"] + 1, $email, $hashedPassword, 0, 0, $firstName, $lastName]
        );

        return $this->db->lastInsertId();
    }

    // General method to fetch all businessTypes
    public function getBusinesses($businessType) {
        return $this->db->query("SELECT * FROM Business Where BusinessType = ?", [$businessType])->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getItems($businessName){
        return $this->db->query("SELECT * FROM Item Where BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
