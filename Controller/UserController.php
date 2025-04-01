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
            $error = "Insufficient Permissions";
            $this->view('Auth/LoginView', isset($error) ? ['error' => $error] : []);
        } else {
            // print_r($_COOKIE);
        }
    }

    public function profile()
    {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);
        // print_r($user);
        require_once 'View/User/UserProfileView.php';
    }

    public function settings()
    {
        require_once 'View/User/UserSettingsView.php';
    }

    public function restaurantView()
    {
        // Fetch all restaurants from the database
        $restaurants = $this->userModel->getBusinessByType("Restaurant");
        // print_r($restaurants);

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

        // Filter restaurants based on the search query
        if (!empty($searchQuery)) {
            $restaurants = array_filter($restaurants, function ($restaurant) use ($searchQuery) {
                return stripos($restaurant['BusinessName'], $searchQuery) !== false;
            });
        }

        require_once 'View/User/RestaurantView.php';
    }

    public function eventsView()
    {
        $events = $this->userModel->getBusinessByType("Event");

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

        // Filter restaurants based on the search query
        if (!empty($searchQuery)) {
            $events = array_filter($events, function ($events) use ($searchQuery) {
                return stripos($events['BusinessName'], $searchQuery) !== false;
            });
        }

        require_once 'View/User/EventsView.php';
    }

    public function servicesView()
    {
        $services = $this->userModel->getBusinessByType("Service");

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

    public function activitiesView()
    {
        $activities = $this->userModel->getBusinessByType("Activity");

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

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
        // echo "Booking page for: " . htmlspecialchars($businessName);

        // Fetch items from db
        $items = $this->userModel->getItemsByBusiness($businessName);
        $business = $this->userModel->getBusinessByBusinessName($businessName);
        // echo "<br>Items:<br>";
        // print_r($items);  

        if ($businessName) {
            $this->view('User/BookingView', ['items' => $items, 'business' => $business]);
        } else {
            echo "Business not found.";
        }
        // $this->view('User/BookingView', isset($error) ? ['error' => $error] : []);
    }


    public function basketView()
    {
        require_once 'View/User/BasketView.php';
    }

    public function reviewView()
    {
        $reviews = $this->userModel->getReviewByReviewID();

        // Get search query from Form POST
        $searchQuery = $_POST['search'] ?? '';
        // echo "<br> Search Q: "; print_r($searchQuery);

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
}
