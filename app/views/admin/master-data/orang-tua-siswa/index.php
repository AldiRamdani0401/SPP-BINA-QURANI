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

// Load Data Orang Tua
$stmt = $conn->prepare("SELECT nomor_identitas_kependudukan, nama_lengkap, email, nomor_telepon, hubungan, pekerjaan, tempat_lahir, tanggal_lahir, jenis_kelamin, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo FROM tb_orang_tua_siswa");
$stmt->execute();
$result = $stmt->get_result();
$dataOrangTua = $result->fetch_all(MYSQLI_ASSOC);

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
<div class="flex flex-col w-[80%] bg-slate-100">
  <!-- Container 1 : Banner -->
  <div class="flex flex-col justify-center w-full shadow-xl">
    <h1 class="text-xl px-3 py-1 font-bold bg-[#001A6E] text-white ">Master Data - Data Orang Tua Siswa</h1>
    <!-- Breadcrumb -->
    <h2 class="px-3 bg-slate-100 text-sm font-medium border">Master Data / Data Orang Tua Siswa</h2>
  </div>
  <!-- Container 2 : Table -->
  <div class="w-full h-[70%] mt-5 px-2">
    <div class="flex flex-col w-full h-full shadow-2xl overflow-auto">
      <!-- Toolbar -->
      <div class="flex flex-row px-3 py-4 justify-between bg-slate-400 sticky top-[0px] rounded-t-md">
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
        <!-- Tools : Document -->
        <div class="flex flex-row justify-center gap-5 bg-slate-400">
          <!-- Download -->
          <div class="flex flex-row items-center">
            <!-- CSV -->
            <button
              type="button"
              class="flex flex-row items-center gap-2 p-2 bg-lime-300 text-sm font-medium hover:text-white hover:bg-lime-700 rounded-md"
              onclick="loadImportFileCSV()">
              <span>Import CSV / XLSX</span>
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
          <button class="px-2 bg-blue-800 text-white rounded-md hover:bg-blue-600" onclick="loadModalTambah()"> + Tambah</button>
          <button class="px-2 bg-blue-800 text-white rounded-md hover:bg-blue-600" onclick="loadModalTambah()"> + Tambah Banyak</button>
          <!-- Range Tanggal -->
          <!-- <div class="flex flex-row gap-2 px-2 items-center h-7 bg-slate-50 rounded-sm border">
            <span class="font-medium">Tanggal</span>
            <input type="date" class="rounded-sm px-2 h-full text-slate-800">
            <span class="font-medium">s/d</span>
            <input type="date" class="rounded-sm px-2 h-full text-slate-800">
          </div> -->
        </div>
      </div>
      <!-- Table -->
      <table class="text-center h-full">
        <thead class="sticky top-[59px] shadow-sm">
          <tr class="bg-lime-100 text-sm font-medium">
            <td class="border py-1">No</td>
            <td class="border py-1">Nomor Identitas Kependudukan</td>
            <td class="border py-1">Nama Lengkap</td>
            <td class="border py-1">Pekerjaan</td>
            <td class="border py-1">Jenis Kelamin</td>
            <td class="border py-1">Nomor Telepon</td>
            <td class="border py-1">Email</td>
            <td class="border py-1">Tempat Lahir</td>
            <td class="border py-1">Tanggal Lahir</td>
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
     <?php include "edit.php"?>
  </div>
  <!-- Container 6 : Modal-Import-File -->
  <div id="container-modal-import-file" class="flex flex-row justify-center items-center gap-5 bg-black bg-opacity-60 w-screen h-full z-40 hidden left-0 right-0 top-0">
    <!-- Container: Detail -->
     <?php include "components/import.php"?>
  </div>
<script>
  // States
  const md_siswa = <?= json_encode($dataSiswa)?>;

  const orangTua = {
    main_datas: <?= json_encode($dataOrangTua) ?>,
    render: [],
    filtered_data: [],
    detail: [],
    index: 0,
    limit: 10,
    load_data: 0,
    total_data: <?= json_encode(count($dataOrangTua)) ?>,
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
              if (data?.nama_lengkap !== pasangan) {
                if (data?.nama_lengkap === dataAnak?.nama_ayah || data?.nama_lengkap === dataAnak?.nama_ibu){
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
  // *** INITIAL VALUES *** //
  function initialValues() {
    const datas = chunkArray(orangTua.main_datas, orangTua.limit);
    orangTua.index = 0;
    orangTua.render = datas[0];
    orangTua.limit = 10;
    orangTua.load_data = datas[0].length;
    orangTua.total_data = orangTua.main_datas.length;
    orangTua.current = 1;
    orangTua.total_page = datas.length;
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

  // *** LOAD IMPORT FILE CSV
  function loadImportFileCSV() {
    const containerImport = document.getElementById("container-modal-import-file");
          containerImport.classList.remove("hidden");
          containerImport.classList.add("absolute");
  }

  // === Toolbar
  // ** Limit
  const limitElement = document.getElementById('limit');
  function setLimitOption() {
    console.log('custom data 1', orangTua.filtered_data);
    limitElement.innerHTML = '';
    const totalData = orangTua.filtered_data.length > 0 ? orangTua.total_data : orangTua.main_datas.length;
    console.log('total data', totalData);

    for (let i = 10; i <= totalData; i += 10) {
      const option = document.createElement('option');
      option.value = i;
      option.text = i;
      limitElement.appendChild(option);
    }
    // ** Limit Handler
    limitElement.addEventListener("change", (e) => {
      orangTua.limit = parseInt(e.target.value);
      orangTua.render = [];
      // console.log('custom data', orangTua.filtered_data.flat());
      // console.log('limit', orangTua.limit);
      const datas = orangTua.filtered_data?.length > 0 ? (orangTua.filtered_data = chunkArray(orangTua.filtered_data.flat(), orangTua.limit), orangTua.filtered_data) : chunkArray(orangTua.main_datas, orangTua.limit);
      orangTua.render = datas[0];
      orangTua.index = 0;
      orangTua.current = 1;
      orangTua.load_data = orangTua.limit;
      orangTua.total_page = datas.length;
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
    orangTua.limit = 10;

    // get elements
    const element = document.getElementById('cont-group-by-values');
    const selectElement = document.getElementById('group-by-values');

    const keyObject = e.target.value;

    element.classList.remove('hidden');
    selectElement.innerHTML = '';

    // get values for option values (no duplicate data)
    const groupByOptionValues = [...new Set(orangTua.main_datas.map(data => data[keyObject]))];

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
      const resultGroupBy = orangTua.main_datas.filter((data) => data[keyObject] === selectGroupByValue);

      const chunkData = chunkArray(resultGroupBy, orangTua.limit);
      orangTua.filtered_data = chunkData;
      orangTua.render = chunkData[0];
      orangTua.index = 0;
      orangTua.current = 1;
      orangTua.load_data = resultGroupBy.length < orangTua.limit ? resultGroupBy.length : orangTua.limit;
      orangTua.total_data = resultGroupBy.length;
      orangTua.total_page = chunkData.length;
      console.log('result', chunkData);
      console.log('filtered', orangTua.filtered_data);

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
      orangTua.filtered_data = [];
      initialValues();
      renderTable();
    });
  });

  // === Pagination
  function renderLoadData() {
    const element = document.getElementById('load-data');
    element.innerHTML = `
      <span id="load-data">${orangTua.load_data}</span>
      <span class="font-semibold ">of</span>
      <span>${orangTua.total_data}</span>
    `;
  }

  function renderLoadPage() {
    const element = document.getElementById('load-page');
    element.innerHTML = `
      <span class="bg-white px-1 text-sm rounded-sm">
        <span class="font-semibold">Page:</span> ${orangTua.current}
        <span class="font-semibold">of</span> ${orangTua.total_page}
      </span>
    `;
  }

  function nextPageHandle() {
    console.log('filtered', orangTua.filtered_data);
    const datas = orangTua.filtered_data.length > 0 ? orangTua.filtered_data : chunkArray(orangTua.main_datas, orangTua.limit);
    console.log(datas);
    console.log(orangTua.current);
    if (orangTua.index + 1 >= datas.length || (orangTua.filtered_data.length > 0 && (orangTua.filtered_data && orangTua.index + 1 >= orangTua.filtered_data.length))) return false;
    ++orangTua.index;
    ++orangTua.current;
    orangTua.render = orangTua.filtered_data.length > 0 ? orangTua.filtered_data[orangTua.index] : datas[orangTua.index];
    orangTua.load_data = parseInt(orangTua.load_data) + orangTua.render.length;
    console.log('jalan');
    renderTable();
  }

  function prevPageHandle() {
    const datas = chunkArray(orangTua.main_datas, orangTua.limit);
    if (orangTua.index == 0) return false;
    --orangTua.index;
    --orangTua.current;
    orangTua.render = orangTua.filtered_data.length > 0 ? orangTua.filtered_data[orangTua.index] : datas[orangTua.index];
    orangTua.load_data = orangTua.index !== 0 ? orangTua.load_data - orangTua.render.length : orangTua.limit;
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
          result = orangTua.main_datas.filter((data) =>
            data.nama_lengkap.toString().toLowerCase().includes(searchValue) || // Pencarian pada nama_lengkap
            data.nomor_identitas_kependudukan.toString().toLowerCase().includes(searchValue) // Pencarian pada nomor_induk_siswa
          );
      } else {

      }
      // Menampilkan hasil
      if (result.length > 0) {
          console.log('Hasil Pencarian:', result);
          const dataFind = chunkArray(result, orangTua.limit);
          console.log('chunk', dataFind);
            orangTua.index = 0;
            orangTua.current = 1;
            orangTua.load_data = result.length > 10 ? orangTua.limit : result.length;
            orangTua.total_data = result.length;
            orangTua.total_page = dataFind.length;
            orangTua.filtered_data = dataFind;
            orangTua.render = dataFind[0];
            renderTable();
      } else {
        console.log('Data tidak ditemukan.');
        renderTable();
      }
    } else {
      orangTua.filtered_data = [];
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
    orangTua.render?.map((data, index) => {
      const row = document.createElement('tr');
      row.className = 'group bg-lime-50 text-sm hover:bg-blue-50';
      row.innerHTML = `
              <td class="border group-hover:font-medium">${orangTua.index == 0 ? index + 1 : (orangTua.index * orangTua.limit) + index + 1}</td>
              <td class="border group-hover:font-medium">${data.nomor_identitas_kependudukan}</td>
              <td class="border group-hover:font-medium">${data.nama_lengkap}</td>
              <td class="border group-hover:font-medium">${data.pekerjaan}</td>
              <td class="border group-hover:font-medium">${data.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan'}</td>
              <td class="border group-hover:font-medium">${data.nomor_telepon}</td>
              <td class="border group-hover:font-medium">${data.email}</td>
              <td class="border group-hover:font-medium">${data.tempat_lahir}</td>
              <td class="border group-hover:font-medium">${data.tanggal_lahir}</td>
              <td class="border h-full flex flex-row justify-center items-center py-1 gap-2">
                <button class="px-2 bg-lime-600 text-white rounded-md hover:bg-lime-800" onclick="loadModalDetail(${data.nomor_identitas_kependudukan})"> Detail</button>
              </td>
            `;
      tableBodyElement.appendChild(row);
    });
    renderLoadData();
    renderLoadPage();
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
    // loadModalEdit(3275010101990004);
    // loadModalTambah();
    loadImportFileCSV();
  });
</script>