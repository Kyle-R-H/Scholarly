<?php

if (!file_exists('Core/Controller.php')) {
    die("Error: Core/Controller.php not found! Check the file path.");
}
require_once 'Core/Controller.php';
// echo "Core/Controller.php loaded successfully.<br>";

class AuthController extends Controller
{
    private $userModel;
    private $cookieName = "Login_Info";
    private $cookieValue;

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

    public function checkPermissionLevel($email){
        $user = $this->userModel->getUserByEmail($email);

        $permissionLevel = $user['PermissionLevel'];

        return $permissionLevel;
    }

    public function login(){
        // echo "<br> Login function called.<br>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // echo "<br> In POST request.<br>";

            // Debugging input values
            $email = $_POST['Email'] ?? 'EMPTY';
            $password = $_POST['Password'] ?? 'EMPTY';
            // echo "Email: " . htmlspecialchars($email) . "<br>";
            // echo "Password: " . htmlspecialchars($password) . "<br>";

            // Check if userModel is set
            if (!$this->userModel) {
                die("Error: userModel is NULL! Check if it is being initialized correctly.");
            }
            // echo "UserModel is set.<br>";

            // Fetch user from database
            $user = $this->userModel->getUserByEmail($email);
            // echo "Query executed, result: <pre>" . print_r($user, true) . "</pre>";

            // Check if user exists
            if (!$user) {
                $_SESSION['error'] = "User not found.";
                $this->view('Auth/LoginView', []);
                // header("Location: ?controller=auth&action=loginView");
                // exit;
            } else {
                // echo "User found!<br>";

                // Verify password
                $passwordMatch = password_verify($password, $user['Password'] ?? '');
                // echo "Password Verify Result: " . ($passwordMatch ? "MATCH" : "NO MATCH") . "<br>";
                // echo "Password Result: " . $passwordMatch;

                if ($user && $passwordMatch) {
                    // echo "User authenticated, setting session variables.<br>";

                    $_SESSION['UserID'] = $user['UserID'];
                    $_SESSION['FirstName'] = $user['FirstName'];

                    $this -> cookieValue = $email;
                    setcookie($this-> cookieName, $this -> cookieValue,  time() + (86400 * 30));

                    $permissionLevel = $this->checkPermissionLevel($email);
                    switch($permissionLevel){
                        // User
                        case 0:
                            header("Location: ?controller=user&action=restaurantView");
                            exit();

                        // Business
                        case 1:
                            header("Location: ?controller=business&action=dashboard");
                            exit();
                        
                        // Admin
                        case 2:
                            header("Location: ?controller=admin&action=dashboard");
                            exit();
                    }
                } else {
                    // echo "Invalid credentials, displaying error.<br>";
                    $_SESSION['error'] = "Invalid email or password.";
                    $this->view('Auth/LoginView', []);
                }
            }
        }
    }

    public function loginView()
    {
        $this->view('Auth/LoginView', []);
    }

    public function register()
    {
        // echo "<br>Register function called.<br>";

        // Debugging input values
        $email = $_POST['RegisterEmail'] ?? 'EMPTY';
        $password = $_POST['RegisterPassword'] ?? 'EMPTY';
        $confirmPassword = $_POST['RegisterConfirmPassword'] ?? 'EMPTY';
        $firstName = $_POST['RegisterFirstName'] ?? 'EMPTY';
        $lastName = $_POST['RegisterLastName'] ?? 'EMPTY';

        // Check if userModel is set
        if (!$this->userModel) {
            die("Error: userModel is NULL! Check if it is being initialized correctly.");
        }

        // Fetch user from database
        $user = $this->userModel->getUserByEmail($email);
        // echo "<br>Query executed, result: <pre>" . print_r($user, true) . "</pre>";


        if(!empty($email)){
            if (!$user) {
                // Check if passwords match and aren't empty
                if ($password == $confirmPassword){
                    // Successful registration
                    $_SESSION['success'] = "Registration Successful";
                    $this->userModel->registerUser($firstName, $lastName, $email, $password);

                    $_SESSION['UserID'] = $user['UserID'];

                    $this -> cookieValue = $email;
                    setcookie($this-> cookieName, $this -> cookieValue,  time() + (86400 * 30));

                    header("Location: ?controller=user&action=restaurantView");
                    exit();
                } else if (empty($password) || empty($confirmPassword)){
                    // Empty password or confirmPassword
                    $_SESSION['error'] = "Please enter Password(s)";
                    $this->view('Auth/RegisterView', []);
                } else {
                    $_SESSION['error'] = "Passwords don't match.";
                    $this->view('Auth/RegisterView', []);
                }
            } else {
                $_SESSION['error'] = "User with that email already exists.";
                $this->view('Auth/RegisterView', []);
            }
        } else {
            // Empty email
            $this->view('Auth/RegisterView', []);
        }
    }


    public function registerView()
    {
        $this->view('Auth/RegisterView', []);
    }


    public function logout()
    {
        session_destroy();
        header("Location: ?controller=auth&action=loginView");
        exit;
    }
}
