<?php
$servername = "localhost";
$port = 9090;
$username = "root";
$password = "root";
$dbname = "db_spp_bina_qurani";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// === Load Data Kelas
$stmt = $conn->prepare("SELECT id, nama_kelas FROM tb_kelas");
$stmt->execute();
$result = $stmt->get_result();
$dataKelas = $result->fetch_all(MYSQLI_ASSOC);

// === Load Data Ayah
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, email, nomor_telepon  FROM tb_orang_tua_siswa WHERE hubungan = ?");
$ayah = "Ayah";
$stmt->bind_param("s", $ayah);
$stmt->execute();
$result = $stmt->get_result();
$dataAyah = $result->fetch_all(MYSQLI_ASSOC);

// === Load Data Ibu
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, email, nomor_telepon  FROM tb_orang_tua_siswa WHERE hubungan = ?");
$ibu = "Ibu";
$stmt->bind_param("s", $ibu);
$stmt->execute();
$result = $stmt->get_result();
$dataIbu = $result->fetch_all(MYSQLI_ASSOC);

// === Load Data Orang Tua
$stmt = $conn->prepare("SELECT nomor_identitas_kependudukan, nama_lengkap, email, nomor_telepon, hubungan, pekerjaan, tempat_lahir, tanggal_lahir, jenis_kelamin, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo FROM tb_orang_tua_siswa");
$stmt->execute();
$result = $stmt->get_result();
$dataOrangTua = $result->fetch_all(MYSQLI_ASSOC);

// === Load Data Siswa
$stmt = $conn->prepare("SELECT nomor_induk_siswa, nama_lengkap, nama_ayah, nama_ibu, tempat_lahir, tanggal_lahir, jenis_kelamin, kelas, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo_siswa FROM tb_siswa");
$stmt->execute();
$result = $stmt->get_result();
$dataSiswa = $result->fetch_all(MYSQLI_ASSOC);

?>

<script>
  // === MASTER DATA === //
  const md_siswa = <?= json_encode($dataSiswa)?>;
  const md_ayah = <?= json_encode($dataAyah) ?>;
  const md_ibu = <?= json_encode($dataIbu) ?>;
</script>

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