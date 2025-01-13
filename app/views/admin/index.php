<?php require __DIR__ . "/header.php"; ?>
<?php
// Total Siswa
$stmt = $conn->prepare("SELECT COUNT(*) FROM tb_siswa");
$stmt->execute();
$result = $stmt->get_result();
$totalSiswa = $result->fetch_assoc()['COUNT(*)'];

// Total Sudah Bayar
$stmt = $conn->prepare("SELECT COUNT(*) FROM tb_pembayaran WHERE status = ?");
$status = 1;
$stmt->bind_param("i", $status);
$stmt->execute();
$result = $stmt->get_result();
$sudahBayar = $result->fetch_assoc()['COUNT(*)'];

// Total Belum Bayar
$stmt = $conn->prepare("SELECT COUNT(*) FROM tb_pembayaran WHERE status = ?");
$status = 2;
$stmt->bind_param("i", $status);
$stmt->execute();
$result = $stmt->get_result();
$belumBayar = $result->fetch_assoc()['COUNT(*)'];


?>

<?php require __DIR__ . "/shimmer.php"; ?>

<!-- Content -->
<div class="flex flex-col w-[80%]">
  <!-- Container 1 : Banner -->
  <div class="flex flex-row justify-center bg-lime-500 hover:bg-[#47663B] w-full">
    <!-- CS Image -->
    <img src="http://localhost:100/images/logo/_/cs-dashboard" class="h-40 pt-2" alt="cs">
    <!-- Admin & Date -->
    <div class="flex flex-col justify-center gap-5">
      <h1 class="text-2xl px-3 py-1 bg-lime-600 text-white text-center rounded-xl"><span class="font-normal">Selamat
          Datang</span> <span class="font-semibold">Aldi Ramdani</span></h1>
      <h1 class="text-xl px-2 py-1 bg-lime-600 text-white text-center rounded-lg"><span class="font-normal">Hari ini
        </span> <span class="font-semibold">Minggu, 12 Januari 2025</span></h1>
    </div>
  </div>
  <!-- Container 2 : Statistic -->
  <div class=" flex flex-col py-2 gap-5 w-full h-full bg-lime-800">
    <!-- Sub Container 1 : Master Data -->
    <div class="flex flex-row justify-center gap-5 px-2">
      <!-- Content 1 : Total Data Siswa -->
      <div class="flex flex-col gap-6 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <h1 class="px-2 py-2 bg-lime-600 text-center font-medium">Total Seluruh Siswa</h1>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"> <span id="total-siswa"></span> Siswa</h1>
      </div>
      <!-- Content 2 : Total Sudah Bayar -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Total Sudah Bayar</h1>
          <h1 class="text-sm font-normal">( Seluruh Siswa )</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="sudah-bayar"></span> Siswa</h1>
      </div>
      <!-- Content 3: Total Belum Bayar -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Total Belum Bayar</h1>
          <h1 class="text-sm font-normal">( Seluruh Siswa )</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="belum-bayar"></span> Siswa</h1>
      </div>
      <!-- Content 4: Menunggu Verifikasi Pembayaran -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Menunggu Verifikasi</h1>
          <h1 class="text-sm font-normal">( Seluruh Siswa )</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="menunggu-verifikasi"></span> Siswa</h1>
      </div>
      <!-- Content 5: Permohonan Tunggakan Pembayaran -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Permohonan</h1>
          <h1 class="text-sm font-normal">Tunggakan Pembayaran</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="permohonan-tunggakan"></span> Siswa</h1>
      </div>
    </div>
    <!-- Sub Container 2 : Master Data -->
    <div class="flex flex-row justify-center gap-5 px-2">
      <!-- Content 1 : Total Data Siswa -->
      <div class="flex flex-col gap-6 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <h1 class="px-2 py-2 bg-lime-600 text-center font-medium">Total Seluruh Siswa</h1>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"> <span id="total-siswa"></span> Siswa</h1>
      </div>
      <!-- Content 2 : Total Sudah Bayar -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Total Sudah Bayar</h1>
          <h1 class="text-sm font-normal">( Seluruh Siswa )</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="sudah-bayar"></span> Siswa</h1>
      </div>
      <!-- Content 3: Total Belum Bayar -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Total Belum Bayar</h1>
          <h1 class="text-sm font-normal">( Seluruh Siswa )</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="belum-bayar"></span> Siswa</h1>
      </div>
      <!-- Content 4: Menunggu Verifikasi Pembayaran -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Menunggu Verifikasi</h1>
          <h1 class="text-sm font-normal">( Seluruh Siswa )</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="menunggu-verifikasi"></span> Siswa</h1>
      </div>
      <!-- Content 5: Permohonan Tunggakan Pembayaran -->
      <div class="flex flex-col gap-5 text-white rounded-lg py-3 bg-lime-700 shadow-xl">
        <div class="flex flex-col px-2 bg-lime-600 text-center font-medium">
          <h1>Permohonan</h1>
          <h1 class="text-sm font-normal">Tunggakan Pembayaran</h1>
        </div>
        <h1 class="p-2 bg-lime-600 text-center text-xl font-bold"><span id="permohonan-tunggakan"></span> Siswa</h1>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . "/footer.php"; ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    function animateValue(id, start, end, duration) {
      const obj = document.getElementById(id);
      const range = end - start;
      let startTime = null;

      function step(timestamp) {
        if (!startTime) startTime = timestamp;
        const progress = Math.min((timestamp - startTime) / duration, 1);
        obj.innerHTML = Math.floor(progress * range + start);
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      }

      window.requestAnimationFrame(step);
    }

    animateValue("total-siswa", 0, <?= $totalSiswa ?>, 2800);
    animateValue("sudah-bayar", 0, <?= $sudahBayar ?>, 2800);
    animateValue("belum-bayar", 0, <?= $belumBayar ?>, 2800);
    animateValue("menunggu-verifikasi", 0, <?= $totalSiswa ?>, 2800);
    animateValue("permohonan-tunggakan", 0, <?= $totalSiswa ?>, 2800);
  });
</script>