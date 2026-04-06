<?php
require_once '../app/core/Model.php';

class SyslogsModel {
    private $db;
    private $table = "systemLogs";
    

    public function __construct() {
     $this->db = Database::connect();
    }

    public function getAllData() {
        $stmt = $this->db->query("SELECT f.*,u.id, u.firstName, u.lastName, u.position FROM ".$this->table." f LEFT JOIN UserTbl u ON f.userName = u.id ORDER BY f.logDate DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}