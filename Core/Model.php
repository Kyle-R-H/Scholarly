<?php
require_once 'Core/Database.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // General method to fetch all data from a table
    public function getAll($table) {
        return $this->db->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
