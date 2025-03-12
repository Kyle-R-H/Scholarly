<?php
class Controller {
    // Load a model
    public function model($model) {
        require_once 'Model/' . $model . '.php';
        return new $model();
    }

    // Load a view
    public function view($view, $data = []) {
        extract($data); // Extract data array into variables
        require_once 'View/' . $view . '.php';
    }
}
?>
