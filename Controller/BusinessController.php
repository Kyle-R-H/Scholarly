<?php
class BusinessController extends Controller{
    private $businessModel;
    private $businessType;
    private $businessName;
    
    public function __construct() {
        $this->businessModel = $this->model('BusinessModel');

        if (!isset($_COOKIE['Login_Info']) || $this->businessModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 1){
            $_SESSION['error'] = "Insufficient Permissions";
            $this->view('Auth/LoginView', []);
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
        $this->view('Business/BusinessItemManagerView', ['businessType' => $this->businessType,'businessName'=>$this->businessName, 'items' => $items]);
    }
    
    public function profile(){
        $this->view('Business/BusinessProfileView', ['businessType' => $this->businessType,'businessName'=>$this->businessName ]);
    }

    public function addItemView(){
        $this->view('Business/AddItemView', ['businessType' => $this->businessType,'businessName'=>$this->businessName ]);
    }

    public function responseToReview(){
        $reviews = $this->businessModel->getReviewByReviewID();

        $this->view('Business/ReviewResponseView', ['businessType' => $this->businessType,'businessName'=>$this->businessName
       , 'reviews' => $reviews
        ]);
    }

    public function addItem(){
        // Debugging input values
        $name = $_POST['ItemName'] ?? 'EMPTY';
        $description = $_POST['ItemDescription'] ?? 'EMPTY';
        $price = number_format((float)$_POST['ItemPrice'], 2, '.', '');

        // Check if businessModel is set
        if (!$this->businessModel) {
            die("Error: businessModel is NULL! Check if it is being initialized correctly.");
        }

        // Check if name exists
        $_SESSION['error'] = $this->businessModel->getSimilarItemNames($name);

        if ($_SESSION['error'] == null) {
            // Successful
            $this->businessModel->addItem($this->businessName, $description, $price, $name);
            header("Location: ?controller=business&action=businessManager");
            exit();
        } else {
            $this->view('Admin/RegisterBusinessView', []);
        }
        $this->view('Business/AddItemView', ['businessType' => $this->businessType,'businessName'=>$this->businessName ]);
    }

    public function saveResponse()
{
    // Get data from POST request
    $reviewID = $_POST['reviewID'] ?? null;
    $response = $_POST['response'] ?? '';

    // Validate input
    if (!$reviewID || empty(trim($response))) {
        die("Invalid input data.");
    }

    // Sanitize input
    $response = htmlspecialchars(trim($response));

    // Update the database
   $success = $this -> businessModel -> setResponseByReviewID($response, $reviewID);

    // Redirect back to the page (to avoid resubmission on refresh)
    if ($success) {
        header("Location: ?controller=business&action=responseToReview");
        exit;
    } else {
        die("Failed to save response.");
    }
}

}