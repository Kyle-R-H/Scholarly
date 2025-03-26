<?php
// echo "router <br>";
// Include required files
require_once 'Controller.php';

// Get the URL parameters
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Format controller name
$controllerName = ucfirst(strtolower($controller)) . 'Controller';
// echo $controllerName . "<br>";

// Define path to controller
$controllerPath = 'Controller/' . $controllerName . '.php';

// ob_start();
// echo "Looking for: " . $controllerPath . "<br>";
// echo $controllerName . "<br>" . $controllerPath . "<br>";
// ob_end_clean();

if (file_exists($controllerPath)) {
    // echo "file exists <br> Path:" . $controllerPath . "<br>";
    // print_r(get_declared_classes());
    require $controllerPath;
    // echo "hello?";
    // echo "<br>Before:<br>";
    // print_r(get_declared_classes());
    // echo "<br>";
    // var_dump(realpath($controllerPath));
    $controllerInstance = new $controllerName();
    // echo "<br>" . "After:" . "<br>";
    // print_r(get_declared_classes());
    // echo "<br> controller instance";
    if (method_exists($controllerInstance, $action)) {
        // Get parameters after action
        $params = $_GET;

        // Remove controller and action
        unset($params['controller'], $params['action']); 

        // Call the action with parameters if available
        call_user_func_array([$controllerInstance, $action],$params);
    } else {
        echo "Error: Action '$action' not found in controller '$controllerName'.";
        require "View/Error.php";
    }
} else {
    echo "Error: Controller '$controllerName' not found.";
    require "View/Error.php";
}
?>
