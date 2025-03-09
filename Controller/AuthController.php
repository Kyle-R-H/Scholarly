<?php
require_once 'Core/Controller.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');

        // To hash passwords, use inspect element to get hashed password
        // $hashedPassword = password_hash('enter_password', PASSWORD_DEFAULT);
        // echo $hashedPassword;
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Get user data from database
            $user = $this->userModel->getUserByEmail($email);
    
            if ($user && password_verify($password, $user['password'])) {
                // Store user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
    
                // Redirect to dashboard
                header("Location: ?controller=User&action=restaurantView");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        }
    
        // Show login view (for both GET requests and failed login attempts)
        $this->view('Auth/loginView', isset($error) ? ['error' => $error] : []);
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}
?>
