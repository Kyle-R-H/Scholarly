<?php
class AdminController extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = $this->model('AdminModel');

        if (!isset($_COOKIE['Login_Info']) || $this->adminModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 2) {
            $_SESSION['error'] ="Insufficient Permissions";
            // $this->view('Auth/LoginView', []);
            header("Location: ?controller=auth&action=loginView");
            exit();
        }
    }


    public function dashboard()
    {
        $orders = $this->adminModel->getAllOrders();
        $mostPopularItem = $this->adminModel->getMostPopularItem();
        $mostPopularBusiness = $this->adminModel->getMostPopularBusiness();
        $mostPopularDay = $this->adminModel->getMostPopularDay();
        $largestOrderByPrice = $this->adminModel->getLargestOrderByPrice();
        $largestOrderByItems = $this->adminModel->getLargestOrderByItems();
        $topCustomer = $this->adminModel->getTopCustomerByItems();

        $this->view(
            'Admin/AdminDashboardView',
            [
                'orders' => $orders,
                'mostPopularItem' => $mostPopularItem,
                'mostPopularBusiness' => $mostPopularBusiness,
                'mostPopularDay' => $mostPopularDay,
                'largestOrderByPrice' => $largestOrderByPrice,
                'largestOrderByItems' => $largestOrderByItems,
                'topCustomer' => $topCustomer
            ]
        );
    }

    public function adminManager()
    {
        $businesses = $this->adminModel->getBusinessesWithOwners();


        $this->view(
            'Admin/AdminManagerView',
            ['businesses' => $businesses]
        );
    }

    public function adminMessages(){
        $users = $this->adminModel->getUsersByVerifiedCustomer(0); // 0 = normal user
        $businessUsers = $this->adminModel->getUsersByVerifiedCustomer(1); // business user

        // Get search query from Form POST
        $searchUserQuery = $_POST['searchUser'] ?? '';
        $searchBusinessQuery = $_POST['searchBusiness'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

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

        require_once 'View/Admin/AdminMessagesView.php';
    }
        // Messages Funcitonality
        public function adminMessagesView($senderID)
        {
            $users = $this->adminModel->getUsersByVerifiedCustomer(0); // 0 = normal user
            $businessUsers = $this->adminModel->getUsersByVerifiedCustomer(1); // business user

            // Sender is the logged-in user
            $previousMessages = $this->adminModel->getAllUsersInquiries($senderID);
    
            // Get search query from Form POST
            $searchUserQuery = $_POST['searchUser'] ?? '';
            $searchBusinessQuery = $_POST['searchBusiness'] ?? '';
            // echo "<br> Search Q: "; print_r($searchQuery);
    
            // Filter Reviews based on the search query
            if (!empty($searchUserQuery)) {
                unset($_SESSION['success']);
                unset($_SESSION['error']);
                $users = array_filter($users, function ($users) use ($searchUserQuery) {
                    return stripos($users['Email'], $searchUserQuery) !== false;
                });
            }
            if (!empty($searchBusinessQuery)) {
                $businessUsers = array_filter($businessUsers, function ($businessUsers) use ($searchBusinessQuery) {
                    return stripos($businessUsers['Email'], $searchBusinessQuery) !== false;
                });
            }
    
            require_once 'View/Admin/AdminMessagesView.php';
        }

    public function reviews(){
        $reviews = $this->adminModel->getReviewByReviewID();

        $this->view('Admin/AdminReviewsView',['reviews' => $reviews]);
    }

    public function registerBusinessView()
    {
        $this->view('Admin/RegisterBusinessView', []);
    }

    public function registerBusiness()
    {
        $businesses = $this->adminModel->getBusinessesWithOwners();

        // Debugging input values
        $name = $_POST['RegisterName'] ?? 'EMPTY';
        $email = $_POST['RegisterEmail'] ?? 'EMPTY';
        $businessType = $_POST['RegisterBusinessType'] ?? 'EMPTY';
        $description = $_POST['RegisterDescription'] ?? 'EMPTY';
        $image = $_POST['RegisterImage'] ?? 'EMPTY';

        // Check if adminModel is set
        if (!$this->adminModel) {
            die("Error: adminModel is NULL! Check if it is being initialized correctly.");
        }

        // Fetch user from database
        $user = $this->adminModel->getUserByEmail($email);
        // echo "<br>Query executed, result: <pre>" . print_r($user, true) . "</pre>";

        if ($user) {
            $userID = $user['UserID'];
            // Check if name exists
            $_SESSION['error'] = $this->adminModel->getSimilarBusinessNames($name);

            if ($_SESSION['error'] == null) {
                // Successful registration
                $_SESSION['success'] = "Successful Business Registration";
                $this->adminModel->registerBusiness($userID, $name, $businessType, $description, $image);
                header("Location: ?controller=admin&action=adminManager");
                exit();
            } else {
                $this->view('Admin/RegisterBusinessView', []);
            }
        } else {
            // User not found
            $_SESSION['error'] = "User with that email does not exist.";
            $this->view('Admin/RegisterBusinessView', []);
        }
    }

    public function removeBusiness()
    {
        $businessName = $_POST['RemoveBusinessName'];
        
        $this->adminModel->removeBusiness($businessName);

        header("Location: ?controller=admin&action=adminManager");
    }

    public function removeMessage()
    {
        $senderID = $_POST['senderID'] ?? null;
        $receiverID = $_POST['receiverID'] ?? null;
        $timeSent = $_POST['timeSent'] ?? null;
    
        if (!$senderID || !$receiverID || !$timeSent) {
            $_SESSION['error'] = "Missing required parameters.SenderID:" . $senderID . "receiver:" . $receiverID . "timeSent: " . $timeSent;
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '?controller=admin&action=adminMessages'));
            exit();
        }
    
        $_SESSION['error'] = $this->adminModel->removeMessagesByConversation($senderID, $receiverID, $timeSent);
        
        if (!$_SESSION['error']) {
            $_SESSION['success'] = "Message Successfully Removed";
        }
    
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '?controller=admin&action=adminMessages'));
        exit();
    }
}
