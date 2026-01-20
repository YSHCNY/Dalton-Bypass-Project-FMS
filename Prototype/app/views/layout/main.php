<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dalton Bypass</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.dataTables.min.css">

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.6.2/js/dataTables.colReorder.min.js"></script>
    <!-- ColReorderWithResize plugin -->
    <script src="https://cdn.jsdelivr.net/gh/akottr/ColReorderWithResize/ColReorderWithResize.js"></script>
    <!-- Tailwind overrides for DataTables -->
<link rel="stylesheet" href=".././app/assets/css/dataTables-tailwind.css">

</head>


<body class=" bg-light">
<?php require __DIR__ . '/../partials/icons.php'; ?>
  <!-- Sidebar -->
  <?php require __DIR__ . '/../partials/sidebar.php'; ?>

  <!-- Page Wrapper -->
  <div class="ml-0 md:ml-72 min-h-screen flex flex-col transition-all">

    <!-- Header -->
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">

      <!-- Flash message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div id="flash" class="mb-4 px-4 py-3 rounded-md text-white
                        <?= $_SESSION['msg_type'] === 'success' ? 'bg-green-500' : 'bg-red-500' ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById("flash").remove();
                }, 3000);
            </script>
            <?php 
                unset($_SESSION['message']);
                unset($_SESSION['msg_type']);
            ?>
        <?php endif; ?>
      <?= $content ?>
    </main>

  </div>

</body>

</body>
</html>
