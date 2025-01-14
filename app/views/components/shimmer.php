<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPP Bina Qur'ani</title>
  <link rel="icon" type="image/png" href="http://localhost:100/images/logo/logo" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="
  https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js
  "></script>
  <link href="
  https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css
  " rel="stylesheet">
</head>
<!-- Shimmer -->
<style>
  .shimmer {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background:rgb(68, 101, 57);
    background-size: 800px 104px;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    animation: loading 1.2s infinite;
    z-index: 999;
  }

  @keyframes loading {
    0% {
      background-position: -800px 0;
    }
    100% {
      background-position: 800px 0;
    }
  }

  .shimmer-text {
    font-size: 24px;
    color: #999;
  }
</style>

<main class="shimmer" id="shimmer">
  <div class="flex flex-row justify-center items-center gap-2 px-2">

  <img src="http://localhost:100/images/logo/_/logo" alt="logo bina qur'ani" class="h-52">
  <div class="flex flex-col text-white text-left">
    <span class="font-semibold text-4xl">Portal Web SPP</span>
    <span class="text-3xl">Bina Qur'ani Karawang <?= $user['role']?></span>
  </div>
  </div>
</main>
</body>
<script>
const role = "<?= $user['role']?>";
  setTimeout(function() {
    window.location.href = `/${role}`;
  }, 2000);
</script>
<!-- <script src="http://localhost:100/files/js/coba"></script> -->
</html>
