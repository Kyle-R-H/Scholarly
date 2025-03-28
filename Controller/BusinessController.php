<?php
class BusinessController extends Controller{
    private $businessModel;

    public function __construct() {
        $this->businessModel = $this->model('BusinessModel');

        if (!isset($_COOKIE['Login_Info']) || $this->businessModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 1){
            require_once "View/Auth/LoginView.php";
        } else {
            // print_r($_COOKIE);
        }
    }


    public function dashboardView(){
        require_once 'View/Business/BusinessDashboardView.php';
    }

    public function businessManagerView(){
        require_once 'View/Business/BusinessItemManagerView.php';
    }

    public function profileView(){
        require_once 'View/Business/BusinessProfileView.php';
    }
}