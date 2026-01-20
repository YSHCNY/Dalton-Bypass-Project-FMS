
<?php
require_once '../app/core/Model.php';

class FilesCategModel {
  private $db;
    private $table = "filescategory";
    

    public function __construct() {
     $this->db = Database::connect();
    }


           // Get all categories
    public function getAllCateg() {
        $stmt = $this->db->query("SELECT * FROM ".$this->table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }


        public function getCategById($id) {
        $stmt = $this->db->prepare("SELECT * FROM ".$this->table." WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


 
}