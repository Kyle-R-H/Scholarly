<?php
class AdminController extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = $this->model('AdminModel');

        if (!isset($_COOKIE['Login_Info']) || $this->adminModel->getUserByEmail($_COOKIE["Login_Info"])['PermissionLevel'] != 2) {
            $error = "Insufficient Permissions";
            $this->view('Auth/LoginView', isset($error) ? ['error' => $error] : []);
        } else {
            // print_r($_COOKIE);
        }
    }


    public function dashboard()
    {
        $orders = $this->adminModel->getAllOrders();
        $mostPopularItem = $this->adminModel->getMostPopularItem();
        $mostPopularBusiness = $this->adminModel->getMostPopularBusiness();
        $mostPopularDay = $this->adminModel->getMostPopularDay();
        $largestOrderByPrice = $this->adminModel->getLargestOrderByPrice();
        $largestOrderByItems = $this->adminModel->getLargestOrderByItems();
        $topCustomer = $this->adminModel->getTopCustomerByItems();

        $this->view(
            'Admin/AdminDashboardView',
            [
                'orders' => $orders,
                'mostPopularItem' => $mostPopularItem,
                'mostPopularBusiness' => $mostPopularBusiness,
                'mostPopularDay' => $mostPopularDay,
                'largestOrderByPrice' => $largestOrderByPrice,
                'largestOrderByItems' => $largestOrderByItems,
                'topCustomer' => $topCustomer
            ]
        );
    }

    public function profile()
    {
        $this->view('Admin/AdminProfileView', []);
    }

    public function adminManager()
    {
        $businesses = $this->adminModel->getBusinessesWithOwners();


        $this->view(
            'Admin/AdminManagerView',
            ['businesses' => $businesses]
        );
    }

    public function registerBusinessView()
    {
        $this->view('Admin/RegisterBusinessView', isset($error) ? ['error' => $error] : []);
    }

    public function registerBusiness()
    {

        // echo "<br>Register function called.<br>";

        // Debugging input values
        $name = $_POST['RegisterName'] ?? 'EMPTY';
        $email = $_POST['RegisterEmail'] ?? 'EMPTY';
        $businessType = $_POST['RegisterBusinessType'] ?? 'EMPTY';
        $description = $_POST['RegisterDescription'] ?? 'EMPTY';
        $image = $_POST['RegisterImage'] ?? 'EMPTY';

        // Check if adminModel is set
        if (!$this->adminModel) {
            die("Error: adminModel is NULL! Check if it is being initialized correctly.");
        }

        // Fetch user from database
        $user = $this->adminModel->getUserByEmail($email);
        // echo "<br>Query executed, result: <pre>" . print_r($user, true) . "</pre>";


        if (!empty($email)) {
            if ($user) {
                $userID = $user['UserID'];
                // Check if name exists
                $error = $this->adminModel->getSimilarBusinessNames($name);

                if ($error == null) {
                    // Successful registration
                    $this->adminModel->registerBusiness($userID, $name, $businessType, $description, $image);
                }
                $this->view('Admin/RegisterBusinessView', isset($error) ? ['error' => $error] : []);

            } else {
                // User not found
                $error = "User with that email does not exist.";
                $this->view('Admin/RegisterBusinessView', isset($error) ? ['error' => $error] : []);
            }
        } else {
            // Empty email
            $error = "Please enter an email."; // cant reach due to required in input tag
            $this->view('Admin/RegisterBusinessView', isset($error) ? ['error' => $error] : []);
        }
        // $this->view('Admin/AddBusinessView', isset($error) ? ['error' => $error] : []);
    }
}
