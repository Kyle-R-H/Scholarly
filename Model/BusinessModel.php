<?php
if (!file_exists('Core/Model.php')) {
    die("Error: Core/Model.php not found! Check the file path.");
}

require_once 'Core/Model.php';

class BusinessModel extends Model{

    public function __construct() {
        parent::__construct();
    }

    public function getBusinessByUserID($userId) {
        return $this->db->query("SELECT * FROM Business WHERE UserId = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
    }

    public function getStatsByBusiness($businessName) {
        return $this->db->query("SELECT * FROM businessstats WHERE BusinessName = ?", [$businessName])->fetchAll(PDO::FETCH_ASSOC);
    }
}