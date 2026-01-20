<?php
$user_name = $_SESSION['user']['first_name'] ?? 'Guest';
$user_image = $_SESSION['user']['profile_image'] ?? 'default.png';


$currentController = $_GET['controller'] ?? '';
$currentAction = $_GET['action'] ?? '';

if ($currentController == 'Auth' && $currentAction == 'dashboard') {
  $pageTitle = 'Dashboard';
} elseif ($currentController == 'Files' && $currentAction == 'files') {
  $pageTitle = 'Files';
}
?>
 
<nav class="sticky top-0 z-20
            bg-white/20 backdrop-blur-xl
           
            px-6 py-3
            flex justify-between items-center">

  <div class="flex items-center gap-4">
    <button id="sidebarToggle"
            class="md:hidden text-2xl text-gray-700 focus:outline-none">
      &#9776;
    </button>
    <span class="text-lg font-semibold text-gray-800"> <?= $pageTitle  ?></span>
  </div>

  <div class="flex items-center gap-3">
    <div class = 'text-right'>
    <span class="font-medium text-gray-800"><?= $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] ?></span> <br>
    <span class="font-normal text-gray-500"><?= $_SESSION['position'] ?></span>
</div>
    <img src="uploads/<?= htmlspecialchars($user_image) ?>"
         class="w-9 h-9 rounded-full object-cover shadow-sm">
  </div>
</nav>

<script>
  const sidebar = document.getElementById('sidebar');
  const btn = document.getElementById('sidebarToggle');
  if (btn) {
    btn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  }
</script>
