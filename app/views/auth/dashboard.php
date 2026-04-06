<div class="space-y-6">

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <?php
    $cards = [
      ['Total Files', $totalFiles ?? 0],
      ['Categories', $totalCategories ?? 0],
      ['Active Users', $activeUsers ?? 0],
      ['Pending', $pending ?? 0]
    ];
    foreach ($cards as [$label, $value]): ?>
      <div class="bg-white rounded-2xl shadow-md p-5 text-center hover:shadow-lg transition">
        <p class="text-gray-500 text-sm"><?= $label ?></p>
        <h2 class="text-2xl font-bold text-gray-800"><?= $value ?></h2>
      </div>
    <?php endforeach; ?>
  </div>

</div>
