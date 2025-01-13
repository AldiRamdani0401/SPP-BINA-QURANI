<?php
$servername = "localhost";
$port = 9090;
$username = "root";
$password = "root";
$dbname = "db_spp_bina_qurani";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Data User
// $stmt = $conn->prepare("SELECT COUNT(*) FROM tb_pembayaran WHERE status = ?");
// $status = 2;
// $stmt->bind_param("i", $status);
// $stmt->execute();
// $result = $stmt->get_result();
// $belumBayar = $result->fetch_assoc()['COUNT(*)'];

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
<header class="flex flex-row bg-lime-800 py-1 justify-between shadow-2xl">
    <!-- Container 1: Logo -->
    <a href="/admin" class="select-pointer">
      <div class="flex flex-row justify-center items-center gap-2 px-2">

        <img src="http://localhost:100/images/logo/_/logo" alt="logo bina qur'ani" class="h-10">
        <div class="flex flex-col text-white text-left">
          <span class="font-semibold text-base">Portal Web SPP</span>
          <span class="text-xs">Bina Qur'ani Karawang</span>
        </div>
      </div>
    </a>
    <!-- Container 2: Notification & Circle Profile -->
    <div class="flex flex-row gap-5 px-5 items-center border">
      <button>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white">
          <path fill-rule="evenodd"
            d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z"
            clip-rule="evenodd" />
        </svg>
      </button>
      <button>
        <img src="http://localhost:100/images/students/_/students_7f52d5fd1511704e51cbe30fdb1d8924" class="h-10 rounded-full" alt="">
      </button>
    </div>
  </header>