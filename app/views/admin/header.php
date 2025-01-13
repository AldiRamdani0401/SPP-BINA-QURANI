<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPP Bina Qur'ani</title>
  <link rel="icon" type="image/png" href="http://localhost:100/images/logo/logo" />

  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* no scrollbar class */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */
    }
  </style>
  <script src="
  https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js
  "></script>
  <link href="
  https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css
  " rel="stylesheet">
</head>

<body class="h-screen flex flex-col bg-gray-50 text-gray-800 select-none overflow-hidden">
  <!-- Navbar -->
  <?php require __DIR__ . "/navbar.php"; ?>
  <main class="flex-1 flex flex-row max-h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php require __DIR__ . "/sidebar.php"; ?>