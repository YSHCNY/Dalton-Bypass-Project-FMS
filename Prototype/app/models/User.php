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
    public function create($username, $password, $firstName, $lastName, $position, $userLevel) {
        $stmt = $this->db->prepare("INSERT INTO UserTbl (`username`, `password`, `firstName`, `lastName`, `position`, `userLevel`) VALUES (:username, :password, :firstName, :lastName, :position, :userLevel)");
        return $stmt->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'firstName' => $firstName,
            'lastName' => $lastName,
            'position' => $position,
            'userLevel' => $userLevel
        ]);
    }


}
