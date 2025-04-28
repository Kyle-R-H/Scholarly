<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

class AdminModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Register new Business
    public function registerBusiness($userID, $businessName, $businessType, $description, $image)
    {
        // Add new business to Business table
        $this->db->query(
            "INSERT INTO Business (UserID, BusinessName, BusinessType, Rating, Description, Image) 
             SELECT ?, ?, ?, ?, ?, ?
             WHERE ? NOT IN (SELECT UserID FROM Business)"
            , [
                $userID, $businessName, $businessType, 0.0, $description, $image
                ,$userID
            ]
        );

        $this->db->query(
            "UPDATE Users SET PermissionLevel = ? WHERE UserID = ?",
            [1, $userID]
        );
        $this->updateVerifiedCustomer($userID);
        return $this->db->lastInsertId();
    }

    public function getSimilarBusinessNames($businessName)
    {
        $existingNames = $this->db->query(
            "SELECT BusinessName FROM BusinessStats WHERE BusinessName LIKE ?"
            , [$businessName])->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($existingNames)) {
            return "Business Name already exists";
        }
    }

    // Remove business
    public function removeBusiness($businessName)
    {
        // echo "In removeBusiness<br>";
        $this->db->query(
            "DELETE FROM Business
            WHERE BusinessName = ?"
            , [$businessName]
        );
    }

    // Ban business
    public function setBusinessBanStatus($businessName, $banStatus)
    {
        $this->db->query(
            "UPDATE Business
            SET BanStatus = ?
            WHERE BusinessName = ?"
            , [$banStatus, $businessName]
        );
    }


    // Ban user
    public function setUserBanStatus($userId, $banStatus)
    {
        $this->db->query(
            "UPDATE Users
            SET BanStatus = ?
            WHERE UserID = ?"
            , [$banStatus, $userId]
        );
    }

    // Remove user
    public function removeUser($userId)
    {
        $this->db->query(
            "DELETE FROM Users
            WHERE UserID = ?"
            , [$userId]
        );
    }

    // Main Data Methods 
    public function getBusinessesWithOwners()
    {
        $query = "SELECT 
                    Business.BusinessName
                    ,Business.BusinessType
                    ,Business.UserID
                    ,Business.Rating
                    ,Business.Description
                    ,Business.BanStatus
                    ,Users.Email
                  FROM Business 
                  JOIN Users ON Business.UserID = Users.UserID";

        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders()
    {
        $query = "SELECT 
                Order_ID, 
                UserID, 
                BusinessName, 
                SUM(OrderPrice) AS TotalPrice, 
                TimeOfOrder
                FROM BusinessStats
                GROUP BY Order_ID, UserID, BusinessName, TimeOfOrder
                ORDER BY TimeOfOrder DESC";

        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM Users";

        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Niche funky stats methods
    public function getMostPopularItem()
    {
        $query = "SELECT ItemName, COUNT(*) AS OrderCount
                  FROM BusinessStats
                  GROUP BY ItemName
                  ORDER BY OrderCount DESC
                  LIMIT 1";

        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
    }


    public function getMostPopularBusiness()
    {
        $query = "SELECT BusinessName, COUNT(*) AS OrderCount
                  FROM BusinessStats
                  GROUP BY BusinessName
                  ORDER BY OrderCount DESC
                  LIMIT 1";

        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function getMostPopularDay()
    {
        $query = "SELECT DATE(TimeOfOrder) AS OrderDate, COUNT(*) AS OrderCount
                  FROM BusinessStats
                  GROUP BY OrderDate
                  ORDER BY OrderCount DESC
                  LIMIT 1";

        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function getLargestOrderByPrice()
    {
        $query = "SELECT Order_ID, BusinessName, SUM(OrderPrice) AS TotalOrderValue
                  FROM BusinessStats
                  GROUP BY Order_ID, BusinessName
                  ORDER BY TotalOrderValue DESC
                  LIMIT 1";

        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function getLargestOrderByItems()
    {
        $query = "SELECT Order_ID, COUNT(ItemName) AS TotalItems
                  FROM BusinessStats
                  GROUP BY Order_ID
                  ORDER BY TotalItems DESC
                  LIMIT 1";

        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopCustomerByItems()
    {
        $query = "SELECT UserID, COUNT(ItemName) AS TotalItemsBought
                  FROM BusinessStats
                  GROUP BY UserID
                  ORDER BY TotalItemsBought DESC
                  LIMIT 1";

        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsersInquiries($senderID)
    {
        $query = "SELECT 
                    `Sender`,`Receiver`, 
                    `Message`, 
                    `TimeSent`
                FROM Inquiries
                WHERE `Sender` = ?

                UNION ALL

                SELECT 
                    `Sender`, 
                    `Receiver`, 
                    `Message`, 
                    `TimeSent`
                FROM Messages
                WHERE `Sender` = ?";
        return $this->db->query($query, [$senderID, $senderID])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeMessagesByConversation($senderID, $receiverID, $timeSent)
    {
        if ($this->getUserByID($receiverID)['PermissionLevel'] == 1 || $this->getUserByID($senderID)['PermissionLevel'] == 1) {
            $table = "Inquiries";
        } else {
            $table = "Messages";
        }

        $query = "DELETE FROM $table
            WHERE (Sender = ? AND Receiver = ? AND TimeSent = ?)";
        //print_r($query);
        $this->db->query(
            $query,
            [$senderID, $receiverID, $timeSent]
        );

    }

    public function removeReviewByReviewID($createdAt, $businessName, $comment)
    {   $review = $this->db->query(
        "SELECT ReviewID FROM Review
     WHERE CreatedAt = ? AND BusinessName = ? AND Comment = ?",
        [$createdAt, $businessName, $comment]
    )->fetch();


        if ($review) {
            $this->db->query(
                "DELETE FROM Review WHERE ReviewID = ?",
                [$review['ReviewID']]
            );
        }
    }

    public function getAllReports()
    {
        $query = "SELECT * FROM Reports";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
