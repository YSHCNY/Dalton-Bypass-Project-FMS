<?php
session_start();
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';

class AuthController extends Controller {
// 

  
        //login method
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                $_SESSION['user_level'] = $user['userLevel'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['position'] = $user['position'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['profile_picture'] = $user['profile_picture'] ?? 'default.png';
                $_SESSION['id'] = $user['id'];

                $this->redirect('index.php?controller=Auth&action=dashboard&wc=welcome');

            } else {
                $error = "Invalid username or password";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }



public function register() {
    $this->requireLogin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $confirm    = $_POST['confirm_password'];
        $firstName  = $_POST['firstName'];
        $lastName   = $_POST['lastName'];
        $position   = $_POST['position'];
        $userLevel  = $_POST['user_level'];
        

        $first = $_SESSION['firstName'] ?? '';
        $last  = $_SESSION['lastName'] ?? '';
        $uploader = trim($first . ' ' . $last) ?: 'System';

         // === Basic validation ===    
        if ($password !== $confirm) {
            $error = "Passwords do not match";
            $this->view('auth/register', ['error' => $error]);
            return;
        }

        $userModel = new User();

        if ($userModel->findByUsername($username)) {
            $error = "Username already exists";
            $this->view('auth/register', ['error' => $error]);
            return;
        }

        // === Profile picture upload ===
        $profileFileName = null; // default
        $relativePath = null;

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            // Absolute path on server
            $uploadDir = __DIR__ . '/../assets/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $originalName = $_FILES['profile_picture']['name'];
            $profileFileName = preg_replace("/[^A-Za-z0-9\.\-_() ]/", '_', basename($originalName));
            $targetFile = $uploadDir . $profileFileName;

            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                $error = "Failed to upload profile picture. Check folder permissions.";
                $this->view('auth/register', ['error' => $error]);
                return;
            }

            // **Store relative path**
            $relativePath = 'assets/profiles/' . $profileFileName;
        }

        // Pass relative path to model
        $userModel->create($username, $password, $firstName, $lastName, $position, $userLevel, $relativePath);
        $userModel->log($username, $firstName, $lastName, $position, $uploader, $userLevel);

        $this->redirect('index.php?controller=Auth&action=users');
    } else {
        $this->view('auth/register');
    }
}


            

        // display dashboard
            public function dashboard() {
                if (!isset($_SESSION['user'])) {
                    $this->redirect('index.php?controller=Auth&action=login');
                }


            $content = $this->renderView('auth/dashboard', ['username' => $_SESSION['user'] ]);

            $this->view('layout/main', ['content' => $content]);
            }


            // Controller property for User model (display all users)
            private $userModel;

            public function __construct() {
                $this->userModel = new User();
            }

            // Display all users
            public function users() {
                $this->requireLogin();
                $content = $this->renderView('auth/users', ['users' => $this->userModel->getAllUser() ]);
                $users = $this->userModel->getAllUser();
        
                $this->view('layout/main', ['content' => $content]);
            }

   
            // Delete file
             public function delete(int $id) {
                 $this->requireLogin();
                $this->userModel->delete($id);

                session_start();
                $_SESSION['message'] = "User removed successfully!";
                $_SESSION['msg_type'] = "success";
                header("Location: index.php?controller=Auth&action=users");
            }
            

        


    public function logout() {
        session_destroy();
        $this->redirect('index.php?controller=Auth&action=login');
    }
}
