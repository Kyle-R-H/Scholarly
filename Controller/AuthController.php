<?php

if (!file_exists('Core/Controller.php')) {
    die("Error: Core/Controller.php not found! Check the file path.");
}
require_once 'Core/Controller.php';
// echo "Core/Controller.php loaded successfully.<br>";

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
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

    public function login()
    {
        echo "<br> Login function called.<br>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<br> In POST request.<br>";

            // Debugging input values
            $email = $_POST['Email'] ?? 'EMPTY';
            $password = $_POST['Password'] ?? 'EMPTY';
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "Password: " . htmlspecialchars($password) . "<br>";

            // Check if userModel is set
            if (!$this->userModel) {
                die("Error: userModel is NULL! Check if it is being initialized correctly.");
            }
            echo "UserModel is set.<br>";

            // Fetch user from database
            $user = $this->userModel->getUserByEmail($email);
            echo "Query executed, result: <pre>" . print_r($user, true) . "</pre>";

            // Check if user exists
            if (!$user) {
                echo "Error: No user found with email $email!<br>";
            } else {
                echo "User found!<br>";
            }

            // Verify password
            $passwordMatch = password_verify($password, $user['Password'] ?? '');
            echo "Password Verify Result: " . ($passwordMatch ? "MATCH" : "NO MATCH") . "<br>";
            echo "Password Result: " . $passwordMatch;

            if ($user && $passwordMatch) {
                echo "User authenticated, setting session variables.<br>";

                $_SESSION['UserID'] = $user['UserID'];
                $_SESSION['FirstName'] = $user['FirstName'];

                echo "Redirecting to restaurantView...<br>";
                header("Location: ?controller=user&action=restaurantView");
                exit();
            } else {
                echo "Invalid credentials, displaying error.<br>";
                $error = "Invalid email or password.";
            }
        }

        // Show login view
        $this->view('Auth/LoginView', isset($error) ? ['error' => $error] : []);
    }

    public function register()
    {
        echo "<br>Register function called.<br>";

        // Debugging input values
        $email = $_POST['RegisterEmail'] ?? 'EMPTY';
        $password = $_POST['RegisterPassword'] ?? 'EMPTY';
        $confirmPassword = $_POST['RegisterConfirmPassword'] ?? 'EMPTY';
        echo "Email: " . htmlspecialchars($email) . "<br>";
        echo "Password: " . htmlspecialchars($password) . "<br>";
        echo "Confirm password: " . htmlspecialchars($confirmPassword) . "<br>";

        // Check if userModel is set
        if (!$this->userModel) {
            die("Error: userModel is NULL! Check if it is being initialized correctly.");
        }
        echo "UserModel is set.<br>";

        // Fetch user from database
        $user = $this->userModel->getUserByEmail($email);
        echo "<br>Query executed, result: <pre>" . print_r($user, true) . "</pre>";

        // Check if user exists

        if (!$user) {
            echo "User with email $email not found, new user :)<br>";

            if($password == $confirmPassword){
                echo "Passwords match :)";
            } else if (!empty($password) && !empty($confirmPassword)){
                echo "Passwords don't match :(";
            } else {
                echo "One of the passwords is empty :(";
            }
        }else {
            echo "User already exists :(<br>";
            $error = "User with that email already exists. Go to login page instead.";
        }
        

        $this->view('Auth/RegisterView', isset($error) ? ['error' => $error] : []);
    }


    public function registerView()
    {
        $this->view('Auth/RegisterView', isset($error) ? ['error' => $error] : []);
    }


    public function logout()
    {
        session_destroy();
        header("Location: ?controller=auth&action=login");
        exit;
    }
}
