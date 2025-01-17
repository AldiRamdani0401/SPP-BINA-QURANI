<?php require BASE_PATH . "/views/admin/header.php"; ?>

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

// Load Data Biaya SPP
$stmt = $conn->prepare("SELECT * FROM tb_biaya_spp WHERE is_deleted = 0");
$stmt->execute();
$result = $stmt->get_result();
$dataBiayaSPP = $result->fetch_all(MYSQLI_ASSOC);

// Load Data Siswa
$stmt = $conn->prepare("SELECT nomor_induk_siswa, nama_lengkap, nama_ayah, nama_ibu, tempat_lahir, tanggal_lahir, jenis_kelamin, kelas, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo_siswa FROM tb_siswa");
$stmt->execute();
$result = $stmt->get_result();
$dataSiswa = $result->fetch_all(MYSQLI_ASSOC);

?>

<style>
  input:focus {
    outline: none;
  }

  .swal-absolute {
    position: absolute !important; /* Pastikan SweetAlert absolute */
    top:10% !important;          /* Sesuaikan posisi vertikal */
    left: 50% !important;         /* Sesuaikan posisi horizontal */
    transform: translate(-50%, -50%) !important; /* Pusatkan */
    z-index: 888;                /* Pastikan di atas elemen lain */
  }


</style>
<!-- Content -->
<div class="flex flex-col w-[80%] bg-slate-50">
  <!-- Container 1 : Banner -->
  <div class="flex flex-col justify-center w-full shadow-xl">
    <h1 class="text-xl px-3 py-1 font-bold bg-[#001A6E] text-white">Pembayaran SPP - Verifikasi</h1>
    <!-- Breadcrumb -->
    <h2 class="px-3 bg-slate-100 text-sm font-medium border">Pembayaran SPP / <span class="text-blue-600">Verifikasi</span></h2>
  </div>
  <!-- Container 2 : Table -->
  <div class="w-full h-[80%] mt-5 px-2">
    <!-- Tab -->
    <div class="flex flex-row gap-2">
      <button class="px-2 py-1 bg-blue-600 text-slate-50 font-bold rounded-t-md">Menunggu Verifikasi Pembayaran</button>
      <button class="px-2 py-1 bg-slate-200 font-medium hover:bg-white text-slate-400 hover:text-blue-600 rounded-t-md">Telah Verifikasi Pembayaran</button>
      <button class="px-2 py-1 bg-slate-200 font-medium hover:bg-white text-slate-400 hover:text-blue-600 rounded-t-md">Tolak Verifikasi Pembayaran </button>
    </div>
    <div class="flex flex-col w-full h-full shadow-2xl bg-slate-100 overflow-auto rounded-r-md">
      <!-- Toolbar -->
       <!-- Tools : Document -->
      <div class="flex flex-row px-3 py-2 justify-between items-center bg-slate-400 sticky top-[0px] shadow-2xl">
        <!-- Sub-Container 1: Limit & GroupBy -->
        <div class="flex flex-col gap-1">
          <!-- Download -->
           <h1 class="text-xs font-medium bg-white text-slate-700 px-1 w-fit rounded-sm">Download :</h1>
           <div class="flex flex-row items-center h-8">
             <!-- CSV -->
            <button class="flex flex-row items-center gap-1 h-full px-1 bg-lime-300 text-sm font-medium hover:text-white hover:bg-lime-700 rounded-s-md">
              <span>CSV</span>
              <svg
                width="1.5em"
                height="1.5em"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  fillRule="evenodd"
                  d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.517 14.841a1.13 1.13 0 0 0 .401.823q.195.162.478.252.284.091.665.091.507 0 .859-.158.354-.158.539-.44.187-.284.187-.656 0-.336-.134-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.566-.21l-.621-.144a1 1 0 0 1-.404-.176.37.37 0 0 1-.144-.299q0-.234.185-.384.188-.152.512-.152.214 0 .37.068a.6.6 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.2-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.439 0-.776.15-.337.149-.527.421-.19.273-.19.639 0 .302.122.524.124.223.352.367.228.143.539.213l.618.144q.31.073.463.193a.39.39 0 0 1 .152.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.167.07-.413.07-.175 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zM.806 13.693q0-.373.102-.633a.87.87 0 0 1 .302-.399.8.8 0 0 1 .475-.137q.225 0 .398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.489-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.572.632-.195.41-.196.979v.498q0 .568.193.976.197.407.572.626.375.217.914.217.439 0 .785-.164t.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.8.8 0 0 1-.118.363.7.7 0 0 1-.272.25.9.9 0 0 1-.401.087.85.85 0 0 1-.478-.132.83.83 0 0 1-.299-.392 1.7 1.7 0 0 1-.102-.627zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879z"
                />
              </svg>
            </button>
            <!-- PDF -->
            <button class="flex flex-row items-center gap-1 h-full px-1 bg-red-300 text-sm font-medium hover:text-white hover:bg-red-700">
              <span>PDF</span>
              <svg
                width="1.5em"
                height="1.5em"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  fillRule="evenodd"
                  d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.517 14.841a1.13 1.13 0 0 0 .401.823q.195.162.478.252.284.091.665.091.507 0 .859-.158.354-.158.539-.44.187-.284.187-.656 0-.336-.134-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.566-.21l-.621-.144a1 1 0 0 1-.404-.176.37.37 0 0 1-.144-.299q0-.234.185-.384.188-.152.512-.152.214 0 .37.068a.6.6 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.2-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.439 0-.776.15-.337.149-.527.421-.19.273-.19.639 0 .302.122.524.124.223.352.367.228.143.539.213l.618.144q.31.073.463.193a.39.39 0 0 1 .152.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.167.07-.413.07-.175 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zM.806 13.693q0-.373.102-.633a.87.87 0 0 1 .302-.399.8.8 0 0 1 .475-.137q.225 0 .398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.489-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.572.632-.195.41-.196.979v.498q0 .568.193.976.197.407.572.626.375.217.914.217.439 0 .785-.164t.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.8.8 0 0 1-.118.363.7.7 0 0 1-.272.25.9.9 0 0 1-.401.087.85.85 0 0 1-.478-.132.83.83 0 0 1-.299-.392 1.7 1.7 0 0 1-.102-.627zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879z"
                />
              </svg>
            </button>
            <!-- WORD -->
            <button class="flex flex-row items-center gap-1 h-full px-1 bg-blue-300 text-sm font-medium rounded-e-md hover:text-white hover:bg-blue-700">
              <span>WORD</span>
              <svg
                width="1.5em"
                height="1.5em"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  fillRule="evenodd"
                  d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.517 14.841a1.13 1.13 0 0 0 .401.823q.195.162.478.252.284.091.665.091.507 0 .859-.158.354-.158.539-.44.187-.284.187-.656 0-.336-.134-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.566-.21l-.621-.144a1 1 0 0 1-.404-.176.37.37 0 0 1-.144-.299q0-.234.185-.384.188-.152.512-.152.214 0 .37.068a.6.6 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.2-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.439 0-.776.15-.337.149-.527.421-.19.273-.19.639 0 .302.122.524.124.223.352.367.228.143.539.213l.618.144q.31.073.463.193a.39.39 0 0 1 .152.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.167.07-.413.07-.175 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zM.806 13.693q0-.373.102-.633a.87.87 0 0 1 .302-.399.8.8 0 0 1 .475-.137q.225 0 .398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.489-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.572.632-.195.41-.196.979v.498q0 .568.193.976.197.407.572.626.375.217.914.217.439 0 .785-.164t.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.8.8 0 0 1-.118.363.7.7 0 0 1-.272.25.9.9 0 0 1-.401.087.85.85 0 0 1-.478-.132.83.83 0 0 1-.299-.392 1.7 1.7 0 0 1-.102-.627zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879z"
                />
              </svg>
            </button>
           </div>
        </div>
        <!-- Range Tanggal -->
        <div class="flex flex-row gap-2 px-2 items-center h-7 bg-slate-50 rounded-sm border">
          <span class="font-medium">Tanggal</span>
          <input type="date" class="rounded-sm px-2 h-full text-slate-800">
          <span class="font-medium">s/d</span>
          <input type="date" class="rounded-sm px-2 h-full text-slate-800">
        </div>
      </div>
      <!-- Tools : Table -->
      <div class="flex flex-row px-3 py-2 justify-between bg-slate-300 sticky top-[0px]">
        <!-- Sub-Container 1: Limit & GroupBy -->
        <div class="flex flex-row gap-2">
          <!-- Limit -->
          <div class="flex flex-row items-center gap-1 bg-white text-sm rounded-sm">
            <label for="limit" class="font-medium px-1">Data entries : </label>
            <select name="limit" id="limit" class="rounded-sm">
            </select>
          </div>
          <!-- Group By -->
          <div class="flex flex-row gap-2 text-sm rounded-sm">
            <select name="group-by" id="group-by" class="rounded-sm">
            </select>
            <div id="cont-group-by-values" class="hidden  flex flex-row gap-2">
              <select name="group-by-values" id="group-by-values" class="rounded-sm">
              </select>
              <button id="btn-reset-group-by" class="bg-red-500 text-white px-2 rounded-md">reset</button>
            </div>
          </div>
        </div>
        <!-- Sub-Container 2: Search  -->
        <div class="flex flex-row px-5 gap-2">
          <!-- Select Keyword -->
          <!-- <div class="flex flex-row gap-2 text-sm rounded-sm">
            <select name="group-by" id="group-by" class="rounded-sm">
            </select>
          </div> -->
          <!-- Input Search -->
          <div class="flex flex-row">
            <input id="input-search" type="text" class="px-2 text-sm rounded-l-sm" placeholder="Cari data siswa..." title="Masukkan kata kunci untuk mencari data siswa. (Default: Nama Lengkap, NIS, Kelas)">
            <div class="p-1 bg-blue-800 rounded-e-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-5 text-white " viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </div>
          <!-- Button Reset: Search -->
          <!-- <button id="btn-reset-group-by" class="bg-red-500 text-white px-2 rounded-md">reset</button> -->
        </div>
      </div>
      <!-- Table -->
      <table class="text-center h-full">
        <thead class="sticky top-[59px] shadow-sm">
          <tr class="bg-lime-100 text-sm font-medium">
            <td class="border py-1">No</td>
            <td class="border py-1">Nama Biaya</td>
            <td class="border py-1">Nominal Biaya</td>
            <td class="border py-1">Keterangan</td>
            <td class="border py-1">Dibuat</td>
            <td class="border py-1">Diperbarui</td>
            <td class="border py-1">Pembuat</td>
            <td class="border py-1">Action</td>
          </tr>
        </thead>
        <tbody id="table-body">
        </tbody>
      </table>
      <!-- Pagination -->
      <div class="flex flex-row justify-between bg-slate-400 px-5 py-2 sticky bottom-0 rounded-b-md">
        <!-- load data -->
        <div id="load-data" class="flex flex-row gap-2 bg-white px-1 rounded-sm">
        </div>
        <!-- Page Button -->
        <div class="flex flex-row gap-2">
          <button id="btn-prev" class="bg-blue-800 px-2 text-white font-semibold rounded-sm">
            < </button>
              <span id="load-page" class="flex justify-center items-center px-1 bg-white rounded-sm"></span>
              <button id="btn-next" class="bg-blue-800 px-2 text-white font-semibold rounded-sm">></button>
        </div>
      </div>
    </div>
  </div>
  <!-- Container 3 : Modal-Tambah -->
  <div id="container-modal-tambah" class="flex flex-row justify-center items-center gap-5 bg-black bg-opacity-60 w-screen h-full z-40 hidden left-0 top-0">
    <!-- Container: Form Modal -->
     <?php include "tambah.php"?>
  </div>
  <!-- Container 4 : Modal-Detail -->
  <div id="container-modal-detail" class="flex flex-row justify-center items-center gap-5 bg-black bg-opacity-60 w-screen h-full z-40 hidden left-0 right-0 top-0">
    <!-- Container: Detail -->
     <?php include "detail.php"?>
  </div>
  <!-- Container 5 : Modal-Edit -->
  <div id="container-modal-edit" class="flex flex-row justify-center items-center gap-5 bg-black bg-opacity-60 w-screen h-full z-40 hidden left-0 right-0 top-0">
    <!-- Container: Detail -->
     <?php //include "edit.php"?>
  </div>
<script>
  // States
  const md_siswa = <?= json_encode($dataSiswa)?>;

  const md_biaya_spp = {
    main_datas: <?= json_encode($dataBiayaSPP) ?>,
    render: [],
    filtered_data: [],
    detail: [],
    index: 0,
    limit: 10,
    load_data: 0,
    total_data: <?= json_encode(count($dataBiayaSPP)) ?>,
    current: 1,
    total_page: 0,
    // Data Relation
    anak: function () {
          return md_siswa.find(
            (data) =>
              data.nama_ayah === this.detail.nama_lengkap ||
              data.nama_ibu === this.detail.nama_lengkap
          );
        },
    pasangan: function (pasangan, dataAnak) {
          console.log(pasangan, dataAnak);
          return this.main_datas.find(
            (data) => {
              if (data.nama_lengkap !== pasangan) {
                if (data.nama_lengkap === dataAnak.nama_ayah || data.nama_lengkap === dataAnak.nama_ibu){
                  return data;
                }
              }
            }
          );
        },
  };

  const search = {
    keyword: null,
    placholder: null,
    filter: null,
  };

  // Handlers
  function initialValues() {
    const datas = chunkArray(md_biaya_spp.main_datas, md_biaya_spp.limit);
    md_biaya_spp.index = 0;
    md_biaya_spp.render = datas[0];
    md_biaya_spp.limit = 10;
    md_biaya_spp.load_data = datas[0].length;
    md_biaya_spp.total_data = md_biaya_spp.main_datas.length;
    md_biaya_spp.current = 1;
    md_biaya_spp.total_page = datas.length;
    setLimitOption();
  }

  function chunkArray(array, chunkSize) {
    const chunks = [];
    for (let i = 0; i < array.length; i += parseInt(chunkSize)) {
      chunks.push(array.slice(i, i + parseInt(chunkSize)));
    }
    return chunks;
  }

  function Handler_Format_Date(date) {
    const months = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const dateObj = new Date(date); // Konversi string ke objek Date
    const day = dateObj.getDate(); // Ambil hari (1-31)
    const month = dateObj.getMonth(); // Ambil bulan (0-11)
    const year = dateObj.getFullYear(); // Ambil tahun (4 digit)

    return `${day} ${months[month]} ${year}`; // Format ke "15 Oktober 2025"
  }

  function Handler_Format_Datetime(date) {
    const months = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const dateObj = new Date(date); // Konversi string ke objek Date
    const day = dateObj.getDate(); // Ambil hari (1-31)
    const month = dateObj.getMonth(); // Ambil bulan (0-11)
    const year = dateObj.getFullYear(); // Ambil tahun (4 digit)

    const hours = dateObj.getHours(); // Ambil jam (0-23)
    const minutes = dateObj.getMinutes(); // Ambil menit (0-59)

    // Format angka agar selalu 2 digit
    const formattedHours = String(hours).padStart(2, "0");
    const formattedMinutes = String(minutes).padStart(2, "0");

    return `${day} ${months[month]} ${year} ${formattedHours}:${formattedMinutes}`; // Format "15 Oktober 2025 14:30"
  }

  // === Toolbar
  // ** Limit
  const limitElement = document.getElementById('limit');
  function setLimitOption() {
    console.log('custom data 1', md_biaya_spp.filtered_data);
    limitElement.innerHTML = '';
    const totalData = md_biaya_spp.filtered_data.length > 0 ? md_biaya_spp.total_data : md_biaya_spp.main_datas.length;
    console.log('total data', totalData);

    for (let i = 10; i <= totalData; i += 10) {
      const option = document.createElement('option');
      option.value = i;
      option.text = i;
      limitElement.appendChild(option);
    }
    // ** Limit Handler
    limitElement.addEventListener("change", (e) => {
      md_biaya_spp.limit = parseInt(e.target.value);
      md_biaya_spp.render = [];
      // console.log('custom data', md_biaya_spp.filtered_data.flat());
      // console.log('limit', md_biaya_spp.limit);
      const datas = md_biaya_spp.filtered_data?.length > 0 ? (md_biaya_spp.filtered_data = chunkArray(md_biaya_spp.filtered_data.flat(), md_biaya_spp.limit), md_biaya_spp.filtered_data) : chunkArray(md_biaya_spp.main_datas, md_biaya_spp.limit);
      md_biaya_spp.render = datas[0];
      md_biaya_spp.index = 0;
      md_biaya_spp.current = 1;
      md_biaya_spp.load_data = md_biaya_spp.limit;
      md_biaya_spp.total_page = datas.length;
      renderTable();
    });
  }

  // ** Group By
  const groupByElement = document.getElementById('group-by');
  function setGroupBy() {
    const disableOption = document.createElement('option');
    disableOption.value = "";
    disableOption.text = "-- Group By --";
    disableOption.setAttribute('disabled', true);
    disableOption.setAttribute('selected', true);
    groupByElement.appendChild(disableOption);

    const keys = ['jenis_kelamin', 'tempat_lahir'];
    const optionLabels = ['Jenis Kelamin', 'Tempat Lahir'];

    for (let i = 0; i < keys.length; i++) {
      const option = document.createElement('option');
      option.value = keys[i];
      option.text = optionLabels[i];
      groupByElement.appendChild(option);
    }
  }

  // ** Group By Handler
  groupByElement.addEventListener("change", (e) => {
    // set default limit
    siswa.limit = 10;

    // get elements
    const element = document.getElementById('cont-group-by-values');
    const selectElement = document.getElementById('group-by-values');

    const keyObject = e.target.value;

    element.classList.remove('hidden');
    selectElement.innerHTML = '';

    // get values for option values (no duplicate data)
    const groupByOptionValues = [...new Set(siswa.main_datas.map(data => data[keyObject]))];

    // render Group By Values
    // ** default value
    const disableOptionGroupByValues = document.createElement('option');
    disableOptionGroupByValues.value = "";
    disableOptionGroupByValues.text = "-- Group By Values --";
    disableOptionGroupByValues.setAttribute('disabled', true);
    disableOptionGroupByValues.setAttribute('selected', true);
    selectElement.appendChild(disableOptionGroupByValues);

    groupByOptionValues.forEach((value) => {
      const text = (value === 'L' || value === 'P') ? (value === 'L' ? 'Laki-Laki' : 'Perempuan') : value;
      const option = document.createElement('option');
      option.value = value;
      option.text = text;
      selectElement.appendChild(option);
    });

    selectElement.addEventListener("change", (e) => {
      const selectGroupByValue = e.target.value;
      const resultGroupBy = siswa.main_datas.filter((data) => data[keyObject] === selectGroupByValue);

      const chunkData = chunkArray(resultGroupBy, siswa.limit);
      siswa.filtered_data = chunkData;
      siswa.render = chunkData[0];
      siswa.index = 0;
      siswa.current = 1;
      siswa.load_data = resultGroupBy.length < siswa.limit ? resultGroupBy.length : siswa.limit;
      siswa.total_data = resultGroupBy.length;
      siswa.total_page = chunkData.length;
      console.log('result', chunkData);
      console.log('filtered', siswa.filtered_data);

      // set limit with filtered values
      setLimitOption();
      renderTable();
    });

    const btnReset = document.getElementById('btn-reset-group-by');
    btnReset.addEventListener('click', () => {
      e.target.value = "";
      e.target.selectedIndex = 0;
      element.classList.add('hidden');
      selectElement.innerHTML = '';
      siswa.filtered_data = [];
      initialValues();
      renderTable();
    });
  });

  // === Pagination
  function renderLoadData() {
    const element = document.getElementById('load-data');
    element.innerHTML = `
      <span id="load-data">${md_biaya_spp.load_data}</span>
      <span class="font-semibold ">of</span>
      <span>${md_biaya_spp.total_data}</span>
    `;
  }

  function renderLoadPage() {
    const element = document.getElementById('load-page');
    element.innerHTML = `
      <span class="bg-white px-1 text-sm rounded-sm">
        <span class="font-semibold">Page:</span> ${md_biaya_spp.current}
        <span class="font-semibold">of</span> ${md_biaya_spp.total_page}
      </span>
    `;
  }

  function nextPageHandle() {
    console.log('filtered', md_biaya_spp.filtered_data);
    const datas = md_biaya_spp.filtered_data.length > 0 ? md_biaya_spp.filtered_data : chunkArray(md_biaya_spp.main_datas, md_biaya_spp.limit);
    console.log(datas);
    console.log(md_biaya_spp.current);
    if (md_biaya_spp.index + 1 >= datas.length || (md_biaya_spp.filtered_data.length > 0 && (md_biaya_spp.filtered_data && md_biaya_spp.index + 1 >= md_biaya_spp.filtered_data.length))) return false;
    ++md_biaya_spp.index;
    ++md_biaya_spp.current;
    md_biaya_spp.render = md_biaya_spp.filtered_data.length > 0 ? md_biaya_spp.filtered_data[md_biaya_spp.index] : datas[md_biaya_spp.index];
    md_biaya_spp.load_data = parseInt(md_biaya_spp.load_data) + md_biaya_spp.render.length;
    console.log('jalan');
    renderTable();
  }

  function prevPageHandle() {
    const datas = chunkArray(md_biaya_spp.main_datas, md_biaya_spp.limit);
    if (md_biaya_spp.index == 0) return false;
    --md_biaya_spp.index;
    --md_biaya_spp.current;
    md_biaya_spp.render = md_biaya_spp.filtered_data.length > 0 ? md_biaya_spp.filtered_data[md_biaya_spp.index] : datas[md_biaya_spp.index];
    md_biaya_spp.load_data = md_biaya_spp.index !== 0 ? md_biaya_spp.load_data - md_biaya_spp.render.length : md_biaya_spp.limit;
    renderTable();
  }

  // === Get Elements
  function getBtnPagination() {
    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    btnPrev.addEventListener("click", prevPageHandle);
    btnNext.addEventListener("click", nextPageHandle);
  }


  function debounce(func, wait) {
    let timeout;
    return function(...args) {
      const context = this;
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), wait);
    };
  }

  // SEARCH
  function inputSearchHandle(e) {
    const searchValue = e.target.value.toLowerCase();
    let result = null;

    if (searchValue !== '') {
      if (search.filter === null) {
          // Mencari data berdasarkan nama_lengkap, nomor_induk_siswa, dan kelas
          result = siswa.main_datas.filter((data) =>
            data.nama_lengkap.toString().toLowerCase().includes(searchValue) || // Pencarian pada nama_lengkap
            data.nomor_induk_siswa.toString().toLowerCase().includes(searchValue) || // Pencarian pada nomor_induk_siswa
            data.kelas.toString().toLowerCase().includes(searchValue) // Pencarian pada kelas
          );
      } else {

      }
      // Menampilkan hasil
      if (result.length > 0) {
          console.log('Hasil Pencarian:', result);
          const dataFind = chunkArray(result, siswa.limit);
          console.log('chunk', dataFind);
            siswa.index = 0;
            siswa.current = 1;
            siswa.load_data = result.length > 10 ? siswa.limit : result.length;
            siswa.total_data = result.length;
            siswa.total_page = dataFind.length;
            siswa.filtered_data = dataFind;
            siswa.render = dataFind[0];
            renderTable();
      } else {
        console.log('Data tidak ditemukan.');
        renderTable();
      }
    } else {
      siswa.filtered_data = [];
      initialValues();
      renderTable();
    }
  }


  function getInputSearch() {
    const debouncedInputSearchHandle = debounce(inputSearchHandle, 1000);
    const element = document.getElementById('input-search');
    element.addEventListener('keyup', (e) => debouncedInputSearchHandle(e));
  }

  // === Table Data
  const tableBodyElement = document.getElementById('table-body');

  function renderTable() {
    tableBodyElement.innerHTML = "";
    md_biaya_spp.render?.map((data, index) => {
      const row = document.createElement('tr');
      const laki = md_siswa.filter((siswa) => siswa.kelas === data.nama_kelas && siswa.jenis_kelamin === 'L').length;
      const perempuan = md_siswa.filter((siswa) => siswa.kelas === data.nama_kelas && siswa.jenis_kelamin === 'P').length;
      const total = laki + perempuan;
      row.className = 'group bg-lime-50 text-sm hover:bg-blue-50';
      row.innerHTML = `
              <td class="border group-hover:font-medium">${md_biaya_spp.index == 0 ? index + 1 : (md_biaya_spp.index * md_biaya_spp.limit) + index + 1}</td>
              <td class="border group-hover:font-medium">${data.nama_biaya}</td>
              <td class="border group-hover:font-medium">${data.biaya_spp}</td>
              <td class="border group-hover:font-medium">${data.keterangan}</td>
              <td class="border group-hover:font-medium">${Handler_Format_Datetime(data.di_buat)}</td>
              <td class="border group-hover:font-medium">${Handler_Format_Datetime(data.di_perbarui)}</td>
              <td class="border group-hover:font-medium">${data.id_pembuat}</td>
              <td class="border h-full flex flex-row justify-center items-center py-1 gap-2">
                <button class="px-2 bg-lime-600 text-white rounded-md hover:bg-lime-800" onclick="loadModalDetail(${data.id})"> Detail</button>
              </td>
            `;
      tableBodyElement.appendChild(row);
    });
    renderLoadData();
    renderLoadPage();
  }

  // MODALS
  // ** Modals Tambah : Open
  function loadModalTambah() {
    const elements = document.getElementById('container-modal-tambah');
      elements.classList.remove('hidden');
      elements.classList.add('absolute');
    const swalMask = document.getElementById('swal-mask');
    if (swalMask) {
      elements.removeChild(swalMask);
    }
  }
  // ** Modals Tambah : Close
  function closeModalTambah() {
    const targetElement = document.getElementById('container-modal-tambah');
    Swal.fire({
      title: "Batal Tambah Data Siswa,<br> Anda Yakin?",
      showConfirmButton: false,
      showDenyButton: true,
      showCancelButton: true,
      cancelButtonColor: 'orange',
      denyButtonText: `Ya, Saya Yakin`,
      customClass: {
        popup: 'swal-absolute', // Tambahkan kelas kustom
      },
      backdrop: false, // Tidak perlu backdrop diaktifkan jika masker kustom sudah digunakan
      didOpen: () => {
        const element = document.createElement('div'); // Membuat elemen div
        element.setAttribute('id', 'swal-mask'); // Menetapkan ID untuk masker
        element.classList.add('h-full', 'w-full', 'bg-black', 'bg-opacity-60', 'absolute'); // Menambahkan kelas CSS
        targetElement.appendChild(element); // Menambahkan elemen ke dalam targetElement
      },
      didClose: () => {
        const swalMask = document.getElementById('swal-mask'); // Ambil masker berdasarkan ID
        if (swalMask) {
          targetElement.removeChild(swalMask); // Menghapus masker dari targetElement
        }
      }
    }).then((result) => {
      if (result.isDenied) {
        targetElement.classList.remove('absolute');
        targetElement.classList.add('hidden');
      }
    });
  }
  // ** Modals Detail : Open
  function loadModalDetail(nik) {
    // Container
    const elements = document.getElementById('container-modal-detail');
      elements.classList.remove('hidden');
      elements.classList.add('absolute');
    const swalMask = document.getElementById('swal-mask');
    if (swalMask) {
      elements.removeChild(swalMask);
    }

    // Get Detail Data
    kelas.detail = kelas.main_datas.find((data) => parseInt(data.nomor_identitas_kependudukan) === nik);
    console.log(kelas.detail);

    // Get Data Anak
    const dataAnak = kelas.anak();
    const dataPasangan = kelas.pasangan(kelas.detail.nama_lengkap, dataAnak);
    console.log(dataPasangan);

    // Get & Set Elements
    // ** Nama Lengkap Orang Tua
    const namaLengkapkelasElement = document.getElementById('nama-lengkap-value');
    namaLengkapkelasElement.innerText = kelas.detail.nama_lengkap;
    // ** NIK
    const nikkelasElement = document.getElementById('nik-kelas-value');
    nikkelasElement.innerText = kelas.detail.nomor_identitas_kependudukan;
    // ** Tempat Lahir
    const tempatLahirElement = document.getElementById('tempat-lahir-value');
    tempatLahirElement.innerText = kelas.detail.tempat_lahir;
    // ** Tanggal Lahir
    const tanggalLahir = document.getElementById('tanggal-lahir-value');
    tanggalLahir.innerText = Handler_Format_Date(kelas.detail.tanggal_lahir); // format: 15 Oktober 2025
    // ** Jenis Kelamin
    const jenisKelamin = document.getElementById('jenis-kelamin-value');
    jenisKelamin.innerText = kelas.detail.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';
    // ** Nomor Telepon
    const nomorTelepon = document.getElementById('nomor-telepon-value');
    nomorTelepon.innerText = kelas.detail.nomor_telepon;
    // ** Email
    const email = document.getElementById('email-value');
    email.innerText = kelas.detail.email;
    // ** Pekerjaan
    const pekerjaan = document.getElementById('pekerjaan-value');
    pekerjaan.innerText = kelas.detail.pekerjaan;

    // ** (Data Pasangan: NIK, Nama Lengkap, Email, Nomor Telepon)
    const labelPasangan = document.getElementById('label-pasangan');
    labelPasangan.innerText = kelas.detail.hubungan === "Ayah" ? 'Istri' : 'Suami';
    const nikPasangan = document.getElementById('nik-pasangan-value');
    nikPasangan.innerText = dataPasangan.nomor_identitas_kependudukan;
    const namaPasangan = document.getElementById('nama-lengkap-pasangan-value');
    namaPasangan.innerText = dataPasangan.nama_lengkap;
    const tempatLahirPasangan = document.getElementById('tempat-lahir-pasangan-value');
    tempatLahirPasangan.innerText = dataPasangan.tempat_lahir;
    const tanggalLahirPasangan = document.getElementById('tanggal-lahir-pasangan-value');
    tanggalLahirPasangan.innerText = Handler_Format_Date(dataPasangan.tanggal_lahir);
    const jenisKelaminPasangan = document.getElementById('jenis-kelamin-pasangan-value');
    jenisKelaminPasangan.innerText = dataPasangan.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';;
    const nomorTeleponPasangan = document.getElementById('nomor-telepon-pasangan-value');
    nomorTeleponPasangan.innerText = dataPasangan.nomor_telepon;
    const emailPasangan = document.getElementById('email-pasangan-value');
        emailPasangan.innerText = dataPasangan.email;
    const pekerjaanPasangan = document.getElementById('pekerjaan-pasangan-value');
        pekerjaanPasangan.innerText = dataPasangan.pekerjaan;
    // ** (Data Anak: NISN, Nama Lengkap, Kelas, Tempat Lahir, Tanggal Lahir)
    const nisnSiswa = document.getElementById('nisn-anak-value');
      nisnSiswa.innerText = dataAnak.nomor_induk_siswa;
    const namaLengkapAnak = document.getElementById('nama-lengkap-anak-value');
      namaLengkapAnak.innerText = dataAnak.nama_lengkap;
    const jenisKelaminAnak = document.getElementById('jenis-kelamin-anak-value');
      jenisKelaminAnak.innerText = dataAnak.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';
    const kelasAnak = document.getElementById('kelas-anak-value');
      kelasAnak.innerText = dataAnak.kelas;
    const tempatLahirAnak = document.getElementById('tempat-lahir-anak-value');
      tempatLahirAnak.innerText = dataAnak.tempat_lahir;
    const tanggalLahirAnak = document.getElementById('tanggal-lahir-anak-value');
      tanggalLahirAnak.innerText = Handler_Format_Date(dataAnak.tanggal_lahir);
    // ** Provinsi
    const provinsi = document.getElementById('provinsi-value');
    provinsi.innerText = kelas.detail.provinsi;
    // ** Kabupaten
    const kabupaten = document.getElementById('kabupaten-value');
    kabupaten.innerText = kelas.detail.kabupaten;
    // ** Kecamatan
    const kecamatan = document.getElementById('kecamatan-value');
    kecamatan.innerText = kelas.detail.kecamatan;
    // ** Desa / Kelurahan
    const desa = document.getElementById('desa-value');
    // ** RT / RW
    const rt = document.getElementById('rt-value');
    rt.innerText = kelas.detail.rt;
    const rw = document.getElementById('rw-value');
    rw.innerText = kelas.detail.rw;
    // ** Kode Post
    const kodePost = document.getElementById('kode-post-value');
    kodePost.innerText = kelas.detail.kode_pos;
    // ** Photo Profile Siswa
    const photoProfile = document.getElementById('detail-photo-profile');
    photoProfile.src = kelas.detail.photo;
  }
  // ** Modals Detail : Close
  function closeModalDetail() {
    const targetElement = document.getElementById('container-modal-detail');
    targetElement.classList.remove('absolute');
    targetElement.classList.add('hidden');
  }

  // ** Modals Edit : Open
  function loadModalEdit() {
    console.log(siswa.detail);
    const elements = document.getElementById('container-modal-edit');
          elements.classList.remove('hidden');
          elements.classList.add('absolute');
    const formEditModal = document.getElementById('form-edit-modal');
          formEditModal.setAttribute('action', `/master-data/siswa/${siswa.detail.nomor_induk_siswa}/update`);
          formEditModal.setAttribute('method', 'post');
    const swalMask = document.getElementById('swal-mask');
    if (swalMask) {
      elements.removeChild(swalMask);
    }

      // SET VALUE
      // Nama Lengkap
      const editInputNamaLengkap = document.getElementById('edit-nama-lengkap');
      editInputNamaLengkap.value = siswa.detail.nama_lengkap;
      // NISN
      const editInputNomorIndukSiswa = document.getElementById('edit-nomor-induk-siswa');
      editInputNomorIndukSiswa.value = siswa.detail.nomor_induk_siswa;
      // Tempat Lahir
      const editInputTempatLahir = document.getElementById('edit-tempat-lahir');
      editInputTempatLahir.value = siswa.detail.tempat_lahir;
      // Tanggal Lahir
      const editInputTanggalLahir = document.getElementById('edit-tanggal-lahir');
      editInputTanggalLahir.value = siswa.detail.tanggal_lahir;
      // Jenis Kelamin
      const editInputJenisKelamin = document.getElementById('edit-jenis-kelamin');
      editInputJenisKelamin.value = siswa.detail.jenis_kelamin;
      // Kelas
      const editInputKelas = document.getElementById('edit-kelas');
      editInputKelas.value = siswa.detail.kelas;
      // Data Ayah
      const ayah = dt_ayah.find((data) => data.nama_lengkap == siswa.detail.nama_ayah);
      // ** NIK
      const editInputNikAyah = document.getElementById('edit-nik-ayah');
      editInputNikAyah.value = ayah.nomor_identitas_kependudukan;
      // ** Nama Lengkap Ayah
      const editInputNamaLengkapAyah = document.getElementById('edit-nama-lengkap-ayah');
      editInputNamaLengkapAyah.value = ayah.nama_lengkap;
      // ** Email Ayah
      const editInputEmailAyah = document.getElementById('edit-email-ayah');
      editInputEmailAyah.value = ayah.email;
      // ** Nomor Telepon Ayah
      const editInputTeleponAyah = document.getElementById('edit-nomor-telepon-ayah');
      editInputTeleponAyah.value = ayah.nomor_telepon;
      // Data Ibu
      const ibu = dt_ibu.find((data) => data.nama_lengkap == siswa.detail.nama_ibu);
      // ** NIK
      const editInputNikIbu = document.getElementById('edit-nik-ibu');
      editInputNikIbu.value = ibu.nomor_identitas_kependudukan;
      // ** Nama Lengkap Ibu
      const editInputNamaIbu = document.getElementById('edit-nama-lengkap-ibu');
      editInputNamaIbu.value = ibu.nama_lengkap;
      // ** Email Ibu
      const editInputEmailIbu = document.getElementById('edit-email-ibu');
      editInputEmailIbu.value = ibu.email;
      // ** Nomor Telepon Ibu
      const editInputTeleponIbu = document.getElementById('edit-nomor-telepon-ibu');
      editInputTeleponIbu.value = ibu.nomor_telepon;
      // Data Alamat
      // ** Provinsi
      const editInputProvinsi = document.getElementById('edit-provinsi');
      editInputProvinsi.value = siswa.detail.provinsi;
      // ** Kabupaten
      const editInputKabupaten = document.getElementById('edit-kabupaten');
      editInputKabupaten.value = siswa.detail.kabupaten;
      // ** Kabupaten
      const editInputKecamatan = document.getElementById('edit-kecamatan');
      editInputKecamatan.value = siswa.detail.kecamatan;
      // ** Desa
      const editInputDesa = document.getElementById('edit-desa');
      editInputDesa.value = siswa.detail.desa;
      // ** RT
      const editInputRT = document.getElementById('edit-rt');
      editInputRT.value = siswa.detail.rt;
      // ** RW
      const editInputRW = document.getElementById('edit-rw');
      editInputRW.value = siswa.detail.rw;
      // ** Kode Post
      const editInputKodePost = document.getElementById('edit-kode-post');
      editInputKodePost.value = siswa.detail.kode_pos;
      // ** Photo Profile
      // priview image
      const editPhotoProfile = document.getElementById('edit-preview-image');
      editPhotoProfile.src = siswa.detail.photo_siswa;
      // input photo profile
      const editInputPhotoProfile = document.getElementById('edit-photo-profile');
      editInputPhotoProfile.src = siswa.detail.photo_siswa;
  }

  // DOM Load Content
  window.addEventListener("DOMContentLoaded", () => {
    // initial value
    initialValues();

    // render components
    renderTable();
    setLimitOption();
    setGroupBy();

    // get elements
    getBtnPagination();
    getInputSearch();
    // test
    // loadModalDetail(3275010101990001);
    // loadModalTambah();
  });
</script>