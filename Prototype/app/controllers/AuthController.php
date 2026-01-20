<?php
session_start();
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';

class AuthController extends Controller {
// 

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

                $this->redirect('index.php?controller=Auth&action=dashboard');

            } else {
                $error = "Invalid username or password";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }


       public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm  = $_POST['confirm_password'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $position = $_POST['position'];
            $userLevel = $_POST['user_level'];

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

            $userModel->create($username, $password, $firstName, $lastName, $position, $userLevel);
            $this->redirect('index.php?controller=Auth&action=login');
        } else {
            $this->view('auth/register');
        }
    }

    

            public function dashboard() {
                if (!isset($_SESSION['user'])) {
                    $this->redirect('index.php?controller=Auth&action=login');
                }


            $content = $this->renderView('auth/dashboard', [
                'username' => $_SESSION['user']
            ]);

            $this->view('layout/main', [
                'content' => $content
            ]);
            }





    public function logout() {
        session_destroy();
        $this->redirect('index.php?controller=Auth&action=login');
    }
}
