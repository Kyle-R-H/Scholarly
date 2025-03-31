<?php
class AdminController extends Controller{
    private $adminModel;

    public function __construct() {
        $this->adminModel = $this->model('AdminModel');

        if (!isset($_COOKIE['Login_Info']) || $this->adminModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 0){
            require_once "View/Auth/LoginView.php";
        } 
        else {
            // print_r($_COOKIE);
        }
    }


    public function dashboardView(){
        require_once 'View/Admin/AdminDashboardView.php';
    }

    public function adminManagerView(){
        require_once 'View/Admin/AdminItemManagerView.php';
    }

    public function profileView(){
        require_once 'View/Admin/AdminProfileView.php';
    }
}