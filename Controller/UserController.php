<?php
require_once 'Model/UserModel.php';
require_once 'Core/Database.php'; // If Database.php is used

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        
        if (!isset($_COOKIE['Login_Info']) || $this->userModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 0){
            require_once "View/Auth/LoginView.php";
        } 
        else {
            print_r($_COOKIE);
        }

    }

    public function profile() {
        $user = $this->userModel->getUserByEmail($_COOKIE["Login_Info"]);
        // print_r($user);
        require_once 'View/User/UserProfileView.php';
    }

    public function settings(){
        require_once 'View/User/UserSettingsView.php';
    }

    public function restaurantView() {
        // Fetch all restaurants from the database
        $restaurants = $this->userModel->getBusinesses("Restaurant");
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
    
    public function eventsView(){
        $events = $this->userModel->getBusinesses("Event");

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
    
    public function servicesView(){
        $services = $this->userModel->getBusinesses("Service");

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
    
    public function activitiesView(){
        $activities = $this->userModel->getBusinesses("Activity");

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
        // echo "<br>Items:<br>";
        // print_r($items);  

        if ($businessName) {
            $this->view('User/BookingView', ['items' => $items]);
        } else {
            echo "Business not found.";
        }
        // $this->view('User/BookingView', isset($error) ? ['error' => $error] : []);
    }

}
?>