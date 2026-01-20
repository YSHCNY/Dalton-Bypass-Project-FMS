<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

  <div class="w-full max-w-4xl flex flex-col md:flex-row bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">

    <!-- Left Image Panel -->
    <div class="hidden md:block md:w-1/2 bg-blue-600 flex items-center justify-center">
      <img src=".././app/assets/img/Frame5.png" alt="Login Image" class="object-cover h-full w-full">
    </div>

    <!-- Login Form -->
    <div class="w-full md:w-1/2 p-8 md:p-12">
         <div class="w-1/3  flex my-8">
      <img src=".././app/assets/logo/symbol.png" alt="Login Image" class="object-cover h-1/2 w-1/2">
    </div>

      <h3 class="text-2xl font-semibold text-gray-800 mb-2">
       Enter your credentials
      </h3>
      <p class=" text-gray-500 mb-6">
        Login to your account
      </p>

      <?php if (!empty($error)): ?>
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-center">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" class="space-y-5">

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
          <input type="text" name="username" required
            placeholder="Enter username"
            class="w-full rounded-xl border border-gray-300
                   px-4 py-3 text-gray-800
                   focus:outline-none focus:ring-2 focus:ring-blue-500
                   transition"
          >
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
          <input type="password" name="password" required
            placeholder="Enter password"
            class="w-full rounded-xl border border-gray-300
                   px-4 py-3 text-gray-800
                   focus:outline-none focus:ring-2 focus:ring-blue-500
                   transition"
          >
        </div>

        <button type="submit"
          class="w-full rounded-xl bg-teal-600 px-4 py-3 font-medium
                 text-white hover:bg-teal-700 transition">
          Login
        </button>

      </form>

      <!-- Optional register link -->
      <!--
      <p class="text-center text-gray-500 mt-6 text-sm">
        Don't have an account? 
        <a href="index.php?controller=Auth&action=register" class="text-blue-600 font-medium hover:underline">
          Register here
        </a>
      </p>
      -->

    </div>
  </div>

</div>
