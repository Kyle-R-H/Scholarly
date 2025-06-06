<?php
require_once 'Model/UserModel.php';
require_once 'Core/Database.php'; // If Database.php is used

class UserController extends Controller
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();

        if (!isset($_COOKIE['Login_Info']) || $this->userModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 0) {
            $_SESSION['error'] = "Insufficient Permissions";
            header("Location: ?controller=auth&action=loginView");
            exit();
        } else {
        }
    }

    public function profile()
    {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);
        require_once 'View/User/UserProfileView.php';
    }

    public function updateProfile()
    {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);

        // Check if userModel is set
        if (!$this->userModel) {
            die("Error: userModel is NULL! Check if it is being initialized correctly.");
        }

        $this->userModel->updateUserDetails(
            $user['Email'],
            empty($_POST['FirstName']) ? $user['FirstName'] : $_POST['FirstName'],
            empty($_POST['LastName']) ? $user['LastName'] : $_POST['LastName']
        );

        header("Location: ?controller=user&action=profile");
    }

    public function changePasswordView()
    {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);

        $this->view('User/UserChangePasswordView', ['user' => $user]);
    }

    public function changePassword()
    {
        // echo "In changePassword";

        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);

        $currentPasswordCorrect = password_verify($_POST['CurrentPassword'], $user['Password']);
        $newPassword = $_POST['NewPassword'];
        $confirmNewPassword = $_POST['ConfirmNewPassword'];

        if ($currentPasswordCorrect) {
            if ($newPassword == $confirmNewPassword) {
                // Check if userModel is set
                if (!$this->userModel) {
                    die("Error: userModel is NULL! Check if it is being initialized correctly.");
                }

                $this->userModel->updatePassword(
                    $user['Email'],
                    empty($_POST['NewPassword']) ? $user['Password'] : $_POST['NewPassword']
                );
            }
            // Passwords don't match
            header("Location: ?controller=user&action=changePasswordView");
        }
        // Current password incorrect
        header("Location: ?controller=user&action=changePasswordView");
    }

    public function settings()
    {
        require_once 'View/User/UserSettingsView.php';
    }

    public function restaurantView($all = null)
    {
        // If the "Show All Restaurants" button was clicked, $all will be 'true'
        if ($all === 'true') {
            // When showing all restaurants, we can set minRating to 0 or ignore the filter.
            $minRating = 0;
        } else {
            // Get minimum rating from POST; default is 0.
            $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;
        }

        // Get minimum rating from POST; default is 0
        $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;

        $restaurants = $this->userModel->getBusinessByTypeAndRating("restaurant", $minRating);


        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';

        // Filter restaurants based on the search query
        if (!empty($searchQuery)) {
            $restaurants = array_filter($restaurants, function ($restaurant) use ($searchQuery) {
                return stripos($restaurant['BusinessName'], $searchQuery) !== false;
            });
        }

        require_once 'View/User/RestaurantView.php';
    }

    public function eventsView($all = null)
    {
        // If the "Show All Restaurants" button was clicked, $all will be 'true'
        if ($all === 'true') {
            // When showing all restaurants, we can set minRating to 0 or ignore the filter.
            $minRating = 0;
        } else {
            // Get minimum rating from POST; default is 0.
            $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;
        }

        // Get minimum rating from POST; default is 0
        $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;

        $events = $this->userModel->getBusinessByTypeAndRating("event", $minRating);

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';

        // Filter restaurants based on the search query
        if (!empty($searchQuery)) {
            $events = array_filter($events, function ($events) use ($searchQuery) {
                return stripos($events['BusinessName'], $searchQuery) !== false;
            });
        }

        require_once 'View/User/EventsView.php';
    }

    public function servicesView($all = null)
    {
        // If the "Show All Restaurants" button was clicked, $all will be 'true'
        if ($all === 'true') {
            // When showing all restaurants, we can set minRating to 0 or ignore the filter.
            $minRating = 0;
        } else {
            // Get minimum rating from POST; default is 0.
            $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;
        }

        // Get minimum rating from POST; default is 0
        $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;

        $services = $this->userModel->getBusinessByTypeAndRating("service", $minRating);

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

        // Filter restaurants based on the search query
        if (!empty($searchQuery)) {
            $services = array_filter($services, function ($services) use ($searchQuery) {
                return stripos($services['BusinessName'], $searchQuery) !== false;
            });
        }

        require_once 'View/User/ServicesView.php';
    }

    public function activitiesView($all = null)
    {
        // If the "Show All Restaurants" button was clicked, $all will be 'true'
        if ($all === 'true') {
            // When showing all restaurants, we can set minRating to 0 or ignore the filter.
            $minRating = 0;
        } else {
            // Get minimum rating from POST; default is 0.
            $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;
        }

        // Get minimum rating from POST; default is 0
        $minRating = isset($_POST['minRating']) ? floatval($_POST['minRating']) : 0;

        $activities = $this->userModel->getBusinessByTypeAndRating("activity", $minRating);

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';


        // Filter restaurants based on the search query
        if (!empty($searchQuery)) {
            $activities = array_filter($activities, function ($activities) use ($searchQuery) {
                return stripos($activities['BusinessName'], $searchQuery) !== false;
            });
        }
        require_once 'View/User/ActivitiesView.php';
    }

    public function bookingView($businessName)
    {
        // Check if business is already set
        if (!isset($_SESSION['current_business']) || $_SESSION['current_business'] !== $businessName) {
            $_SESSION['cart'] = [];
            $_SESSION['current_business'] = $businessName;
        }

        // Generate a unique CSRF token to prevent duplicate submissions
        if (!isset($_SESSION['form_token'])) {
            $_SESSION['form_token'] = bin2hex(random_bytes(32));
        }

        // Handle Add to Cart Request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_name'])) {
            // Validate CSRF token
            if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
                die("Invalid form submission."); // TODO: Add error redirect
            }

            $itemName = $_POST['item_name'];
            $itemPrice = $_POST['item_price'];


            // Check if item is already in the cart
            if (isset($_SESSION['cart'][$itemName])) {
                $_SESSION['cart'][$itemName]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$itemName] = [
                    'name' => $itemName,
                    'price' => $itemPrice,
                    'quantity' => 1
                ];
            }

            // Regenerate token to prevent re-submission on refresh
            $_SESSION['form_token'] = bin2hex(random_bytes(32));

            // Redirect to the same page to clear POST data and prevent duplicate submissions
            header("Location: " . $_SERVER['HTTP_REFERER'] ?? "Location: ?controller=user&action=bookingView&businessName=" . urlencode($businessName));

            exit();
        }

        // Fetch items from db
        $items = $this->userModel->getItemsByBusiness($businessName);
        $business = $this->userModel->getBusinessByBusinessName($businessName);
        if ($businessName) {
            $this->view('User/BookingView', ['items' => $items, 'business' => $business]);
        } else {
            $_SESSION['error'] = "Could not find business";
            $this->view('User/BookingView', []);
            echo "Business not found.";
        }
    }

    public function orderConfirmView()
    {
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['item_name'], $_POST['quantity'])) {
                $itemName = $_POST['item_name'];
                $quantity = $_POST['quantity'];
            } elseif (isset($_POST['remove_item_name'])) {
                $removeItemName = $_POST['remove_item_name'];

                // Remove the item from the session
                foreach ($cartItems as $key => $item) {
                    if ($item['name'] === $removeItemName) {
                        unset($cartItems[$key]);
                        break;
                    }
                }
            }
            $_SESSION['cart'] = $cartItems;
        }

        // Calculate the total price
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }


        require_once 'View/User/OrderConfirmView.php';
    }

    public function reviewView()
    {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);
        if (!$user || $user['VerifiedCustomer'] != 1) {
            $_SESSION['error'] = "You must be a verified customer to view this page.";

            // Stops view redirect and keeps user on current view
            header("Location: " . $_SERVER['HTTP_REFERER'] ?? '?controller=user&action=sendMessagesView');
            exit();
        }

        $reviews = $this->userModel->getReviewByReviewID();

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';
        // Filter Reviews based on the search query
        if (!empty($searchQuery)) {
            $reviews = array_filter($reviews, function ($reviews) use ($searchQuery) {
                return stripos($reviews['BusinessName'], $searchQuery) !== false;
            });
        }
        require_once 'View/User/ReviewsView.php';
    }


    public function historyView()
    {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"])['UserID'];
        // print_r($user);
        $restaurant = $this->userModel->getBusinessStatsByType("Restaurant", $user);
        $services = $this->userModel->getBusinessStatsByType("Service", $user);
        $events = $this->userModel->getBusinessStatsByType("Event", $user);
        $activities = $this->userModel->getBusinessStatsByType("Activity", $user);

        require_once 'View/User/HistoryView.php';
    }


    public function placeOrder()
    {
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (!is_null($cartItems)) {
            $orderID = $this->userModel->getOrderID();
            foreach ($cartItems as $item) {
                $quantity = $item['quantity'];
                for ($i = 0; $i < $quantity; $i++) {
                    $itemName = $item['name'];
                    $price = $item['price'];
                    $businessName = $_SESSION['current_business'];
                    $userID = $this->userModel->getUserByEmail($_COOKIE["Login_Info"])['UserID'];
                    $this->userModel->placeOrder($businessName, $price, $userID, $orderID, $itemName);
                }
            }
            $_SESSION['success'] = "Order Placed!";
        } else {
            $_SESSION['error'] = "Cart is empty.";
        }
        header("Location: ?controller=user&action=restaurantView");
        exit();
    }

    public function addReviewView()
    {
        $businesses = $this->userModel->getBusinesses();
        // Fetch user details using the logged-in email from cookies
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);

        // Check if user exists
        if (!$user) {
            die("Error: User not found!");
        }
        require_once 'View/User/AddReviewView.php';
    }

    public function addDirectReviewView($businessName)
    {
        $businesses = $this->userModel->getBusinessByBusinessName($businessName);
        // Fetch user details using the logged-in email from cookies
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);

        // Check if user exists
        if (!$user) {
            $_SESSION['error'] = "Error: User not found!";
            die("Error: User not found!");
        }
        require_once 'View/User/AddReviewView.php';
    }

    public function addReview()
    {
        // Fetch user details
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);

        if (!$user) {
            die("Error: User not found.");
        }

        $userID = $user['UserID'];

        // Get form data
        $businessName = $_POST['business'] ?? 'EMPTY';
        $rating = $_POST['rating'] ?? 'EMPTY';
        $comment = $_POST['comment'] ?? 'EMPTY';
        $business = $this->userModel->getBusinessByBusinessName($businessName)[0]['UserID'];
        print_r($business);

        // Add review
        $this->userModel->createReview($userID, $business, $rating, $comment, $businessName);
        header("Location: ?controller=user&action=reviewView");
        exit();
    }

    public function userMessagesView()
    {
        $currentUser = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);
        $users = $this->userModel->getUsersByVerifiedCustomer(0); // 0 = normal verified user
        if ($currentUser['VerifiedCustomer'] == 1) {
            $users = $this->userModel->getAllNormalUsers();
        }
        $businessUsers = $this->userModel->getUsersByVerifiedCustomer(1); // business user

        // Get search query from Form POST
        $searchUserQuery = $_POST['searchUser'] ?? '';
        $searchBusinessQuery = $_POST['searchBusiness'] ?? '';

        // Filter Reviews based on the search query
        if (!empty($searchUserQuery)) {
            $users = array_filter($users, function ($users) use ($searchUserQuery) {
                return stripos($users['Email'], $searchUserQuery) !== false;
            });
        }

        if (!empty($searchBusinessQuery)) {
            $businessUsers = array_filter($businessUsers, function ($businessUsers) use ($searchBusinessQuery) {
                return stripos($businessUsers['Email'], $searchBusinessQuery) !== false;
            });
        }

        require_once 'View/User/UserMessagesView.php';
    }

    public function sendMessage()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $senderID = $this->userModel->getUserByEmail($_COOKIE['Login_Info'])['UserID'];
            $receiverID = $_POST['receiverID'];
            $message = trim($_POST['messageText']);

            if ($this->userModel->getUserById($receiverID)['PermissionLevel'] == 1) {
                $_SESSION['error'] = $this->userModel->createInquiry($senderID, $receiverID, $message);
                if ($_SESSION['error'] == null) {
                    $_SESSION['success'] = "Message sent successfully!";
                }
            } else {
                echo $senderID . $receiverID . $message;
                $this->userModel->createMessage($senderID, $receiverID, $message);
                $_SESSION['success'] = "Message sent successfully!";
            }
        } else {
            $_SESSION['error'] = "Message failed to send";
        }
        // Stops view redirect and keeps user on current view
        header("Location: " . $_SERVER['HTTP_REFERER'] ?? '?controller=user&action=sendMessagesView');
        exit();
    }

    public function sendMessageView($receiverID)
    {
        if ($this->userModel->getUserById($receiverID)['PermissionLevel'] == 0) {
            $isUser = true;
        } else {
            $isUser = false;
        }
        // Sender is the logged-in user
        $senderID = $this->userModel->getUserByEmail($_COOKIE['Login_Info'])['UserID'];
        $request = $this->userModel->getUserById($receiverID)['PermissionLevel'] == 1 && count($this->userModel->getAllInquiryMessages($senderID, $receiverID)) <= 1 ? true : false;
        if ($this->userModel->getUserById($receiverID)['PermissionLevel'] == 1) {
            $previousMessages = $this->userModel->getUserInquiries($senderID, $receiverID);
        } else {
            $previousMessages = $this->userModel->getUserMessages($senderID, $receiverID);
        }

        // Pass $previousMessages, $receiverID, etc. to the view
        require_once 'View/User/MessagingView.php';
    }

    public function sendReport()
    {
        $senderID = $this->userModel->getUserByEmail($_COOKIE['Login_Info'])['UserID'];
        $receiverID = $_POST['receiverID'] ?? null;
        $message = $_POST['reportMessage'] ?? null;

        $_SESSION['error'] = $this->userModel->sendReport($senderID, $receiverID, $message);
        if (!$_SESSION['error']) {
            $_SESSION['success'] = "Report sent Successfully";
        }
        
        // Stops view redirect and keeps user on current view
        header("Location: " . $_SERVER['HTTP_REFERER'] ?? '?controller=user&action=sendMessagesView');
        exit();
    }
}
