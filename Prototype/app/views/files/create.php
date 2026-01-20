<!-- include icons -->
<?php require __DIR__ . '/../partials/icons.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

  <div class="w-full max-w-3xl">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-200">

      <div class="p-6 md:p-10">

        <!-- Header -->
        <h3 class="text-2xl font-semibold text-gray-800 mb-8">
          Upload New File
        </h3>

        <form action="index.php?controller=Files&action=store"
              method="post"
              enctype="multipart/form-data"
              class="space-y-6">

          <!-- Category -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              Select Category
            </label>
            <select name="fileCategory" required
              class="w-full rounded-xl border border-gray-300
                     px-4 py-3 text-gray-800 bg-white
                     focus:outline-none focus:ring-2 focus:ring-blue-500">
              <?php if (!empty($filesCateg)): ?>
                <?php foreach ($filesCateg as $category): ?>
                  <option value="<?= htmlspecialchars($category['category']) ?>">
                    <?= htmlspecialchars($category['category']) ?>
                  </option>
                <?php endforeach; ?>
              <?php else: ?>
                <option value="">No categories available</option>
              <?php endif; ?>
            </select>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              Description
            </label>
            <input type="text"
                   name="description"
                   required
                   placeholder="Enter file description"
                   class="w-full rounded-xl border border-gray-300
                          px-4 py-3 text-gray-800
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <!-- Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
              Upload File
            </label>

            <div id="dropZone"
                 class="rounded-xl border-2  border-dashed border-gray-300
                        p-6 text-center cursor-pointer items-center
                        transition hover:border-blue-500 hover:bg-blue-50">

              <p class="text-3xl  mb-2"><?= $cloudIcon ?></p>
              <p class="font-medium text-gray-700">
                Drag & drop a file here
              </p>
              <p class="text-sm text-gray-500">
                or click to select
              </p>

              <div id="fileName" class="text-sm text-blue-600 mt-2"></div>

              <input type="file" id="file" name="file" class="hidden" required>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex flex-col md:flex-row gap-4 pt-4">

            <a href="index.php?controller=Files&action=files"
               class="w-full text-center rounded-xl
                      border border-blue-600
                      px-5 py-3 font-medium text-blue-600
                      hover:bg-blue-50 transition">
              Cancel
            </a>

            <button type="submit"
                    class="w-full rounded-xl
                           bg-blue-600 px-5 py-3
                           font-medium text-white
                           hover:bg-blue-700 transition">
              Upload File
            </button>

          </div>

        </form>

      </div>
    </div>

  </div>
</div>




<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('file');
const fileName = document.getElementById('fileName');

// Open file picker on click
dropZone.addEventListener('click', () => fileInput.click());

// Show filename when selected
fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
        fileName.textContent = `Selected: ${fileInput.files[0].name}`;
    }
});

// Drag events
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');

    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        fileName.textContent = `Selected: ${e.dataTransfer.files[0].name}`;
    }
});
</script>

<style>
#dropZone {
    cursor: pointer;
    transition: 0.2s ease-in-out;
}

#dropZone.dragover {
    background-color: #e9f5ff;
    border-color: #0d6efd;
}
</style>
