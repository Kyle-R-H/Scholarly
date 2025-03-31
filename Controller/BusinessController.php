<?php
class BusinessController extends Controller{
    private $businessModel;
    private $businessType;
    private $businessName;
    
    public function __construct() {
        $this->businessModel = $this->model('BusinessModel');

        if (!isset($_COOKIE['Login_Info']) || $this->businessModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 1){
            $error = "Insufficient Permissions";
            $this->view('Auth/LoginView', isset($error) ? ['error' => $error] : []);
        } else {
            // Get user table
            $user = $this->businessModel->getUserByEmail($_COOKIE['Login_Info']);

            // Get business table from userID
            $business = $this->businessModel->getBusinessByUserID($user['UserID']);

            $this->businessType = $business['BusinessType'];
            $this->businessName = $business['BusinessName'];
        }
    }


    public function dashboard(){
        $stats = $this->businessModel->getStatsByBusiness($this->businessName);
        $this->view('Business/BusinessDashboardView', ['businessType' => $this->businessType,'businessName'=>$this->businessName, 'stats' => $stats]);
    }
    
    public function businessManager(){
        $items = $this->businessModel->getItemsByBusiness($this->businessName);
        $this->view('Business/BusinessItemManagerView', ['businessType' => $this->businessType,'businessName'=>$this->businessName, 'items'=>$items]);
    }
    
    public function profile(){
        $this->view('Business/BusinessProfileView', ['businessType' => $this->businessType,'businessName'=>$this->businessName ]);
    }
}