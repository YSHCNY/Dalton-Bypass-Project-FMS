<div class="min-h-screen flex items-center justify-center px-4">

  <div class="w-full max-w-4xl">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-200">

      <div class="p-6 md:p-10">

        <h3 class="text-2xl font-semibold text-gray-800 mb-8">
          Create a User
        </h3>

        <?php if (!empty($error)): ?>
          <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-center">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-6">

          <!-- Name + Position -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                First Name
              </label>
              <input
                type="text"
                name="firstName"
                required
                placeholder="Enter first name"
                class="w-full rounded-xl border border-gray-300
                       px-4 py-3 text-gray-800
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                Last Name
              </label>
              <input
                type="text"
                name="lastName"
                required
                placeholder="Enter last name"
                class="w-full rounded-xl border border-gray-300
                       px-4 py-3 text-gray-800
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                Position
              </label>
              <input
                type="text"
                name="position"
                required
                placeholder="Enter position"
                class="w-full rounded-xl border border-gray-300
                       px-4 py-3 text-gray-800
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
            </div>

          </div>

          <!-- Username -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              Username
            </label>
            <input
              type="text"
              name="username"
              required
              placeholder="Choose a username"
              class="w-full rounded-xl border border-gray-300
                     px-4 py-3 text-gray-800
                     focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              Password
            </label>
            <input
              type="password"
              name="password"
              required
              placeholder="Create a password"
              class="w-full rounded-xl border border-gray-300
                     px-4 py-3 text-gray-800
                     focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
          </div>

          <!-- Confirm Password -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              Confirm Password
            </label>
            <input
              type="password"
              name="confirm_password"
              required
              placeholder="Re-enter password"
              class="w-full rounded-xl border border-gray-300
                     px-4 py-3 text-gray-800
                     focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
          </div>

          <!-- User Level -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
              User Level
            </label>
            <select
              name="user_level"
              required
              class="w-full rounded-xl border border-gray-300
                     px-4 py-3 text-gray-800
                     focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
            >
              <option value="1">Admin</option>
              <option value="2">Encoder</option>
              <option value="3">Viewer</option>
            </select>
          </div>

          <!-- Actions -->
          <div class="flex flex-col md:flex-row gap-4 pt-4">

            <a href="index.php?controller=Files&action=files"
               class="w-full text-center
                      rounded-xl border border-blue-600
                      px-5 py-3 font-medium text-blue-600
                      hover:bg-blue-50 transition">
              Cancel Creation
            </a>

            <button type="submit"
                    class="w-full rounded-xl
                           bg-blue-600 px-5 py-3
                           font-medium text-white
                           hover:bg-blue-700 transition">
              Create User
            </button>

          </div>

        </form>

      </div>
    </div>

  </div>

</div>
