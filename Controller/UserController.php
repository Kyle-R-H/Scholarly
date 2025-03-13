<?php
require_once 'Model/UserModel.php';
require_once 'Core/Database.php'; // If Database.php is used

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function profile($id) {
        $user = $this->userModel->getUserById($id);
        require_once 'View/User/UserProfileView.php';
    }

    public function settings(){
        require_once 'View/User/UserSettingsView.php';
    }

    public function restaurantView(){
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