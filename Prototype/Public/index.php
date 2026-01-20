

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DALTON BYPASS - FMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
<link rel="icon" type="image/png" href=".././app/assets/logo/symbol.png" />

</head>


<body>



<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$controller = $_GET['controller'] ?? 'Auth';
$action = $_GET['action'] ?? 'login';



require_once "../app/controllers/{$controller}Controller.php";

$class = $controller . 'Controller';
$ctrl = new $class();

$id = $_POST['id'] ?? $_GET['id'] ?? null;

if ($id !== null) {
    $ctrl->$action($id);
} else {
    $ctrl->$action();
}

?>

</body>

</body>
</html>