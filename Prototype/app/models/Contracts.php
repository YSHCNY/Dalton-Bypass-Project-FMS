<?php
require_once '../app/core/Model.php';



class ContractModel {
  private $db;
    private $table = "contractsTbl";
    

    public function __construct() {
     $this->db = Database::connect();
    }


      // Get all files
    public function getAllContracts() {
        $stmt = $this->db->query("SELECT * FROM ".$this->table." ORDER BY uploadDate DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>