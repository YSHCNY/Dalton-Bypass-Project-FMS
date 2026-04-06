<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require "../app/views/$view.php";
    }

       protected function renderView($view, $data = []) {
        extract($data);
        ob_start();  
        require __DIR__ . "/../views/$view.php";
        return ob_get_clean(); 
    }


        protected function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
    }



    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    
}
