<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

class BusinessModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getBusinessByUserID($userId)
    {
        return $this->db->query("SELECT * FROM Business WHERE UserId = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    public function getBusinessByEmail($email)
    {
        // echo "In getBusinessByEmail<br>";
        $userID = $this->db->query("SELECT UserId FROM Users WHERE Email = ?", [$email])->fetch(PDO::FETCH_ASSOC);
        // echo $userID['UserId'];
        return $this->getBusinessByUserID($userID['UserId']);
    }

    public function getStatsByBusiness($businessName)
    {
        return $this->db->query("SELECT * FROM BusinessStats WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderPriceByUserID($userID, $orderPrice)
    {
        return $this->db->query(
            "UPDATE BusinessStats 
SET OrderPrice = ?, OrderStatus = 'Completed' 
WHERE UserID = ? AND OrderStatus = 'Pending';",
            [$orderPrice, $userID]
        );
    }

    public function getSimilarItemNames($itemName)
    {
        $existingNames = $this->db->query(
            "SELECT ItemName FROM Item WHERE ItemName LIKE ?",
            [$itemName]
        )->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($existingNames)) {
            return "Business Name already exists";
        }
    }

    // Register new Item
    public function addItem($businessName, $description, $price, $itemName)
    {
        // Add new item to Item table
        $this->db->query(
            "INSERT INTO Item (BusinessName, Description, ItemPrice, ItemName) 
                VALUES (?, ?, ?, ?)",
            [$businessName, $description, $price, $itemName]
        );

        return $this->db->lastInsertId();
    }

    public function removeItem($itemName)
    {
        $this->db->query(
            "DELETE FROM Item
            WHERE ItemName = ?",
            [$itemName]
        );
    }

    public function setResponseByReviewID($response, $reviewID)
    {
        $query = "UPDATE Review SET Response = ? WHERE ReviewID = ?";
        return $this->db->query($query, [$response, $reviewID]);
    }

    public function updatePassword($email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "UPDATE
                Users

            SET
                Password = ?

            WHERE
                Email = ?"
            ,[$hashedPassword, $email]
        );
    }

    public function updateBusinessDetails($userId, $description, $image, $contactInfo)
    {
        $this->db->query(
            "UPDATE
                Business
            
            SET
                Description = ?
                ,Image = ?
                ,ContactInfo = ?
            
            WHERE
                UserID = ?"
            ,[$description, $image, $contactInfo, $userId]
        );
    }
}
