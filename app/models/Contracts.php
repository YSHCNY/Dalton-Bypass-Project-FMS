<?php
require_once '../app/core/Model.php';

class ContractModel {
  private $db;
    private $table = "contractsTbl";
    

    public function __construct() {
     $this->db = Database::connect();
    }

}

?>