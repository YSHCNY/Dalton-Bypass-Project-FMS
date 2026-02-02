<?php
require_once '../app/core/Model.php';
class User extends Model {

    // Find user by username (for login)
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM UserTbl WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }


     // Create new user (registration)
public function create($username, $password, $firstName, $lastName, $position, $userLevel, $profilePicture = null) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->db->prepare("INSERT INTO UserTbl (`username`, `password`, `firstName`, `lastName`, `position`, `userLevel`, `profile_picture`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $firstName, $lastName, $position, $userLevel, $profilePicture]);


}

public function log($username, $firstName, $lastName, $position, $uploader, $userLevel){
                        
    if ($userLevel == 1){
        $userLevel .= " (Administrator)";
    } else if ($userLevel == 2){
        $userLevel .= " (Encoder User)";
    } else {
        $userLevel .= " (Viewer)";
    }

    $customDesc = "New user: $lastName, $firstName ($username) • Position: $position • Level: $userLevel • Registered by: $uploader";

    $stmt2 = $this->db->prepare("INSERT INTO systemLogs (`userName`, `logDesc`, `module`, `logDate`) VALUES (?, ?, ?, ?)");
    $stmt2->execute([$uploader, $customDesc, "Account Access Control", date("Y-m-d H:i:s")]);
}


   public function getAllUser() {
        $stmt = $this->db->prepare("SELECT * FROM UserTbl");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

     public function findUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM UserTbl WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

      public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM UserTbl WHERE id = ?");
        return $stmt->execute([$id]);
    }







}
