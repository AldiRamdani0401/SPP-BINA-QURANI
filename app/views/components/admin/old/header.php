<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/fly-json-odm/dist/flyjson.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/reefjs@13/dist/reef.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="<?= base_url(path: 'assets/css/style.css') ?>">
  <title><?= $title ?></title>
</head>

<body>
  <div class="flex flex-col">
    <div class="no-select sticky-top">
      <?php require __DIR__ . "/../../components/admin/navbar.php" ?>
    </div>
    <div class="container-fluid p-0 flex flex-col h-full">
      <div class="flex flex-row justify-between">
        <div id="sidebar" class="no-select d-none d-md-block p-0" style="background:#8FA06A;position:fixed; height:100%;border:1px solid red;">
          <?php require __DIR__ . "/../../components/admin/sidebar.php" ?>
        </div>
        <div id="admin-content" style="border:1px solid red;"></div>