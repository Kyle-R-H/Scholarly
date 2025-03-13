<?php

if (!file_exists('Core/Controller.php')) {
    die("Error: Core/Controller.php not found! Check the file path.");
}
require_once 'Core/Controller.php';
// echo "Core/Controller.php loaded successfully.<br>";

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        // echo "<br> AuthController constructor running...<br>";
        if (!method_exists($this, 'model')) {
            die("Error: model() method not found. Check if Core/Controller.php is correctly included.");
        }

        // echo "<br> model exists";

        $this->userModel = $this->model('UserModel');
        // echo "<br> after UserModel";

        // $hashedPassword = password_hash('bob123', PASSWORD_DEFAULT);
        // echo "Hashed password: " . $hashedPassword . "<br>";
    }

    public function login() {
        // echo "<br> login view or something";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // echo "<br> In Post if loop";
            $email = $_POST['Email'];
            $password = $_POST['Password'];
            echo "Email :" . $email .  "<br> Password: " . $password . "<br>";
    
            // Get user data from database
            echo "UserModel: " . $this->userModel;
            $user = $this->userModel->getUserByEmail($email);
            echo "UserModel: " . $this->userModel;
            // echo "User: " . $user;
    
            echo "Result: " . password_verify($password, $user['Password']);
            if ($user && password_verify($password, $user['Password'])) {
                // Store user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
    
                // Redirect to dashboard
                header("Location: ?controller=user&action=restaurantView");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
            echo "<br> how?";
        }
    
        // Show login view (for both GET requests and failed login attempts)
        $this->view('Auth/LoginView', isset($error) ? ['error' => $error] : []);
    }

    public function register(){
        require_once 'View\Auth\RegisterView.php';
    }


    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}
?>
