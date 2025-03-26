<?php
require_once 'Model/UserModel.php';
require_once 'Core/Database.php'; // If Database.php is used

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        
        if (!isset($_COOKIE)){
            require_once "/";
        } else {
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

    public function restaurantView(){
        $restaurants = $this->userModel->getBusinesses("Restaurant");
        // print_r($restaurants);
        require_once 'View/User/RestaurantView.php';    
    }
    
    public function eventsView(){
        $events = $this->userModel->getBusinesses("Event");
        require_once 'View/User/EventsView.php';    
    }
    
    public function servicesView(){
        $services = $this->userModel->getBusinesses("Service");
        require_once 'View/User/ServicesView.php';    
    }
    
    public function activitiesView(){
        $activities = $this->userModel->getBusinesses("Activity");
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