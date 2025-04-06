<?php
class BusinessController extends Controller
{
    private $businessModel;
    private $businessType;
    private $businessName;

    public function __construct()
    {
        $this->businessModel = $this->model('BusinessModel');

        if (!isset($_COOKIE['Login_Info']) || $this->businessModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 1) {
            $_SESSION['error'] = "Insufficient Permissions";
            // $this->view('Auth/LoginView', []);
            header("Location: ?controller=auth&action=loginView");
            exit();
        } else {
            // Get user table
            $user = $this->businessModel->getUserByEmail($_COOKIE['Login_Info']);

            // Get business table from userID
            $business = $this->businessModel->getBusinessByUserID($user['UserID']);

            $this->businessType = $business['BusinessType'];
            $this->businessName = $business['BusinessName'];
        }
    }


    public function dashboard()
    {
        $stats = $this->businessModel->getStatsByBusiness($this->businessName);
        $completedStats = $this->businessModel->getStatsByBusinessAndStatus($this->businessName, "Completed");
        $pendingStats = $this->businessModel->getStatsByBusinessAndStatus($this->businessName, "Pending");
        $this->view('Business/BusinessDashboardView', ['businessType' => $this->businessType, 'businessName' => $this->businessName, 'completedStats' => $completedStats, 'pendingStats' => $pendingStats, 'stats' => $stats]);
    }

    public function businessManager()
    {
        $items = $this->businessModel->getItemsByBusiness($this->businessName);
        $this->view('Business/BusinessItemManagerView', ['businessType' => $this->businessType, 'businessName' => $this->businessName, 'items' => $items]);
    }


    public function profile()
    {
        $business = $this->businessModel->getBusinessByEmail($_COOKIE["Login_Info"]);
        $this->view('Business/BusinessProfileView', ['businessType' => $this->businessType, 'businessName' => $this->businessName, 'business' => $business]);
    }

    public function addItemView()
    {
        $this->view('Business/AddItemView', ['businessType' => $this->businessType, 'businessName' => $this->businessName]);
    }

    public function responseToReview()
    {
        $reviews = $this->businessModel->getReviewByReviewID();

        $this->view('Business/ReviewResponseView', [
            'businessType' => $this->businessType,
            'businessName' => $this->businessName,
            'reviews' => $reviews
        ]);
    }

    public function addItem()
    {
        // Debugging input values
        $name = $_POST['ItemName'] ?? 'EMPTY';
        $description = $_POST['ItemDescription'] ?? 'EMPTY';
        $price = number_format((float)$_POST['ItemPrice'], 2, '.', '');

        // Check if businessModel is set
        if (!$this->businessModel) {
            die("Error: businessModel is NULL! Check if it is being initialized correctly.");
        }

        // Check if name exists
        $_SESSION['error'] = $this->businessModel->getSimilarItemNames($name);

        if ($_SESSION['error'] == null) {
            // Successful
            $_SESSION['success'] = "Item Added Successfully";
            $this->businessModel->addItem($this->businessName, $description, $price, $name);
            header("Location: ?controller=business&action=businessManager");
            exit();
        } else {
            $this->view('Business/AddItemView', []);
        }
        $this->view('Business/AddItemView', ['businessType' => $this->businessType, 'businessName' => $this->businessName]);
    }

    public function saveResponse()
    {
        // Get data from POST request
        $reviewID = $_POST['reviewID'] ?? null;
        $response = $_POST['response'] ?? '';

        // Validate input
        if (!$reviewID || empty(trim($response))) {
            die("Invalid input data.");
        }

        // Sanitize input
        $response = htmlspecialchars(trim($response));

        // Update the database
        $success = $this->businessModel->setResponseByReviewID($response, $reviewID);

        // Redirect back to the page (to avoid resubmission on refresh)
        if ($success) {
            header("Location: ?controller=business&action=responseToReview");
            exit;
        } else {
            die("Failed to save response.");
        }
    }


    public function businessMessages()
    {
        $users = $this->businessModel->getUsersByVerifiedCustomer(0); // 0 = normal user
        // $businessUsers = $this->businessModel->getUsersByVerifiedCustomer(1); // 1 = business user

        // Get search query from Form POST
        $searchUserQuery = $_POST['searchUser'] ?? '';
        // $searchBusinessQuery = $_POST['searchBusiness'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

        // Filter Reviews based on the search query
        if (!empty($searchUserQuery)) {
            $users = array_filter($users, function ($users) use ($searchUserQuery) {
                return stripos($users['Email'], $searchUserQuery) !== false;
            });
        }

        // if (!empty($searchBusinessQuery)) {
        //     $businessUsers = array_filter($businessUsers, function ($businessUsers) use ($searchBusinessQuery) {
        //         return stripos($businessUsers['Email'], $searchBusinessQuery) !== false;
        //     });
        // }

        require_once 'View/Business/BusinessMessagesView.php';
    }


    // Messages Funcitonality
    public function businessMessagesView($receiverID)
    {
        $users = $this->businessModel->getUsersByVerifiedCustomer(0); // 0 = normal user

        // Sender is the logged-in user
        $senderID = $this->businessModel->getUserByEmail($_COOKIE['Login_Info'])['UserID'];
        $previousMessages = $this->businessModel->getUserInquiries($senderID, $receiverID);

        // Get search query from Form POST
        $searchUserQuery = $_POST['searchUser'] ?? '';
        // $searchBusinessQuery = $_POST['searchBusiness'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

        // Filter Reviews based on the search query
        if (!empty($searchUserQuery)) {
            unset($_SESSION['success']);
            unset($_SESSION['error']);
            $users = array_filter($users, function ($users) use ($searchUserQuery) {
                return stripos($users['Email'], $searchUserQuery) !== false;
            });
        }

        require_once 'View/Business/BusinessMessagesView.php';
    }

    public function sendMessage()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageText']) && !empty($_POST['messageText'])) {
            $senderID = $this->businessModel->getUserByEmail($_COOKIE['Login_Info'])['UserID'];
            $receiverID = $_POST['receiverID'];
            $message = trim($_POST['messageText']);

            $this->businessModel->createInquiry($senderID, $receiverID, $message);
            $_SESSION['success'] = "Message sent successfully!";
        } else {
            $_SESSION['error'] = "Message failed to send";
        }
        // Stops view redirect and keeps user on current view
        header("Location: " . $_SERVER['HTTP_REFERER'] ?? '?controller=user&action=sendMessagesView');
        exit();
    }

    public function updateOrderPrice()
    {
        // Get data from POST request
        $userID = $_POST['userID'] ?? null;
        $orderPrice = $_POST['orderPrice'] ?? null;

        // Validate input
        if (!$userID || !$orderPrice || !is_numeric($orderPrice)) {
            die("Invalid input data.");
        }

        // Update the database
        $success = $this->businessModel->updateOrderPriceByUserID($userID, $orderPrice);

        // Redirect back to the dashboard
        if ($success) {
            $_SESSION['success'] = "Order price updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update order price.";
        }
        header("Location: ?controller=business&action=dashboard");
        exit;
    }

    public function removeItem()
    {
        $itemName = $_POST['RemoveItemName'];

        $this->businessModel->removeItem($itemName);

        header("Location: ?controller=business&action=businessManager");
    }

    public function deleteMessages()
    {
        $senderID = $this->businessModel->getUserByEmail($_COOKIE['Login_Info'])['UserID'];
        $receiverID = $_POST['receiverID'] ?? null;
    
        if (!$senderID || !$receiverID) {
            $_SESSION['error'] = "Missing required parameters.SenderID: " . $senderID . "receiver: " . $receiverID;
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '?controller=user&action=sendMessagesView'));
            exit();
        }
    
        $_SESSION['error'] = $this->businessModel->removeMessagesByConversation($senderID, $receiverID);
        
        if (!$_SESSION['error']) {
            $_SESSION['success'] = "Conversation Successfully Cleared";
        }
    
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '?controller=user&action=sendMessagesView'));
        exit();
    }
    
}
