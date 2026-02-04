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
    <th>
      File Name</th>
    <th>
      Description</th>
    <th>
      Category</th>
    <th>
      Direction</th>
    <th>
      Uploader</th>
    <th>
      Uploaded At
      
    </th>
    <th class="text-center">
      Action
    </th>
  </tr>

  <tr>
      <th><div class="header-filter"></div></th>
      <th><div class="header-filter"></div></th>
      <th><div class="header-filter"></div></th>
      <th><div class="header-filter"></div></th>
      <th><div class="header-filter"></div></th>
      <th><div class="header-filter"></div></th>
      <th><div class="header-filter"></div></th>

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
                  <p class = 'inline-block bg-green-200 text-green-800 
          px-2 py-0.5 rounded-full text-sm leading-none'><?= htmlspecialchars($file['category']) ?></p>
                </td>

                <td class="px-4 py-3">
                  <?= htmlspecialchars($file['direction'] ?? 'No Direction') ?>
                </td>

              

                <td class="px-4 py-3 text-right">
                  <span class = 'text-stone-800'><?= htmlspecialchars($file['firstName'] . ' ' . $file['lastName']) ?></span> <br>
                  <span class = 'text-stone-400'><?= htmlspecialchars($file['position']) ?></span>

                </td>

                <td class="px-4 py-3 text-gray-500">
                
                <p class="text-sm text-gray-500 leading-tight">
                  <?= date('M j, Y', strtotime($file['uploadedat'])) ?><br>
                  <span class="text-xs text-gray-400">
                    <?= date('g:i A', strtotime($file['uploadedat'])) ?>
                  </span>
                </p>
                                
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
  const table = $('#filesTable').DataTable({
    pageLength: 50,
    order: [[5, 'desc']],
    responsive: true,
    orderCellsTop: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search files..."
    },
    initComplete: function () {
      const api = this.api();

      // Create dropdowns for Category (2) and Direction (3)
      [2, 3].forEach(function(colIndex) {
        createDropdown(api, colIndex);
      });

      // Update dropdowns whenever table redraws (filters applied)
      api.on('draw', function() {
        updateDropdowns(api);
      });
    }
  });

  // -----------------------------
  // Create a dropdown in the second header row
  function createDropdown(api, columnIndex) {
    const column = api.column(columnIndex);
    const headerFilterTh = $(column.header()).closest('table')
                                .find('thead tr:eq(1) th').eq(columnIndex);

    const select = $('<select class="column-filter"><option value="">All</option></select>')
      .appendTo(headerFilterTh)
      .on('change', function() {
        const val = $.fn.dataTable.util.escapeRegex($(this).val());
        column.search(val ? '^' + val + '$' : '', true, false).draw();
      });

    populateDropdown(column, select);
  }

  // Populate dropdown with unique text from column
  function populateDropdown(column, select) {
    const values = column.nodes().to$()
      .map(function() { return $(this).text().trim(); })
      .get()
      .filter((v, i, a) => v && a.indexOf(v) === i)
      .sort();

    select.empty().append('<option value="">All</option>');
    values.forEach(v => select.append(`<option value="${v}">${v}</option>`));
  }

  // Update dropdowns based on currently visible rows
  function updateDropdowns(api) {
    const visibleRows = api.rows({ search: 'applied' }).nodes();

    [2, 3].forEach(function(colIndex) {
      const column = api.column(colIndex);
      const headerFilterTh = $(column.header()).closest('table')
                                  .find('thead tr:eq(1) th').eq(colIndex);
      const select = headerFilterTh.find('select');
      const selected = select.val();

      // Get unique values from visible rows
      const values = $(visibleRows)
        .map(function() { return $(this).find('td').eq(colIndex).text().trim(); })
        .get()
        .filter((v, i, a) => v && a.indexOf(v) === i)
        .sort();

      // Repopulate dropdown and keep selection
      select.empty().append('<option value="">All</option>');
      values.forEach(v => select.append(`<option value="${v}">${v}</option>`));
      select.val(selected);
    });
  }
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
  .column-filter {
  width: 100%;
  padding: 4px 6px;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  font-size: 0.75rem;
}


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
  max-width: 200px;
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
