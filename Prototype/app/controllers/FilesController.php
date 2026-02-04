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
                  $recipientsCateg = $this->filesCategModel->getAllRecipientsCateg();

                require __DIR__ . '/../views/files/create.php'; 

                }

              

                // stpre
                 public function store() {
                    if (!isset($_SESSION['user'])) {
                        $this->redirect('index.php?controller=Auth&action=login');
                    }

                    if (isset($_FILES['file'])) {
                        $fileName = $_FILES['file']['name'];
                        $targetDir =    __DIR__ . "/../uploads/";
                        $targetFile = $targetDir . basename($fileName);

                        $description = $_POST['description'] ?? '';
                        $uploaded_by =   $_SESSION['id'] ?? 'guest';
                        $position = $_SESSION['position'] ?? 'guest';
                        $direction = $_POST['fromCategory'] . " ⇄ " . $_POST['toCategory'];
                        $fileCategory = $_POST['fileCategory'] ?? 'Unacategorized';

                        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                            // pass all 5 arguments
                            $this->model->create($fileName, $targetFile, $description, $uploaded_by, $fileCategory, $position, $direction);
                            session_start();
                            $_SESSION['message'] = "File uploaded successfully!";
                            $_SESSION['msg_type'] = "success";
                            header("Location: index.php?controller=Files&action=files");
 
                            exit;
                        } else {
                            session_start();
                            $_SESSION['message'] = "EEERRRRRRRRRRRRRRR!";
                            $_SESSION['msg_type'] = "success";
                            header("Location: index.php?controller=Files&action=files");
                        echo "Failed to upload file.";
                    

                        }
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