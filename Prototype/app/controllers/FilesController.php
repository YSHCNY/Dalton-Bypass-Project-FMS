<?php
session_start();
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';
require_once "../app/models/Files.php";
require_once "../app/models/FilesCateg.php";


class FilesController extends Controller {
    



            private $model;
            private $filesCategModel;

            public function __construct() {
                $this->model = new FileModel();
                $this->filesCategModel = new FilesCategModel();
            }



                  
            public function files() {
                if (!isset($_SESSION['user'])) {
                    $this->redirect('index.php?controller=Auth&action=login');
                }


                // render files list view
                $content = $this->renderView('files/index', [
            
                    'files' => $this->model->getAll(),
                    'filesCateg' => $this->filesCategModel->getAllCateg()
              
                ]);


                
                $this->view('layout/main', [
                    'content' => $content
                ]);

              
            }

            

               // Show form
                public function create() {

                // check if user is logged in
                if (!isset($_SESSION['user'])) {
                    $this->redirect('index.php?controller=Auth&action=login');
                }

                 // Get categories
                $filesCateg = $this->filesCategModel->getAllCateg();
                require __DIR__ . '/../views/files/create.php'; 

                }


public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $confirm    = $_POST['confirm_password'];
        $firstName  = $_POST['firstName'];
        $lastName   = $_POST['lastName'];
        $position   = $_POST['position'];
        $userLevel  = $_POST['user_level'];

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

        $this->redirect('index.php?controller=Auth&action=login');
    } else {
        $this->view('auth/register');
    }
}





                    // Edit form
                    public function edit($id) {
                if (!isset($_SESSION['user'])) {
                    $this->redirect('index.php?controller=Auth&action=login');
                }

                $file = $this->model->getById($id);
                $filesCateg = $this->filesCategModel->getAllCateg();

                require __DIR__ . '/../views/files/edit.php'; 

                 // Get categories
              
            
                    }




                        // Update file
                    public function update($id) {
                        $file = $this->model->getById($id);
                        $filename = $file['filename'];
                        $filepath = $file['filepath'];
                        $description = $_POST['description'] ?? $file['desc'];
                        $fileCategory = $_POST['fileCategory'] ?? $file['category'];
                        // Check if a new file is uploaded
                        if(isset($_FILES['file']) && $_FILES['file']['name'] != "") {
                            // Delete old file
                            if(file_exists($filepath)) unlink($filepath);

                            $filename = $_FILES['file']['name'];
                            $filepath = "uploads/" . $filename;
                            move_uploaded_file($_FILES['file']['tmp_name'], $filepath);
                        }

                        $this->model->update($id, $filename, $filepath, $description, $fileCategory);
                        header("Location: index.php?controller=Files&action=files");

                        session_start();
                        $_SESSION['message'] = $filename . " has been edited successfully!";
                        $_SESSION['msg_type'] = "success";
                        
                    }




                      // Delete file
                    public function delete($id) {
                        $file = $this->model->getById($id);
                        if(file_exists($file['filepath'])) unlink($file['filepath']);
                        $this->model->delete($id);

                        session_start();
                        $_SESSION['message'] = "File deleted successfully!";
                        $_SESSION['msg_type'] = "success";
                        header("Location: index.php?controller=Files&action=files");
                    }



            public function download() {
                if (!isset($_SESSION['user'])) {
                    $this->redirect('index.php?controller=Auth&action=login');
                }

                if (empty($_GET['file'])) {
                    die("No file specified.");
                }

                // Decode filename from URL and get basename for safety
                $fileName = basename(urldecode($_GET['file']));
                $uploadDir = __DIR__ . "/../uploads/";
                $fullPath = $uploadDir . $fileName;

                if (!file_exists($fullPath)) {
                    die("File not found.");
                }

                // Clear any output buffer to prevent corruption
                if (ob_get_level()) {
                    ob_end_clean();
                }

                // Determine MIME type (optional, helps browsers)
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $fullPath);
                finfo_close($finfo);

                // Force download
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $mimeType);
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fullPath));

                // Read the file
                $fp = fopen($fullPath, 'rb');
                if ($fp) {
                    while (!feof($fp)) {
                        // Output file in chunks to avoid memory issues with large files
                        echo fread($fp, 8192);
                        flush();
                    }
                    fclose($fp);
                }
                exit;
            }




      



            public function logout() {
                    session_destroy();
                    $this->redirect('index.php?controller=Auth&action=login');
            }    



}