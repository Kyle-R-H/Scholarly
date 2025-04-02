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

    public function getReviewByReviewID($ReviewID)
    {
        return $this->db->query("SELECT * FROM Review WHERE ReviewID = ?", [$ReviewID])->fetchAll(PDO::FETCH_ASSOC);
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

    public function getOrderID()
    {
        $maxOrderID = $this->db->query("SELECT MAX(Order_ID) FROM BusinessStats")->fetch(PDO::FETCH_ASSOC);
        return $maxOrderID["MAX(Order_ID)"] + 1;
    }

    public function placeOrder($businessName, $price, $userID, $orderID, $itemName)
    {
        $itemID = $this->db->query("SELECT MAX(ItemID) FROM BusinessStats ", [])->fetch(PDO::FETCH_ASSOC);
        $this->db->query(
            "INSERT INTO BusinessStats (BusinessName, OrderPrice, TimeOfOrder, UserID, OrderStatus, Order_ID,ItemName,ItemID) VALUES (?, ?, ?, ?, ?, ?, ?,?)",
            [$businessName, $price,date("Y-m-d H:i:s")  , $userID, "Pending", $orderID, $itemName,$itemID["MAX(ItemID)"] + 1]
        );
        return $this->db->lastInsertId();
    }
}

