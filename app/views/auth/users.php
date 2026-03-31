<?php require __DIR__ . '/../partials/icons.php'; ?>

<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h4 class="text-xl font-semibold text-gray-800">
        Account Access Control
      </h4>
      <p class="text-sm text-gray-500">
        Manage application users, roles, and access permissions.
      </p>
    </div>

    <?php
      if ($_SESSION['user_level'] === '3') {
        $state = "opacity-50 cursor-not-allowed";
        $disabled = "disabled";
      } else {
        $state = "";
        $disabled = "";
      }
    ?>

    <a <?= $disabled ?>
       href="index.php?controller=Auth&action=register"
       class="inline-flex items-center gap-2 <?= $state ?>
              bg-sky-600 text-white
              px-5 py-2.5 rounded-xl
              shadow-sm hover:bg-sky-700
              border border-dashed border-sky-400
              transition">
      <?= $usersIcon ?>
      <span class="font-medium">Create User</span>
    </a>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-200">

    <div class="overflow-x-auto p-4">
      <table id="Table"
             class="min-w-full text-sm text-left text-gray-700 py-5">

        <thead class="bg-gray-50 text-[11px] uppercase tracking-wider text-gray-500">
          <tr>
            <th class="px-6 py-4">User</th>
            <th class="px-6 py-4">Position</th>
            <th class="px-6 py-4">Username</th>
            <th class="px-6 py-4">Access Level</th>
            <th class="px-6 py-4 text-center">Actions</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
              <tr class="hover:bg-gray-50 transition">

                <!-- User -->
                <td class="px-6 py-4">
                  <div class="flex items-center gap-4">
                    <img src=".././app/assets/profiles/<?= $user['profile_picture'] ?? 'default.png' ?> "
                         class="w-11 h-11 rounded-full object-cover border border-gray-200 shadow-sm"
                         alt="Profile">

                    <div class="leading-tight">
                      <p class="font-medium text-gray-900">
                        <?= htmlspecialchars($user['lastName']) ?>,
                        <?= htmlspecialchars($user['firstName']) ?>
                      </p>
                      <p class="text-xs text-gray-500">
                        ID #<?= htmlspecialchars($user['id']) ?>
                      </p>
                    </div>
                  </div>
                </td>

                <!-- Position -->
                <td class="px-6 py-4 text-gray-700">
                  <?= htmlspecialchars($user['position']) ?>
                </td>

                <!-- Username -->
                <td class="px-6 py-4">
                  <span class="font-mono text-stone-800">
                    <?= htmlspecialchars($user['username']) ?>
                  </span>
                </td>

                <!-- User Level -->
                <td class="px-6 py-4">
                  <?php
                    if ($user['userLevel'] == 1) {
                      echo "<span class='px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700'>Admin</span>";
                    } elseif ($user['userLevel'] == 2) {
                      echo "<span class='px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700'>Encoder</span>";
                    } else {
                      echo "<span class='px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600'>Viewer</span>";
                    }
                  ?>
                </td>

                <!-- Actions -->
                <td class="px-6 py-4">
                  <div class="flex justify-center gap-2">
                    <?php if ($_SESSION['user_level'] === '1'): ?>

                      <a href="index.php?controller=Auth&action=edit&id=<?= $user['id'] ?>"
                         class="p-2 rounded-lg
                                bg-emerald-100 border border-emerald-500
                                text-emerald-600 hover:bg-emerald-600 hover:text-white
                                transition"
                         title="Edit">
                        <?= $editIcon ?>
                      </a>

                      <a href="index.php?controller=Auth&action=delete&id=<?= $user['id'] ?>"
                         onclick="return confirm('Delete this user?')"
                         class="p-2 rounded-lg
                                bg-red-50 border border-red-500
                                text-red-600 hover:bg-red-600 hover:text-white
                                transition"
                         title="Delete">
                        <?= $deleteIcon ?>
                      </a>

                    <?php endif; ?>
                  </div>
                </td>

              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="py-10 text-center text-gray-500">
                No users found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>
</div>


<script>
$(document).ready(function () {
  $('#Table').DataTable({
    pageLength: 50,
    order: [[4, 'desc']],
    responsive: true,
     language: {
            search: "_INPUT_",
            searchPlaceholder: "Search files..."
        }
  });
});
</script>