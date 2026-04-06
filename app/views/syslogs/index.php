<div class="min-h-screen space-y-6 p-6">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
      <div>
        <h1 class="text-2xl font-semibold text-gray-800">System Logs</h1>
        <p class="text-sm text-gray-500">Track system activity</p>
      </div>

 
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-200">
      <div class="overflow-x-auto p-4">


        <table class="min-w-full text-sm text-left text-gray-700 py-5" id="syslogsTable">
          <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
              <th class="px-6 py-3 text-left">Time</th>
              <th class="px-6 py-3 text-left">Module</th>
              <th class="px-6 py-3 text-left">User</th>
              <th class="px-6 py-3 text-left">Message</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100">
            <!-- Log Row -->
             <?php foreach($syslogs as $log): ?>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-6 py-4 text-gray-500"><?= $log['logDate'] ?></td>
              <td class="px-6 py-4">
                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                  <?= $log['module'] ?>
                </span>
              </td>
              
              <td class="px-6 py-4 text-gray-700"> <p class="font-medium text-gray-900">
                        <?= htmlspecialchars($log['lastName']) ?>,
                        <?= htmlspecialchars($log['firstName']) ?>
                      </p>
                      <p class="text-xs text-gray-500">
                        ID #<?= htmlspecialchars($log['id']) ?>
                      </p></td>

              <td class="px-6 py-4 text-gray-800">
                <?= $log['logDesc'] ?>
              </td>
            </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<script>



$(document).ready(function () {
  const table = $('#syslogsTable').DataTable({
    pageLength: 50,
    order: [[5, 'desc']],
    responsive: true,
    orderCellsTop: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search files..."
    },

  });


});
</script>