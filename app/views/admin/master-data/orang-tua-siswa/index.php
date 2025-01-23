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
        <button class="px-2 bg-blue-800 text-white rounded-md hover:bg-blue-600" onclick="loadModalTambah()"> + Tambah</button>
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
     <?php //include "edit.php"?>
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
      title: "Batal Tambah Data Orang Tua,<br> Anda Yakin?",
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
    orangTua.detail = orangTua.main_datas.find((data) => parseInt(data.nomor_identitas_kependudukan) === nik);
    console.log(orangTua.detail);

    // Get Data Anak
    const dataAnak = orangTua.anak();
    const dataPasangan = orangTua.pasangan(orangTua.detail.nama_lengkap, dataAnak);
    console.log(dataPasangan);

    // Get & Set Elements
    // ** Nama Lengkap Orang Tua
    const namaLengkapOrangTuaElement = document.getElementById('nama-lengkap-value');
    namaLengkapOrangTuaElement.innerText = orangTua.detail.nama_lengkap;
    // ** NIK
    const nikOrangTuaElement = document.getElementById('nik-orangtua-value');
    nikOrangTuaElement.innerText = orangTua.detail.nomor_identitas_kependudukan;
    // ** Tempat Lahir
    const tempatLahirElement = document.getElementById('tempat-lahir-value');
    tempatLahirElement.innerText = orangTua.detail.tempat_lahir;
    // ** Tanggal Lahir
    const tanggalLahir = document.getElementById('tanggal-lahir-value');
    tanggalLahir.innerText = Handler_Format_Date(orangTua.detail.tanggal_lahir); // format: 15 Oktober 2025
    // ** Jenis Kelamin
    const jenisKelamin = document.getElementById('jenis-kelamin-value');
    jenisKelamin.innerText = orangTua.detail.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';
    // ** Hubungan
    // const jenisKelamin = document.getElementById('jenis-kelamin-value');
    // jenisKelamin.innerText = orangTua.detail.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';
    // ** Nomor Telepon
    const nomorTelepon = document.getElementById('nomor-telepon-value');
    nomorTelepon.innerText = orangTua.detail.nomor_telepon;
    // ** Email
    const email = document.getElementById('email-value');
    email.innerText = orangTua.detail.email;
    // ** Pekerjaan
    const pekerjaan = document.getElementById('pekerjaan-value');
    pekerjaan.innerText = orangTua.detail.pekerjaan;

    // ** (Data Pasangan: NIK, Nama Lengkap, Email, Nomor Telepon)
    const labelPasangan = document.getElementById('label-pasangan');
    labelPasangan.innerText = orangTua.detail.hubungan === "Ayah" ? 'Istri' : 'Suami';
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
  provinsi.innerText = orangTua.detail.provinsi;
  // ** Kabupaten
  const kabupaten = document.getElementById('kabupaten-value');
  kabupaten.innerText = orangTua.detail.kabupaten;
  // ** Kecamatan
  const kecamatan = document.getElementById('kecamatan-value');
  kecamatan.innerText = orangTua.detail.kecamatan;
  // ** Desa / Kelurahan
  const desa = document.getElementById('desa-value');
  desa.innerText = orangTua.detail.desa;
  // ** RT / RW
  const rt = document.getElementById('rt-value');
  rt.innerText = orangTua.detail.rt;
  const rw = document.getElementById('rw-value');
  rw.innerText = orangTua.detail.rw;
  // ** Kode Post
  const kodePost = document.getElementById('kode-post-value');
  kodePost.innerText = orangTua.detail.kode_pos;
  // ** Photo Profile Siswa
  const photoProfile = document.getElementById('detail-photo-profile');
  photoProfile.src = orangTua.detail.photo;
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
    // loadModalDetail(3275010101990004);
    // loadModalTambah();
  });
</script>