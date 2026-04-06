<!-- include icons -->
<?php require __DIR__ . '/../partials/icons.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

  <div class="w-full max-w-3xl">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-200">

      <div class="p-6 md:p-10">

        <!-- Header -->
        <h3 class="text-2xl font-semibold text-gray-800 mb-8">
          Edit File Information
        </h3>

        <form action="index.php?controller=Files&action=update"
              method="post"
              enctype="multipart/form-data"
              class="space-y-6">

          <!-- Hidden ID -->
          <input type="hidden" name="id"
                 value="<?= htmlspecialchars($file['id']) ?>">

   


          
          <!-- relationship recipient -->
<div class="grid grid-cols-[1fr_auto_1fr] gap-4 items-end">
  
  <!-- LEFT SELECT -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-1">
      From
    </label>
    <select name="fromCategory" required
      class="w-full rounded-xl border border-gray-300
             px-4 py-3 text-gray-800 bg-white
             focus:outline-none focus:ring-2 focus:ring-blue-500">
        

        <?php foreach ($recipientsCateg as $category): ?>
            <option
              value="<?= htmlspecialchars($category['category']) ?>"
              <?= $category['category'] === $file['directionFrom'] ? 'selected' : '' ?>
            >
              <?= htmlspecialchars($category['category']) ?>
            </option>
          <?php endforeach; ?>
    </select>
  </div>

  <!-- CENTER ICON -->
  <div class="flex items-center justify-center pb-3 ">
    <span class="text-gray-500 text-xl">
      <?= $viseVersaIcon ?>
    </span>
  </div>

  <!-- RIGHT SELECT -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-1">
      To
    </label>
    <select name="toCategory" required
      class="w-full rounded-xl border border-gray-300
             px-4 py-3 text-gray-800 bg-white
             focus:outline-none focus:ring-2 focus:ring-blue-500">
          

        <?php foreach ($recipientsCateg as $category): ?>
            <option
              value="<?= htmlspecialchars($category['category']) ?>"
              <?= $category['category'] === $file['directionTo'] ? 'selected' : '' ?>
            >
              <?= htmlspecialchars($category['category']) ?>
            </option>
          <?php endforeach; ?>
    </select>
  </div>

</div>



          <!-- Category -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              Category
            </label>
            <select name="fileCategory" required
              class="w-full rounded-xl border border-gray-300
                     px-4 py-3 bg-white text-gray-800
                     focus:outline-none focus:ring-2 focus:ring-sky-500">
              <?php foreach ($filesCateg as $category): ?>
                <option value="<?= htmlspecialchars($category['category']) ?>"
                  <?= $category['category'] === $file['category'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($category['category']) ?>
                </option>
              <?php endforeach; ?>
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
                   value="<?= htmlspecialchars($file['desc']) ?>"
                   placeholder="Enter file description"
                   class="w-full rounded-xl border  border-gray-300
                          px-4 py-3 text-gray-800
                          focus:outline-none focus:ring-2 focus:ring-sky-500" >
          </div>


                 <!-- Drag & Drop File Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
              Replace File (optional)
            </label>

            <div id="dropZone" 
                 class="w-full rounded-xl border border-gray-300
                        bg-gray-50 text-gray-600 text-center
                        px-4 py-10 cursor-pointer
                        hover:bg-sky-50 transition">
              <p class="text-2xl mb-2"><?= $cloudIcon ?? '☁️' ?></p>
              <p class="font-medium mb-1">Drag & drop a file here</p>
              <p class="text-sm text-gray-400 mb-2">or click to select</p>
              <div id="fileName" class="text-sky-600 text-sm"></div>
              <input type="file" name="file" id="fileInput" class="hidden">
            </div>

            <?php if (!empty($file['filename'])): ?>
              <p class="mt-2 text-sm text-gray-500">
                Current file:
                <a href="index.php?controller=Files&action=download&file=<?= urlencode($file['filename']) ?>"
                   class="text-sky-600 hover:underline">
                  <?= htmlspecialchars($file['filename']) ?>
                </a>
              </p>
            <?php endif; ?>
          </div>



          <!-- Actions -->
          <div class="flex flex-col md:flex-row gap-4 pt-4">

            <a href="index.php?controller=Files&action=files"
               class="w-full text-center rounded-xl
                      border border-sky-600
                      px-5 py-3 font-medium text-sky-600
                      hover:bg-sky-50 transition">
              Cancel
            </a>

            <button type="submit"
                    class="w-full rounded-xl
                           bg-sky-600 px-5 py-3
                           font-medium text-white
                           hover:bg-sky-700 transition">
              Save Changes
            </button>

          </div>

        </form>

      </div>
    </div>

  </div>
</div>

<!-- Drag & Drop JS -->
<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const fileName = document.getElementById('fileName');

// Click to open file picker
dropZone.addEventListener('click', () => fileInput.click());

// Show selected file name
fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
        fileName.textContent = `Selected: ${fileInput.files[0].name}`;
    }
});

// Drag over styling
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('bg-sky-50', 'border-sky-400');
});

// Remove styling on leave
dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('bg-sky-50', 'border-sky-400');
});

// Drop file
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('bg-sky-50', 'border-sky-400');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        fileName.textContent = `Selected: ${e.dataTransfer.files[0].name}`;
    }
});
</script>
