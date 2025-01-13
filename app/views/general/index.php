<?php require __DIR__ . "/header.php"; ?>
<!-- Content -->
<div class=" flex-1 flex flex-row">
  <!-- Side 1 : Logo -->
  <aside class="flex flex-row justify-center items-center gap-2 text-3xl bg-lime-800 w-[60%]">
    <img src="http://localhost:100/images/logo/_/logo" alt="logo bina qur'ani" class="h-52">
    <div class="flex flex-col justify-start text-white text-left">
      <span class="font-semibold text-4xl">Portal Web SPP</span>
      <span class="text-2xl">Bina Qur'ani Karawang</span>
    </div>
  </aside>
  <!-- Side 2 : Login -->
  <aside class="flex-grow p-10 border">
    <form class="flex flex-col py-36 gap-5 h-full" method="POST" action="/login">
      <?php
      $error = isset($_GET['error']) && $_GET['error'] == 1;
      ?>
      <!-- Form Header -->
      <div class="flex flex-col gap-3 relative w-full">
        <div
          class="<?= $error ? 'absolute' : 'hidden'; ?> p-2 bg-red-500 text-white font-medium text-center top-[-50px] w-full">
          <span>ERROR : Invalid Email & Password</span>
          <button type="button"
            class="absolute flex items-center justify-center bg-red-600 rounded-lg px-2 hover:bg-red-500 top-[-30px] right-[-10px]"
            onclick="window.location.href='/'">Close</button>
        </div>
        <h1 class="text-4xl font-bold">Log In</h1>
        <hr class="border-b-slate-500 border-b-4 rounded-full">
      </div>
      <!-- Input Form: Email -->
      <div class="flex flex-col gap-1">
        <label for="email" id="email-label" class="text-2xl font-medium">Email Address</label>
        <input type="email" id="email" name="email"
          class="border rounded-sm p-1 focus:outline-none focus:ring-1 focus:ring-blue-300"
          placeholder="Please enter your email" required>
      </div>
      <!-- Input Form: Password -->
      <div class="flex flex-col gap-1">
        <label for="password" id="password-label" class="text-2xl font-medium">Password</label>
        <input type="password" id="password" name="password"
          class="border rounded-sm p-1 focus:outline-none focus:ring-1 focus:ring-blue-300"
          placeholder="Please enter your password" required>
      </div>
      <!-- Button -->
      <button
        class="bg-blue-600 py-2 rounded-sm text-white font-medium hover:font-bold hover:bg-blue-700">Login</button>
    </form>
  </aside>
</div>
<?php require __DIR__ . "/footer.php"; ?>