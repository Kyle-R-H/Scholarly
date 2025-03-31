<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

class AdminModel extends Model{

    public function __construct() {
        parent::__construct();
    }

}