<?php
class AdminController extends Controller{
    private $adminModel;

    public function __construct() {
        $this->adminModel = $this->model('AdminModel');

        if (!isset($_COOKIE['Login_Info']) || $this->adminModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 2){
            $error = "Insufficient Permissions";
            $this->view('Auth/LoginView', isset($error) ? ['error' => $error] : []);
        } 
        else {
            // print_r($_COOKIE);
        }
    }


    public function dashboard(){
        $this->view('Admin/AdminDashboardView', []);
    }
    
    public function profile(){
        $this->view('Admin/AdminProfileView', []);
    }
    
    public function adminManager(){
        $businesses = $this->adminModel->getBusinessesWithOwners();

        $this->view('Admin/AdminManagerView', ['businesses'=>$businesses]);
    }
}