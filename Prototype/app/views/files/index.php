<!-- include icons -->
<?php require __DIR__ . '/../partials/icons.php'; ?>

<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="px-1">
      <h4 class="text-xl font-semibold text-gray-800">Official File Repository</h4>
      <p class="text-sm text-gray-500">
        UPLOAD FINAL VERSION OF ALL DOCUMENTS
      </p>
    </div>
     <?php if($_SESSION['user_level'] === '3'): 
        $state = " opacity-50 cursor-not-allowed";
        $disabled = "disabled";
        else:
        $state = "";
        $disabled = "";
      endif;
      ?>


    <a <?= $disabled ?>href="index.php?controller=Files&action=create"
       class="inline-flex items-center gap-2 <?= $state ?>
              bg-teal-600 text-white
              px-4 py-2.5 rounded-xl
              shadow-sm hover:bg-teal-700 border-2 border-dashed
              transition">
      <?=$fileIcon?>
     
      Upload New File 
    </a>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-2xl shadow-md border border-gray-200">

    <div class="overflow-x-auto p-4">
      <table id="filesTable"
             class="min-w-full text-sm text-left text-gray-700 py-5">

        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
          <tr>
            <th class="px-4 py-3">File Name
               <span class="text-gray-400 normal-case">(click to expand)</span>
            </th>
            <th class="px-4 py-3">
              Description
              <span class="text-gray-400 normal-case">(click to expand)</span>
            </th>
            <th class="px-4 py-3">Category</th>
            <th class="px-4 py-3">Uploader</th>
            <th class="px-4 py-3">Uploaded At</th>
            <th class="px-4 py-3 text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
          <?php if (!empty($files)): ?>
            <?php foreach ($files as $file): ?>
              <tr class="hover:bg-gray-50 transition">

                <td class="px-4 py-3 font-medium text-gray-800">
                 
                   <div class="desc-container text-gray-600"
                       data-id="<?= $file['id'] ?>">
                    <?= htmlspecialchars($file['filename']) ?>
                  </div>
                </td>

                <td class="px-4 py-3">
                  <div class="desc-container text-gray-600"
                       data-id="<?= $file['id'] ?>">
                    <?= htmlspecialchars($file['desc'] ?? $file['description']) ?>
                  </div>
                </td>

                <td class="px-4 py-3">
                  <?= htmlspecialchars($file['category']) ?>
                </td>

                <td class="px-4 py-3 text-right">
                  <span class = 'text-stone-800'><?= htmlspecialchars($file['firstName'] . " " . $file['lastName']) ?></span> <br>
                  <span class = 'text-stone-400'><?= htmlspecialchars($file['position'] ?? $file['position']) ?></span>

                </td>

                <td class="px-4 py-3 text-gray-500">
                  <?= htmlspecialchars($file['uploadedat'] ?? $file['uploaded_at']) ?>
                </td>

                <td class="px-4 py-3">
                  <div class="flex justify-center gap-2">

                    <a href="index.php?controller=Files&action=download&file=<?= urlencode($file['filename']) ?>"
                       class="p-2 rounded-lg bg-sky-100 border border-sky-500 text-sky-500 hover:text-white  hover:bg-sky-600 transition"
                       title="Download">
                      <?= $downloadIcon ?>
                    </a>
                <?php if($_SESSION['user_level'] === '1'): ?>
                    <a href="index.php?controller=Files&action=edit&id=<?= $file['id'] ?>"
                       class="p-2 rounded-lg bg-emerald-100 border border-emerald-500 text-emerald-500 hover:text-white  hover:bg-emerald-600 transition"
                       title="Edit">
                                            <?= $editIcon ?>

                    </a>
            

                    <a href="index.php?controller=Files&action=delete&id=<?= $file['id'] ?>"
                       onclick="return confirm('Delete this file?')"
                       class="p-2 rounded-lg bg-red-50 border border-red-500 text-red-600 hover:text-white hover:bg-red-600 transition"
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
              <td colspan="6" class="text-center py-6 text-gray-500">
                No files found.
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
  $('#filesTable').DataTable({
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.desc-container').forEach(container => {
    const id = container.dataset.id;

    if (sessionStorage.getItem('desc-' + id) === 'expanded') {
      container.classList.add('expanded');
    }

    container.addEventListener('click', () => {
      container.classList.toggle('expanded');
      sessionStorage.setItem(
        'desc-' + id,
        container.classList.contains('expanded') ? 'expanded' : 'collapsed'
      );
    });
  });
});
</script>

<style>
  /* Description container */
.desc-container {
  max-width: 320px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  cursor: pointer;
}
.desc-container.expanded {
  white-space: normal;
}
.desc-container::after {
  content: '  [+]';
  color: #3b82f6;
}
.desc-container.expanded::after {
  content: '  [-]';
}


/* filename td */
.filename-container {
  max-width: 250px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  cursor: pointer;
}

.filename.expanded {
  white-space: normal;
}
.filename::after {
  content: '  [+]';
  color: #3b82f6;
}
.filename.expanded::after {
  content: '  [-]';
}
</style>
