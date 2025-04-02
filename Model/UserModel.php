<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

class UserModel extends Model
{
    public function __construct()
    {
        // Construct from Core/Model
        parent::__construct();
    }

    public function getBusinessByBusinessName($businessName)
    {
        return $this->db->query("SELECT * FROM Business WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getReviewByReviewID()
{
    $query = "SELECT 
                Review.ReviewID, 
                Review.UserID, 
                Business.BusinessName,
                Business.Image, 
                Review.Rating, 
                Review.Comment, 
                Review.Response, 
                Review.CreatedAt
              FROM Review
              LEFT JOIN Business 
                ON Review.Business = Business.UserID";
    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}


    public function registerUser($firstName, $lastName, $email, $password)
    {
        // Generate UserID, max ID in user table + 1
        $maxUserID = $this->db->query("SELECT MAX(UserID) FROM Users")->fetch(PDO::FETCH_ASSOC);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "INSERT INTO Users (UserID, Email, Password, PermissionLevel, VerifiedCustomer, FirstName, LastName) VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$maxUserID["MAX(UserID)"] + 1, $email, $hashedPassword, 0, 0, $firstName, $lastName]
        );

        return $this->db->lastInsertId();
    }

    public function getBusinessByType($businessType)
    {
        return $this->db->query("SELECT * FROM Business Where BusinessType = ?", [$businessType])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusinessStatsByType($businessType, $userID)
    {
        $query = "SELECT BusinessStats.*, Business.BusinessType
        FROM BusinessStats
        JOIN Business 
        ON BusinessStats.BusinessName = Business.BusinessName
        WHERE Business.BusinessType = ? AND BusinessStats.UserID = ?";

        return $this->db->query($query,[$businessType, $userID])->fetchAll(PDO::FETCH_ASSOC);
    }
}
