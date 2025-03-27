<?php
class BusinessController extends Controller{

    public function __construct() {
        if (!isset($_COOKIE['Login_Info'])){
            require_once "View/Auth/LoginView.php";
        } 
        else {
            print_r($_COOKIE);
        }
    }


    public function businessDashboardView(){
        require_once 'View/Business/BusinessDashboardView.php';
    }
}