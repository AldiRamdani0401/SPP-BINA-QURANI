<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fly-json-odm/dist/flyjson.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/reefjs@13/dist/reef.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="<?= base_url(path: 'assets/css/style.css') ?>">
  <title><?= $title ?></title>
</head>

<body>
  <div class="d-flex flex-column" style="height:100%;width:100%;">
    <div class="no-select align-self-start sticky-top" style="width:100%;z-index:3333;">
      <?php require __DIR__ . "/../../components/admin/navbar.php" ?>
    </div>
    <div class="container-fluid p-0 d-flex flex-col" style="height:100%;">
      <div class="d-flex flex-row">
        <div id="sidebar" class="no-select d-none d-md-block p-0" style="background:#8FA06A;position:fixed; height:100%;border:1px solid red;">
          <?php require __DIR__ . "/../../components/admin/sidebar.php" ?>
        </div>
        <div id="admin-content" style="border:1px solid red;">