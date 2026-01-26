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
    return $stmt->execute([$username, $hashedPassword, $firstName, $lastName, $position, $userLevel, $profilePicture]);
}



}
