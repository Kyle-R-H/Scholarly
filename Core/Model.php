<?php
require_once 'Core/Database.php';

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->updateAverageRatingByBusiness();
    }

    // Fetch user by email
    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM Users WHERE Email = ?";

        $stmt = $this->db->query($query, [$email]); // Call query() method

        if (!$stmt) return null;

        $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userEmail) return null;

        return $userEmail;
    }

    // Fetch user by ID
    public function getUserById($userId)
    {
        return $this->db->query("SELECT * FROM Users WHERE UserID = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemsByBusiness($businessName)
    {
        return $this->db->query("SELECT * FROM Item WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatsByBusiness($businessName)
    {
        return $this->db->query("SELECT * FROM BusinessStats WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatsByBusinessAndStatus($businessName, $orderStatus)
    {
        return $this->db->query("SELECT * FROM BusinessStats WHERE BusinessName = ? AND OrderStatus = ?", [$businessName, $orderStatus])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewByReviewID()
    {
        $query = "SELECT 
                Review.ReviewID, 
                Review.UserID, 
                Users.FirstName, 
                Users.LastName,
                Review.BusinessName,
                Business.Image, 
                Review.Rating, 
                Review.Comment, 
                Review.Response, 
                Review.CreatedAt
              FROM Review
              LEFT JOIN Business 
                ON Review.Business = Business.UserID
              LEFT JOIN Users
                ON Review.UserID = Users.UserID";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusinesses()
    {
        return $this->db->query("SELECT BusinessName FROM Business", [])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAverageRatingByBusiness()
    {
        $businesses = $this->getBusinesses();
        foreach ($businesses as $business) {
            $businessName = $business['BusinessName'];
            // Calculate the average rating
            $query = "SELECT AVG(Rating) as averageRating FROM Review WHERE BusinessName = ?";
            $result = $this->db->query($query, [$businessName])->fetch(PDO::FETCH_ASSOC);

            $averageRating = $result ? $result['averageRating'] : null;

            if ($averageRating !== null) {
                // Update the Rating column in the Business table
                $updateQuery = "UPDATE Business SET Rating = ? WHERE BusinessName = ?";
                $this->db->query($updateQuery, [$averageRating, $businessName]);
            } else {
                $averageRating = 0;
            }
            $this->updateBusinessRatingByBusiness($businessName, $averageRating);
        }
    }

    public function updateBusinessRatingByBusiness($businessName, $averageRating)
    {
        $updateQuery = "UPDATE Business SET Rating = ? WHERE BusinessName = ?";
        $this->db->query($updateQuery, [$averageRating, $businessName]);
    }

    public function updateVerifiedCustomer($userID)
    {
        $this->db->query(
            "UPDATE Users SET VerifiedCustomer = ? WHERE UserID = ?",
            [1, $userID]
        );
    }


    public function getUsersByVerifiedCustomer($permissionLevel)
    {
        return $this->db->query(
            "
        SELECT Users.*, Business.BusinessName 
        FROM Users 
        LEFT JOIN Business ON Users.UserID = Business.UserID 
        WHERE Users.VerifiedCustomer = '1' 
        AND Users.PermissionLevel = ? 
        AND Users.BanStatus = 0",

            [$permissionLevel]
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserMessages($senderID, $receiverID)
    {
        // echo "sender: " . $senderID;
        // echo " <br> receiver: " . $receiverID;
        $query = "SELECT * FROM Messages 
                WHERE (Sender = ? AND Receiver = ?) 
                OR (Sender = ? AND Receiver = ?) 
                ORDER BY TimeSent ASC";

        return $this->db->query($query, [$senderID, $receiverID, $receiverID, $senderID])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserInquiries($senderID, $receiverID)
    {
        // echo "sender: " . $senderID;
        // echo " <br> receiver: " . $receiverID;
        $query = "SELECT * FROM Inquiries 
                WHERE (Sender = ? AND Receiver = ?) 
                OR (Sender = ? AND Receiver = ?) 
                ORDER BY TimeSent ASC";

        return $this->db->query($query, [$senderID, $receiverID, $receiverID, $senderID])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createMessage($senderID, $receiverID, $message)
    {
        // check what user recieiver is

        // if business account use inquiry method (shouldn't be allowed)

        // echo "Sender: " . $senderID . "<br>Reciever: " . $receiverID;
        $maxMessageID = $this->db->query("SELECT MAX(MessageID) AS maxID FROM Messages")->fetch(PDO::FETCH_ASSOC);
        if ($maxMessageID == null) {
            $maxMessageID = 1;
        }
        $query = "INSERT INTO Messages (MessageID, Sender, Receiver, Message, TimeSent) VALUES (?, ?, ?, ?, ?)";
        return $this->db->query($query, [$maxMessageID["maxID"] + 1, $senderID, $receiverID, $message, date("Y-m-d H:i:s")]);
    }

    public function createInquiry($senderID, $receiverID, $message)
    {
        // Init pending to invalid number
        $pending = -1; // shouldnt be -1 ever

        // Set new InquiriesID + 1
        $maxID = $this->db->query("SELECT MAX(InquiriesID) AS maxID FROM Inquiries")->fetch(PDO::FETCH_ASSOC);
        if ($maxID == null) {
            $maxID = 1;
        }

        /* Get Pending Value for inquiry
        1 == Pending;
        0 == Accepted;
        */

        // get all the messages
        $allMessages = $this->getAllInquiryMessages($senderID, $receiverID);

        //? Check if current user is business or user
        if ($this->getUserById($senderID)['PermissionLevel'] == 1) { // if current user is a 1 / business
            //* Current User ($senderID) is a business
            //^ Business Users dont need to wait on Users
            $pending = 0;
        } else { // if the current user is 0 /  user
            //* Current User ($senderID) is a user

            //? Check the count of messages
            if (count($allMessages) > 1) {
                //^ not pending, has messaged before
                $pending = 0;
            } else if (count($allMessages) == 1) {
                //^ Request already sent 
                //!user must wait, disable message button
                return "Please wait for request response.";
            } else {
                // count < 1 aka. 0
                //^ Message is an inquiry request
                $pending = 1; // sends a request to business
                //! Disables Message Button
            }
        }


        $query = "INSERT INTO Inquiries (InquiriesID, Sender, Receiver, Message, TimeSent, Pending) VALUES (?, ?, ?, ?, ?, ?)";
        $this->db->query($query, [$maxID["maxID"] + 1, $senderID, $receiverID, $message, date("Y-m-d H:i:s"), $pending]);
    }

    public function getAllInquiryMessages($senderID, $receiverID)
    {
        $query = "SELECT Message FROM Inquiries 
                  WHERE (Sender = ? AND Receiver = ?)
                  OR (Sender = ? AND Receiver = ?)";
        return $this->db->query($query, [$senderID, $receiverID, $receiverID, $senderID])->fetchAll(PDO::FETCH_ASSOC);
    }


    public function sendReport($senderID, $receiverID, $message) {
        $maxID = $this->db->query("SELECT MAX(ReportID) AS maxID FROM Reports")->fetch(PDO::FETCH_ASSOC);
        if ($maxID == null) {
            $maxID = 1;
        }

        $query = "INSERT INTO Reports (ReportID, Sender, Receiver, Message, TimeSent) VALUES (?, ?, ?, ?, ?)";
        $this->db->query($query, [$maxID["maxID"] + 1, $senderID, $receiverID ,$message, date("Y-m-d H:i:s")]);
    }
}
