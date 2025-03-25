<?php
require_once 'Model/UserModel.php';
require_once 'Core/Database.php'; // If Database.php is used

class UserController {
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
        require_once 'View/User/EventsView.php';    
    }

    public function servicesView(){
        require_once 'View/User/ServicesView.php';    
    }
    
    public function activitiesView(){
        require_once 'View/User/ActivitiesView.php';    
    }

}
?>