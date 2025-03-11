<?php
// Include required files
require_once 'Core/Controller.php';

// Get the URL parameters
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'LoginView';

// Format controller name
$controllerName = ucfirst(strtolower($controller)) . 'Controller';


// Define path to controller
$controllerPath = 'Controller/' . $controllerName . '.php';

// ob_start();
// echo "Looking for: " . $controllerPath;
// // echo $controllerName . "<br>" . $controllerPath . "<br>";
// ob_end_clean();

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controllerInstance = new $controllerName();

    if (method_exists($controllerInstance, $action)) {
        // Call the action with parameters if available
        call_user_func_array([$controllerInstance, $action],[]);
    } else {
        ob_start();
        echo "Error: Action '$action' not found in controller '$controllerName'.";
        ob_end_clean();
    }
} else {
    ob_start();
    echo "Error: Controller '$controllerName' not found.";
    ob_end_clean();
}
?>
