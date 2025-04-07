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

    public function updateUserDetails($email, $firstName, $lastName)
    {
        $this->db->query(
            "UPDATE Users

            SET
                FirstName = ?
                ,LastName = ?

            WHERE
                Email = ?"
            ,[$firstName, $lastName, $email]
        );
    }

    public function updatePassword($email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "UPDATE Users

            SET
                Password = ?

            WHERE
                Email = ?"
            ,[$hashedPassword, $email]
        );
    }

    public function getBusinessByType($businessType)
    {
        return $this->db->query("SELECT * FROM Business Where BusinessType = ? ORDER BY Rating DESC", [$businessType])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusinessStatsByType($businessType, $userID)
    {
        $query = "SELECT BusinessStats.*, Business.BusinessType
        FROM BusinessStats
        JOIN Business 
        ON BusinessStats.BusinessName = Business.BusinessName
        WHERE Business.BusinessType = ? AND BusinessStats.UserID = ?";

        return $this->db->query($query, [$businessType, $userID])->fetchAll(PDO::FETCH_ASSOC);
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
            [$businessName, $price, date("Y-m-d H:i:s"), $userID, "Pending", $orderID, $itemName, $itemID["MAX(ItemID)"] + 1]
        );
        $this->updateVerifiedCustomer($userID);
        return $this->db->lastInsertId();
    }

    public function createReview($userID, $business, $rating, $comment, $businessName)
    {
        $maxReviewID = $this->db->query("SELECT MAX(ReviewID) FROM Review")->fetch(PDO::FETCH_ASSOC);
        print_r($maxReviewID);
        $query = "INSERT INTO Review (ReviewID, UserID, Business, Rating, Comment, Response, CreatedAt, BusinessName) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        // Use your database query method with parameter binding
        return $this->db->query($query, [$maxReviewID["MAX(ReviewID)"] + 1, $userID, $business, $rating, $comment, "", date("Y-m-d H:i:s"), $businessName]);
    }


    public function getBusinesses()
    {
        return $this->db->query("SELECT BusinessName FROM Business", [])->fetchAll(PDO::FETCH_ASSOC);
    }



    public function storeInquiry($senderID, $receiverID, $message)
    {
        $maxInquiryID = $this->db->query("SELECT MAX(InquiriesID) AS maxID FROM Inquiries")->fetch(PDO::FETCH_ASSOC);
        if ($maxInquiryID == null) {
            $maxInquiryID = 1;
        }
        $query = "INSERT INTO Inquiries (InquiriesID, Sender, Receiver, Message, TimeSent, Pending) VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->query($query, [$maxInquiryID["maxID"] + 1, $senderID, $receiverID, $message, date("Y-m-d H:i:s"), 1]);
    }

    public function getUserMessages($senderID, $receiverID,)
    {
      //  echo "sender: " . $senderID;
     // echo " <br> receiver: " . $receiverID;
        $query = "SELECT * FROM Messages 
                WHERE (Sender = ? AND Receiver = ?) 
                ORDER BY TimeSent ASC";

        return $this->db->query($query, [$senderID, $receiverID])-> fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusinessByTypeAndRating($businessType, $minRating) {
        $query = "SELECT *, IFNULL(Rating, 0) AS effectiveRating 
                  FROM Business 
                  WHERE BusinessType = ? 
                    AND (IFNULL(Rating, 0) >= ? OR Rating IS NULL)
                  ORDER BY IFNULL(Rating, 0) DESC";
        return $this->db->query($query, [$businessType, $minRating])->fetchAll(PDO::FETCH_ASSOC);
    }

}
