<?php
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Core/Database.php'; // If Database.php is used
session_start();

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function profile($id) {
        $user = $this->userModel->getUserById($id);
        require_once '../View/User/UserProfileView.php';
    }

    public function restaurantView(){
        // if (!isset($_SESSION['user_id'])) {
        //     header("Location: ?controller=Auth&action=loginView");
        //     exit();
        // }
        ob_start();
        echo "Entering RestaurantView";
        ob_end_clean();
        require_once 'View/User/RestaurantView.php';    }

}
?>