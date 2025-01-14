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

<!-- Content -->
<div class="flex flex-col w-[80%] gap-2 bg-slate-50 p-2">
  <!-- Container 1 : Banner -->
  <div class="flex flex-row justify-center bg-slate-400 shadow-8xl w-full">
    <!-- CS Image -->
    <img src="http://localhost:100/images/logo/_/cs-dashboard" class="h-40 pt-2" alt="cs">
    <!-- Admin & Date -->
    <div class="flex flex-col justify-center gap-5">
      <h1 class="text-2xl px-3 py-1 bg-lime-600 text-white text-center rounded-xl"><span class="font-normal">Selamat
          Datang</span> <span class="font-semibold">Aldi Ramdani</span></h1>
          <div id="current-date" class="text-xl px-2 py-1 bg-lime-600 text-white text-center rounded-lg"></div>
    </div>
  </div>
  <!-- Container 2 : Group -->
   <div class="flex flex-row gap-2 justify-end p-1">
    <button class="px-2 py-1 border border-blue-400 rounded-md">Overview</button>
    <button class="px-2 py-1 border rounded-md">Overview</button>
    <button class="border px-2 py-1 rounded-md">Overview</button>
   </div>
  <!-- Container 3 : Statistic -->
  <div class=" flex flex-col pt-3 gap-5 w-full h-full bg-slate-200">
    <div class="px-2 pb-1">
      <div class="py-1 text-slate-700 border-b-4 border-slate-500 text-2xl">
        <h1 class="font-medium text-2xl">Overview</h1>
      </div>
    </div>
    <!-- Sub Container 1 -->
    <div class="flex flex-row justify-center gap-5 px-2">
      <!-- Content 1 : Total Seluruh Siswa -->
      <div class="flex flex-col w-full h-fit text-white rounded-sm bg-[#7ccb44] hover:bg-[#5e9536] shadow-2xl group">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col self-center">
            <h1 class="px-5 text-center text-xl font-medium text-nowrap">Total Seluruh Siswa</h1>
            <h1 class="p-2 text-center text-4xl font-bold"><span id="total-siswa"></span> Siswa</h1>
          </div>
          <svg
            fill="currentColor"
            viewBox="0 0 20 20"
            class="h-28 self-end text-lime-600 group-hover:text-white"
          >
            <path d="M16 8c0 2.21-1.79 4-4 4s-4-1.79-4-4l.11-.94L5 5.5 12 2l7 3.5v5h-1V6l-2.11 1.06L16 8m-4 6c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z" />
          </svg>
        </div>
        <!-- Detail -->
        <div class="flex justify-end px-2 py-[1.2px] bg-lime-900 rounded-b-sm">
          <a href="admin/master-data/siswa" class="flex gap-1 items-center hover:font-medium">
            go detail
            <svg
              fill="currentColor"
              viewBox="0 0 512 512"
              class="h-5"
            >
              <path d="M224 304a16 16 0 0 1-11.31-27.31l157.94-157.94A55.7 55.7 0 0 0 344 112H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h240a56.06 56.06 0 0 0 56-56V168a55.7 55.7 0 0 0-6.75-26.63L235.31 299.31A15.92 15.92 0 0 1 224 304z" />
              <path d="M448 48H336a16 16 0 0 0 0 32h73.37l-38.74 38.75a56.35 56.35 0 0 1 22.62 22.62L432 102.63V176a16 16 0 0 0 32 0V64a16 16 0 0 0-16-16z" />
            </svg>
          </a>
        </div>
      </div>
      <!-- Content 2 : Total Sudah Bayar -->
      <div class="flex flex-col w-full h-fit text-white rounded-sm bg-[#0488c1] hover:bg-[#058ec9] shadow-2xl group">
        <div class="flex flex-row justify-between">
          <!-- Label -->
          <div class="flex flex-col self-center">
            <h1 class="px-5 text-center text-xl font-medium text-nowrap">Total Sudah Bayar</h1>
            <h1 class="p-2 text-center text-4xl font-bold"><span id="sudah-bayar"></span> Siswa</h1>
          </div>
          <div class="flex flex-row relative">
            <svg
                fill="currentColor"
                class="h-28 self-end text-blue-700 group-hover:text-white"
                viewBox="0 0 14 14"
              >
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <svg
              fill="currentColor"
              class="h-10 self-end text-blue-700 absolute top-1 right-[-10px] group-hover:text-white"
              viewBox="0 0 33 33"
            >
              <path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z" />
            </svg>
          </div>
        </div>
        <!-- Detail -->
        <div class="flex justify-end px-2 py-[1.2px] bg-[#055171] rounded-b-sm">
          <a href="admin/master-data/siswa" class="flex gap-1 items-center hover:font-medium">
            go detail
            <svg
              fill="currentColor"
              viewBox="0 0 512 512"
              class="h-5"
            >
              <path d="M224 304a16 16 0 0 1-11.31-27.31l157.94-157.94A55.7 55.7 0 0 0 344 112H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h240a56.06 56.06 0 0 0 56-56V168a55.7 55.7 0 0 0-6.75-26.63L235.31 299.31A15.92 15.92 0 0 1 224 304z" />
              <path d="M448 48H336a16 16 0 0 0 0 32h73.37l-38.74 38.75a56.35 56.35 0 0 1 22.62 22.62L432 102.63V176a16 16 0 0 0 32 0V64a16 16 0 0 0-16-16z" />
            </svg>
          </a>
        </div>
      </div>
      <!-- Content 3 : Total Belum Bayar -->
      <div class="flex flex-col w-full h-fit text-white rounded-sm bg-[#eeb407] hover:bg-[#e1af19] shadow-2xl group">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col self-center">
            <h1 class="px-5 text-center text-xl font-medium text-nowrap">Total Belum Bayar</h1>
            <h1 class="p-2 text-center text-4xl font-bold"><span id="belum-bayar"></span> Siswa</h1>
          </div>
          <div class="flex flex-row relative">
            <svg
                fill="currentColor"
                class="h-28 self-end text-yellow-600 group-hover:text-white"
                viewBox="0 0 14 14"
              >
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <div class="flex flex-row relative">
              <svg
                fill="currentColor"
                viewBox="0 0 1200 1200"
                class="h-5 self-end text-yellow-600 absolute top-[2px] right-5 group-hover:text-white"
              >
                <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm192 472c0 4.4-3.6 8-8 8H328c-4.4 0-8-3.6-8-8v-48c0-4.4 3.6-8 8-8h368c4.4 0 8 3.6 8 8v48z" />
              </svg>
              <svg
                fill="currentColor"
                class="h-10 self-end text-yellow-600 absolute top-1 right-[-10px] group-hover:text-white"
                viewBox="0 0 33 33"
              >
                <path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z" />
              </svg>
            </div>
          </div>
        </div>
        <!-- Detail -->
        <div class="flex justify-end px-2 py-[1.2px] bg-yellow-700 rounded-b-sm">
          <a href="admin/master-data/siswa" class="flex gap-1 items-center hover:font-medium">
            go detail
            <svg
              fill="currentColor"
              viewBox="0 0 512 512"
              class="h-5"
            >
              <path d="M224 304a16 16 0 0 1-11.31-27.31l157.94-157.94A55.7 55.7 0 0 0 344 112H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h240a56.06 56.06 0 0 0 56-56V168a55.7 55.7 0 0 0-6.75-26.63L235.31 299.31A15.92 15.92 0 0 1 224 304z" />
              <path d="M448 48H336a16 16 0 0 0 0 32h73.37l-38.74 38.75a56.35 56.35 0 0 1 22.62 22.62L432 102.63V176a16 16 0 0 0 32 0V64a16 16 0 0 0-16-16z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    <!-- Sub Container 2 -->
    <div class="flex flex-row justify-center gap-5 px-2">
      <!-- Content 1: Telah Verifikasi Pembayaran -->
      <div class="flex flex-col w-full h-fit text-white rounded-sm bg-[#4834cb] hover:bg-[#3b27bd] shadow-2xl group">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col self-center">
            <h1 class="px-5 text-center text-xl font-medium text-nowrap">Telah Verifikasi</h1>
            <h1 class="p-2 text-center text-4xl font-bold"><span id="telah-verifikasi"></span> Siswa</h1>
          </div>
          <div class="flex flex-row relative">
            <svg
                fill="currentColor"
                class="h-28 self-end text-[#3c2e95] group-hover:text-white"
                viewBox="0 0 14 14"
              >
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <div class="flex flex-row absolute top-1 right-1">
              <svg
                class="h-7 self-end text-[#3c2e95] group-hover:text-white"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M10.007 2.104a3 3 0 0 0-3.595 1.489L5.606 5.17a1 1 0 0 1-.436.436l-1.577.805a3 3 0 0 0-1.49 3.596l.546 1.685a1 1 0 0 1 0 .616l-.545 1.685a3 3 0 0 0 1.49 3.595l1.576.806a1 1 0 0 1 .436.436l.806 1.577a3 3 0 0 0 3.595 1.49l1.685-.546a1 1 0 0 1 .616 0l1.685.545a3 3 0 0 0 3.596-1.49l.805-1.576a1 1 0 0 1 .436-.436l1.577-.806a3 3 0 0 0 1.49-3.595l-.546-1.685a1 1 0 0 1 0-.616l.545-1.685a3 3 0 0 0-1.489-3.596l-1.577-.805a1 1 0 0 1-.436-.436l-.805-1.577a3 3 0 0 0-3.596-1.49l-1.685.546a1 1 0 0 1-.616 0l-1.685-.545zM8.193 4.503a1 1 0 0 1 1.198-.497l1.685.546a3 3 0 0 0 1.848 0l1.685-.546a1 1 0 0 1 1.199.497l.805 1.577a3 3 0 0 0 1.307 1.307l1.577.805a1 1 0 0 1 .497 1.199l-.546 1.685a3 3 0 0 0 0 1.848l.546 1.685a1 1 0 0 1-.497 1.198l-1.577.806a3 3 0 0 0-1.307 1.307l-.805 1.577a1 1 0 0 1-1.199.496l-1.685-.545a3 3 0 0 0-1.848 0l-1.685.545a1 1 0 0 1-1.198-.496l-.806-1.577a3 3 0 0 0-1.307-1.307l-1.577-.806a1 1 0 0 1-.496-1.198l.545-1.685a3 3 0 0 0 0-1.848l-.545-1.685a1 1 0 0 1 .496-1.199l1.577-.805A3 3 0 0 0 7.387 6.08l.806-1.577zM6.76 11.757 11.002 16l7.071-7.071-1.414-1.414-5.657 5.657-2.828-2.829-1.414 1.414z" />
              </svg>
            </div>
          </div>
        </div>
        <!-- Detail -->
        <div class="flex justify-end px-2 py-[1.2px] bg-[#36298b] rounded-b-sm">
          <a href="admin/master-data/siswa" class="flex gap-1 items-center hover:font-medium">
            go detail
            <svg
              fill="currentColor"
              viewBox="0 0 512 512"
              class="h-5"
            >
              <path d="M224 304a16 16 0 0 1-11.31-27.31l157.94-157.94A55.7 55.7 0 0 0 344 112H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h240a56.06 56.06 0 0 0 56-56V168a55.7 55.7 0 0 0-6.75-26.63L235.31 299.31A15.92 15.92 0 0 1 224 304z" />
              <path d="M448 48H336a16 16 0 0 0 0 32h73.37l-38.74 38.75a56.35 56.35 0 0 1 22.62 22.62L432 102.63V176a16 16 0 0 0 32 0V64a16 16 0 0 0-16-16z" />
            </svg>
          </a>
        </div>
      </div>
      <!-- Content 2: Menunggu Verifikasi Pembayaran -->
      <div class="flex flex-col w-full h-fit text-white rounded-sm bg-[#7b69f1] hover:bg-[#614bf0] shadow-2xl group">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col self-center">
            <h1 class="px-5 text-center text-xl font-medium text-nowrap">Menunggu Verifikasi</h1>
            <h1 class="p-2 text-center text-4xl font-bold"><span id="menunggu-verifikasi"></span> Siswa</h1>
          </div>
          <div class="flex flex-row relative">
            <svg
                fill="currentColor"
                class="h-28 self-end text-[#4836bf] group-hover:text-white"
                viewBox="0 0 14 14"
              >
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <div class="flex flex-row absolute top-1 right-1">
              <svg
                fill="currentColor"
                viewBox="0 0 16 16"
                class="h-6 text-[#4836bf] group-hover:text-white"
              >
                <path d="M6.415.52a2.677 2.677 0 0 1 3.17 0l.928.68c.153.113.33.186.518.215l1.138.175a2.678 2.678 0 0 1 2.241 2.24l.175 1.138c.029.187.102.365.215.518l.68.928a2.677 2.677 0 0 1 0 3.17l-.68.928a1.186 1.186 0 0 0-.215.518l-.175 1.138a2.678 2.678 0 0 1-2.241 2.241l-1.138.175a1.186 1.186 0 0 0-.518.215l-.928.68a2.677 2.677 0 0 1-3.17 0l-.928-.68a1.186 1.186 0 0 0-.518-.215L3.83 14.41a2.678 2.678 0 0 1-2.24-2.24l-.175-1.138a1.186 1.186 0 0 0-.215-.518l-.68-.928a2.677 2.677 0 0 1 0-3.17l.68-.928a1.17 1.17 0 0 0 .215-.518l.175-1.14a2.678 2.678 0 0 1 2.24-2.24l1.138-.175c.187-.029.365-.102.518-.215l.928-.68zm2.282 1.209a1.18 1.18 0 0 0-1.394 0l-.928.68a2.67 2.67 0 0 1-1.18.489l-1.136.174a1.18 1.18 0 0 0-.987.987l-.174 1.137a2.67 2.67 0 0 1-.489 1.18l-.68.927c-.305.415-.305.98 0 1.394l.68.928c.256.348.423.752.489 1.18l.174 1.136c.078.51.478.909.987.987l1.137.174c.427.066.831.233 1.18.489l.927.68c.415.305.98.305 1.394 0l.928-.68a2.67 2.67 0 0 1 1.18-.489l1.136-.174c.51-.078.909-.478.987-.987l.174-1.137c.066-.427.233-.831.489-1.18l.68-.927c.305-.415.305-.98 0-1.394l-.68-.928a2.67 2.67 0 0 1-.489-1.18l-.174-1.136a1.18 1.18 0 0 0-.987-.987l-1.137-.174a2.67 2.67 0 0 1-1.18-.489zM6.92 6.085h.001a.75.75 0 0 1-1.342-.67c.169-.339.436-.701.849-.977C6.846 4.16 7.369 4 8 4a2.76 2.76 0 0 1 1.638.525c.502.377.862.965.862 1.725 0 .448-.115.83-.329 1.15-.205.307-.47.513-.692.662-.109.072-.22.138-.313.195l-.006.004a6.24 6.24 0 0 0-.26.16.952.952 0 0 0-.276.245.75.75 0 0 1-1.248-.832c.184-.264.42-.489.692-.661.109-.073.22-.139.313-.195l.007-.004c.1-.061.182-.11.258-.161a.969.969 0 0 0 .277-.245C8.96 6.514 9 6.427 9 6.25a.612.612 0 0 0-.262-.525A1.27 1.27 0 0 0 8 5.5c-.369 0-.595.09-.74.187a1.01 1.01 0 0 0-.34.398zM9 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
              </svg>
            </div>
          </div>
        </div>
        <!-- Detail -->
        <div class="flex justify-end px-2 py-[1.2px] bg-[#3c2d9d] rounded-b-sm">
          <a href="admin/master-data/siswa" class="flex gap-1 items-center hover:font-medium">
            go detail
            <svg
              fill="currentColor"
              viewBox="0 0 512 512"
              class="h-5"
            >
              <path d="M224 304a16 16 0 0 1-11.31-27.31l157.94-157.94A55.7 55.7 0 0 0 344 112H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h240a56.06 56.06 0 0 0 56-56V168a55.7 55.7 0 0 0-6.75-26.63L235.31 299.31A15.92 15.92 0 0 1 224 304z" />
              <path d="M448 48H336a16 16 0 0 0 0 32h73.37l-38.74 38.75a56.35 56.35 0 0 1 22.62 22.62L432 102.63V176a16 16 0 0 0 32 0V64a16 16 0 0 0-16-16z" />
            </svg>
          </a>
        </div>
      </div>
      <!-- Content 3: Permohonan Tunggakan Pembayaran -->
      <div class="flex flex-col w-full h-fit text-white rounded-sm bg-[#af1ba6] hover:bg-[#73146d] shadow-2xl group">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col self-center">
            <h1 class="px-5 text-center text-[18px] font-medium text-nowrap">Permohonan Tunggakan</h1>
            <h1 class="p-2 text-center text-4xl font-bold"><span id="menunggu-verifikasi"></span> Siswa</h1>
          </div>
          <div class="flex flex-row relative">
            <svg
                fill="currentColor"
                class="h-28 self-end text-[#73146d] group-hover:text-white"
                viewBox="0 0 14 14"
              >
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <div class="flex flex-row absolute top-1 right-1">
              <svg
                fill="currentColor"
                viewBox="0 0 24 24"
                class="h-6 text-[#73146d] group-hover:text-white"
              >
                <path d="M20 17h2v-2h-2v2m0-10v6h2V7h-2m-9 2h5.5L11 3.5V9M4 2h8l6 6v12c0 1.11-.89 2-2 2H4a2 2 0 0 1-2-2V4c0-1.11.89-2 2-2m9 16v-2H4v2h9m3-4v-2H4v2h12z" />
              </svg>
            </div>
          </div>
        </div>
        <!-- Detail -->
        <div class="flex justify-end px-2 py-[1.2px] bg-[#480c44] rounded-b-sm">
          <a href="admin/master-data/siswa" class="flex gap-1 items-center hover:font-medium">
            go detail
            <svg
              fill="currentColor"
              viewBox="0 0 512 512"
              class="h-5"
            >
              <path d="M224 304a16 16 0 0 1-11.31-27.31l157.94-157.94A55.7 55.7 0 0 0 344 112H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h240a56.06 56.06 0 0 0 56-56V168a55.7 55.7 0 0 0-6.75-26.63L235.31 299.31A15.92 15.92 0 0 1 224 304z" />
              <path d="M448 48H336a16 16 0 0 0 0 32h73.37l-38.74 38.75a56.35 56.35 0 0 1 22.62 22.62L432 102.63V176a16 16 0 0 0 32 0V64a16 16 0 0 0-16-16z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
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

  // Fungsi untuk mendapatkan nama hari
  function getDayName(dayIndex) {
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    return days[dayIndex];
  }

  // Fungsi untuk mendapatkan nama bulan
  function getMonthName(monthIndex) {
    const months = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return months[monthIndex];
  }

  // Ambil tanggal saat ini
  const today = new Date();
  const dayName = getDayName(today.getDay()); // Nama hari
  const date = today.getDate(); // Tanggal
  const monthName = getMonthName(today.getMonth()); // Nama bulan
  const year = today.getFullYear(); // Tahun

  // Format hasilnya
  const formattedDate = `
    <span class="font-normal">Hari ini </span>
    <span class="font-semibold">${dayName}, ${date} ${monthName} ${year}</span>
  `;

  // Tampilkan di dalam elemen HTML
  document.getElementById('current-date').innerHTML = formattedDate;

</script>