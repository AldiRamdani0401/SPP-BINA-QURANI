<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

  <!-- LIBRARY -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fly-json-odm/dist/flyjson.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/reefjs@13/dist/reef.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- STYLE -->
  <link rel="stylesheet" href="<?php echo base_url(path: 'assets/css/tailwind-output.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url(path: 'assets/css/style.css') ?>">

  <!-- SCRIPT -->
  <script src="<?php echo base_url(path: 'assets/test/simple-test.js') ?>"></script>

  <title><?= $title ?></title>
</head>

<body>
  <div class="min-h-screen flex flex-col">
    <div class="no-select sticky top-0 z-20">
      <?php require __DIR__ . "/../../components/admin/navbar.php" ?>
    </div>
      <div class="flex min-w-screen flex-1">
        <aside class="no-select h-full w-72 fixed p-0 z-10" style="background:#8FA06A;">
          <?php require __DIR__ . "/../../components/admin/sidebar.php" ?>
        </aside>
        <div id="admin-content" class="flex-1 z-10">