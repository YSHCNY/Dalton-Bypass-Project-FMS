<?php
require_once '../app/core/Model.php';

class FileModel {
  private $db;
    private $table = "files";
    

    public function __construct() {
     $this->db = Database::connect();
    }



      // Get all files
    public function getAll() {
        $stmt = $this->db->query("SELECT f.*, u.firstName, u.lastName, u.position FROM ".$this->table." f LEFT JOIN UserTbl u ON f.uploader = u.id ORDER BY f.uploadedat DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

      // Get single file by id
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM ".$this->table." WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


        // Insert file
    public function create($filename, $filepath, $description , $uploaded_by, $fileCategory, $position, $direction) {
        $stmt = $this->db->prepare("INSERT INTO ".$this->table." (`filename`, `filepath`, `desc`, `uploader`, `category`, `position`, `direction`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$filename, $filepath, $description, $uploaded_by, $fileCategory, $position, $direction]);
    }

    // Update file
    public function update($id, $filename, $filepath, $description, $fileCategory) {
        $stmt = $this->db->prepare("UPDATE ".$this->table." SET `filename`=?, `filepath`=?, `desc`=?, `category`=? WHERE `id`=?");
        return $stmt->execute([$filename, $filepath, $description, $fileCategory, $id]);
    }


    // Delete file
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ".$this->table." WHERE id=?");
        return $stmt->execute([$id]);   
    }





}