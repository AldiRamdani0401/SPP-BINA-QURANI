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

// Load Data Siswa
$stmt = $conn->prepare("SELECT nomor_induk_siswa, nama_lengkap, kelas, jenis_kelamin, nama_ayah, nama_ibu, tempat_lahir, tanggal_lahir FROM tb_siswa");
$stmt->execute();
$result = $stmt->get_result();
$dataSiswa = $result->fetch_all(MYSQLI_ASSOC);
?>

<style>
  input:focus {
    outline: none;
  }

</style>
<!-- Content -->
<div class="flex flex-col w-[80%] bg-slate-100">
  <!-- Container 1 : Banner -->
  <div class="flex flex-col justify-center w-full shadow-xl">
    <h1 class="text-xl px-3 py-1 font-bold bg-[#001A6E] text-white ">Master Data - Data Siswa</h1>
    <!-- Breadcrumb -->
    <h2 class="px-3 bg-slate-100 text-sm font-medium border">Master Data / Data Siswa</h2>
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
          <div class="flex flex-row gap-2 text-sm rounded-sm">
            <select name="group-by" id="group-by" class="rounded-sm">
            </select>
          </div>
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
          <button id="btn-reset-group-by" class="bg-red-500 text-white px-2 rounded-md">reset</button>
        </div>
        <button class="px-2 bg-blue-800 text-white rounded-md hover:bg-blue-600"> + Tambah</button>
      </div>
      <!-- Table -->
      <table class="text-center h-full">
        <thead class="sticky top-[59px] shadow-sm">
          <tr class="bg-lime-100 text-sm font-medium">
            <td class="border py-1">No</td>
            <td class="border py-1">Nomor Induk Siswa</td>
            <td class="border py-1">Nama Lengkap</td>
            <td class="border py-1">Kelas</td>
            <td class="border py-1">Jenis Kelamin</td>
            <td class="border py-1">Nama Ayah</td>
            <td class="border py-1">Nama Ibu</td>
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
  <!-- Container 3 : Modal -->
  <div class="flex flex-row justify-center gap-5 bg-black bg-opacity-60 w-screen h-full px-10 z-40 absolute left-0 top-0">
    <!-- Container: Form Modal -->
    <div class="flex flex-col gap-4 mt-5 py-2 px-4 bg-white w-fit  h-fit rounded-xl shadow-xl bg-[#eaeaea]">
      <div class="">
        <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Form Tambah Data Siswa</h1>
        <hr class="bg-lime-400 py-[1.8px] rounded-full">
      </div>
    <!-- Form Modal -->
    <form id="form-modal" method="POST" action="/master-data/siswa/create" enctype="multipart/form-data" class="flex flex-col gap-5 justify-between">
      <div class="flex flex-row gap-3 justify-between">
          <!-- Container 1 : Data Diri Siswa -->
          <div class="group flex flex-col w-64 gap-2 border py-2 px-3 rounded-md shadow-lg">
            <!-- Title Card -->
            <div class="">
              <div class="text-lg font-bold">Data Diri Siswa</div>
              <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
            </div>
            <!-- Nama Lengkap -->
              <div class="group flex flex-col gap-1">
              <label for="nama-lengkap" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Nama Lengkap Siswa :
                <!-- <span class="text-red-500 text-lg">*</span> -->
                <span class="font-bold text-green-500">&#10003</span>
              </label>
                <input type="text" id="nama-lengkap" name="nama-lengkap" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Nama Lengkap" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
              </div>
            <!-- Nomor Induk Siswa -->
              <div class="flex flex-col gap-1">
              <label for="nomor-induk-siswa" class="font-medium text-slate-700">
                <span>Nomor Induk Siswa : <span class="text-red-500 text-lg">*</span></span>
                <p class="font-base">( <span class="italic font-base text-xs">Maks: 5 Digit</span> )</p>
              </label>
                <input type="text" id="nomor-induk-siswa"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="nomor-induk-siswa" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Nomor Induk Siswa" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
              </div>
              <!-- Tempat Lahir -->
              <div class="group flex flex-col gap-1">
                <label for="tempat-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Tempat Lahir :
                  <span class="text-red-500 text-lg">*</span>
                  <!-- <span class="font-bold text-green-500">&#10003</span> -->
                </label>
                  <input type="text" id="tempat-lahir" name="tempat-lahir" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Tempat Lahir" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
              </div>
              <!-- Tanggal Lahir -->
              <div class="group flex flex-col gap-1">
                <label for="tanggal-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Tanggal Lahir :
                  <span class="text-red-500 text-lg">*</span>
                  <!-- <span class="font-bold text-green-500">&#10003</span> -->
                </label>
                  <input type="date" id="tanggal-lahir" name="tanggal-lahir" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 ">
              </div>
              <!-- Jenis Kelamin -->
              <div class="group flex flex-col gap-1">
                <label for="jenis-kelamin" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Jenis Kelamin :
                  <span class="text-red-500 text-lg">*</span>
                  <!-- <span class="font-bold text-green-500">&#10003</span> -->
                </label>
                <select id="jenis-kelamin" name="jenis-kelamin" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300">
                  <option disabled selected>Pilih Jenis Kelamin</option>
                  <option value="L">👦🏻 Laki-Laki</option>
                  <option value="P">👧🏻 Perempuan</option>
                </select>
              </div>
              <!-- Kelas -->
              <div class="group flex flex-col gap-1">
                <label for="kelas" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Kelas :
                  <span class="text-red-500 text-lg">*</span>
                  <!-- <span class="font-bold text-green-500">&#10003</span> -->
                </label>
                <select id="kelas" name="kelas" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300">
                  <option disabled selected>Pilih Kelas</option>
                  <option value="L">👦🏻 Laki-Laki</option>
                  <option value="P">👧🏻 Perempuan</option>
                </select>
              </div>
          </div>
          <!-- Container 2 : Data Orang Tua Siswa -->
          <div class="group flex flex-col w-64 gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
          <!-- Title Card -->
            <div class="">
              <div class="text-lg font-bold">Data Orang Tua</div>
              <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-green-500 group-focus-within:bg-blue-500">
            </div>
            <!-- NIK Ayah -->
            <div class="flex flex-col gap-1">
              <label for="nik-ayah" class="font-medium text-slate-700">
                <span>NIK Ayah  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="nik-ayah"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="nik-ayah" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="NIK Ayah / Wali" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
              </div>
            <!-- Nama Lengkap Ayah -->
            <div class="group flex flex-col gap-1">
              <label for="nama-lengkap-ayah" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Nama Lengkap Ayah / Wali:
                <!-- <span class="text-red-500 text-lg">*</span> -->
                <span class="font-bold text-green-500">&#10003</span>
              </label>
                <input type="text" id="nama-lengkap-ayah" name="nama-lengkap-ayah" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Nama Lengkap Ayah" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
              </div>
            <!-- Email Ayah -->
            <div class="flex flex-col gap-1">
              <label for="email-ayah" class="font-medium text-slate-700">
              <span>Email Ayah  : <span class="text-red-500 text-lg">*</span></span>
              </label>
              <input type="email" id="email-ayah"
              name="email-ayah" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="example@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Masukkan email yang valid">
              </div>
            <!-- Nomor Telepon Ayah -->
            <div class="flex flex-col gap-1">
              <label for="nomor-telepon-ayah" class="font-medium text-slate-700">
                <span>Nomor Telepon Ayah: <span class="text-red-500 text-lg">*</span></span>
              </label>
              <input
                type="tel"
                id="nomor-telepon-ayah"
                name="nomor-telepon-ayah"
                class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300"
                placeholder="08XX-XXXX-XXXX"
                pattern="08[0-9]{8,11}"
                maxlength="13"
                title="Nomor telepon harus dimulai dengan '08' diikuti 8 hingga 11 digit angka."
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                required
              />
            </div>
            <!-- NIK Ibu -->
            <div class="flex flex-col gap-1">
              <label for="nik-ibu" class="font-medium text-slate-700">
                <span>NIK Ibu / Wali : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="nik-ibu"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="nik-ibu" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="NIK Ibu / Wali" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
              </div>
            <!-- Nama Lengkap Ibu -->
            <div class="group flex flex-col gap-1">
                <label for="nama-lengkap-ibu" class="font-medium text-slate-700 text-[16px] focus:font-semibold">Nama Lengkap Ibu / Wali :
                  <!-- <span class="text-red-500 text-lg">*</span> -->
                  <span class="font-bold text-green-500">&#10003</span>
                </label>
                <input type="text" id="nama-lengkap-ibu" name="nama-lengkap-ibu" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Nama Lengkap Ibu" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
              </div>
            <!-- Email Ibu -->
            <div class="flex flex-col gap-1">
              <label for="email-ibu" class="font-medium text-slate-700">
              <span>Email Ibu  : <span class="text-red-500 text-lg">*</span></span>
              </label>
              <input type="email" id="email-ibu"
              name="email-ibu" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="example@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Masukkan email yang valid">
              </div>
            <!-- Nomor Telepon Ibu -->
            <div class="flex flex-col gap-1">
              <label for="nomor-telepon-ibu" class="font-medium text-slate-700">
                <span>Nomor Telepon Ibu: <span class="text-red-500 text-lg">*</span></span>
              </label>
              <input
                type="tel"
                id="nomor-telepon-ibu"
                name="nomor-telepon-ibu"
                class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300"
                placeholder="08XX-XXXX-XXXX"
                pattern="08[0-9]{8,11}"
                maxlength="13"
                title="Nomor telepon harus dimulai dengan '08' diikuti 8 hingga 11 digit angka."
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                required
              />
            </div>
          </div>
          <!-- Container 3 : Alamat -->
          <div class="group flex flex-col w-64 gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
          <!-- Title Card -->
            <div class="">
              <div class="text-lg font-bold">Alamat</div>
              <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-yellow-400 group-focus-within:bg-blue-500">
            </div>
            <!-- Provinsi -->
            <div class="flex flex-col gap-1">
              <label for="provinsi" class="font-medium text-slate-700">
                <span>Provinsi  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="provinsi"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="provinsi" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Provinsi" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
              </div>
            <!-- Kabupaten -->
            <div class="flex flex-col gap-1">
              <label for="kabupaten" class="font-medium text-slate-700">
                <span>Kabupaten  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="kabupaten"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="kabupaten" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Kabupaten" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
              </div>
            <!-- Kecamatan -->
            <div class="flex flex-col gap-1">
              <label for="kecamatan" class="font-medium text-slate-700">
                <span>Kecamatan  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="kecamatan"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="kecamatan" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="kecamatan" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- Desa / Kelurahan -->
            <div class="flex flex-col gap-1">
              <label for="desa" class="font-medium text-slate-700">
                <span>Desa / Kelurahan  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="desa"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="desa" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Desa / Kelurahan" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- RT -->
            <div class="flex flex-col gap-1">
              <label for="rt" class="font-medium text-slate-700">
                <span>RT  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="rt"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="rt" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Rukun Tetangga / RT" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- RW -->
            <div class="flex flex-col gap-1">
              <label for="rw" class="font-medium text-slate-700">
                <span>RW  : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="rw"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="rw" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Rukun Warga / RW" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- Kode Post -->
            <div class="flex flex-col gap-1">
              <label for="kode-post" class="font-medium text-slate-700">
                <span>Kode Post : <span class="text-red-500 text-lg">*</span></span>
              </label>
                <input type="text" id="kode-post"
                inputmode="numeric" pattern="[0-9\s]{13,19}"
                name="kode-post" class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " placeholder="Kode Post" title="Hanya menerima angka 0-9" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
          </div>
          <!-- Container 4 : Photo Profile -->
          <div class="group flex flex-col w-64 h-fit gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
          <!-- Title Card -->
            <div class="">
              <div class="text-lg font-bold">Photo Profile Siswa</div>
              <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-red-300 group-focus-within:bg-blue-500">
            </div>
            <!-- Preview -->
            <output id="preview-container" name="x" class="h-60 w-full">
              <img src="http://localhost:100/assets/images/default-image.png" id="preview-image" class="h-full w-full border rounded-md object-cover" alt="default image">
            </output>
            <input
              type="file"
              id="photo-profile"
              name="photo-profile"
              accept="image/*"
              class="mt-2 border rounded-r-md"
              onchange="updatePreview(event)"
            >
          </div>
          <script>
            function updatePreview(event) {
              const file = event.target.files[0]; // Ambil file dari input
              const previewImage = document.getElementById('preview-image'); // Elemen gambar untuk preview

              if (file) {
                const reader = new FileReader(); // FileReader untuk membaca file
                reader.onload = function (e) {
                  previewImage.src = e.target.result; // Set src dengan data URL dari file
                };
                reader.readAsDataURL(file); // Membaca file sebagai data URL
              } else {
                // Jika tidak ada file, kembalikan ke gambar default
                previewImage.src = "http://localhost:100/assets/images/default-image.png";
              }
            }

            document.getElementById('form-modal').addEventListener('reset', () => {
              const previewImage = document.getElementById('preview-image');
              previewImage.src = "http://localhost:100/assets/images/default-image.png"; // Gambar default
            })
          </script>
      </div>
      <div class="flex flex-row gap-5 justify-between border">
        <button class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md">Batal</button>
        <div class="flex flex-row gap-5">
          <button type="reset" class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md">Reset</button>
          <button class="bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php require BASE_PATH . "/views/admin/footer.php"; ?>
<script>
  // States
  const siswa = {
    main_datas: <?= json_encode($dataSiswa) ?>,
    render: [],
    filtered_data: [],
    index: 0,
    limit: 10,
    load_data: 0,
    total_data: <?= json_encode(count($dataSiswa)) ?>,
    current: 1,
    total_page: 0
  };

  const search = {
    keyword: '',
    placholder: ''
  };

  // Handlers
  function initialValues() {
    const datas = chunkArray(siswa.main_datas, siswa.limit);
    siswa.index = 0;
    siswa.render = datas[0];
    siswa.limit = 10;
    siswa.load_data = datas[0].length;
    siswa.total_data = siswa.main_datas.length;
    siswa.current = 1;
    siswa.total_page = datas.length;
    setLimitOption();
  }

  function chunkArray(array, chunkSize) {
    const chunks = [];
    for (let i = 0; i < array.length; i += parseInt(chunkSize)) {
      chunks.push(array.slice(i, i + parseInt(chunkSize)));
    }
    return chunks;
  }

  // === Toolbar
  // ** Limit
  const limitElement = document.getElementById('limit');
  function setLimitOption() {
    console.log('custom data 1', siswa.filtered_data);
    limitElement.innerHTML = '';
    const totalData = siswa.filtered_data.length > 0 ? siswa.total_data : siswa.main_datas.length;
    console.log('total data', totalData);

    for (let i = 10; i <= totalData; i += 10) {
      const option = document.createElement('option');
      option.value = i;
      option.text = i;
      limitElement.appendChild(option);
    }
    // ** Limit Handler
    limitElement.addEventListener("change", (e) => {
      siswa.limit = parseInt(e.target.value);
      siswa.render = [];
      // console.log('custom data', siswa.filtered_data.flat());
      // console.log('limit', siswa.limit);
      const datas = siswa.filtered_data?.length > 0 ? (siswa.filtered_data = chunkArray(siswa.filtered_data.flat(), siswa.limit), siswa.filtered_data) : chunkArray(siswa.main_datas, siswa.limit);
      console.log(datas);
      siswa.render = datas[0];
      siswa.index = 0;
      siswa.current = 1;
      siswa.load_data = siswa.limit;
      siswa.total_page = datas.length;
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

    const keys = ['kelas', 'jenis_kelamin', 'tempat_lahir'];
    const optionLabels = ['Kelas', 'Jenis Kelamin', 'Tempat Lahir'];

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
      <span id="load-data">${siswa.load_data}</span>
      <span class="font-semibold ">of</span>
      <span>${siswa.total_data}</span>
    `;
  }

  function renderLoadPage() {
    const element = document.getElementById('load-page');
    element.innerHTML = `
      <span class="bg-white px-1 text-sm rounded-sm">
        <span class="font-semibold">Page:</span> ${siswa.current}
        <span class="font-semibold">of</span> ${siswa.total_page}
      </span>
    `;
  }

  function nextPageHandle() {
    const datas = chunkArray(siswa.main_datas, siswa.limit);
    console.log(datas);
    console.log(siswa.current);
    if (siswa.index + 1 >= datas.length || (siswa.filtered_data.length > 0 && (siswa.filtered_data && siswa.index + 1 >= siswa.filtered_data.length))) return false;
    ++siswa.index;
    ++siswa.current;
    siswa.render = siswa.filtered_data.length > 0 ? siswa.filtered_data[siswa.index] : datas[siswa.index];
    siswa.load_data = parseInt(siswa.load_data) + siswa.render.length;
    console.log('jalan');
    renderTable();
  }

  function prevPageHandle() {
    const datas = chunkArray(siswa.main_datas, siswa.limit);
    if (siswa.index == 0) return false;
    --siswa.index;
    --siswa.current;
    siswa.render = siswa.filtered_data.length > 0 ? siswa.filtered_data[siswa.index] : datas[siswa.index];
    siswa.load_data = siswa.index !== 0 ? siswa.load_data - siswa.render.length : siswa.limit;
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

  function inputSearchHandle(e) {
    console.log(e.target.value);
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
    siswa.render?.map((data, index) => {
      const row = document.createElement('tr');
      row.className = 'group bg-lime-50 text-sm hover:bg-blue-50';
      row.innerHTML = `
              <td class="border group-hover:font-medium">${siswa.index == 0 ? index + 1 : (siswa.index * siswa.limit) + index + 1}</td>
              <td class="border group-hover:font-medium">${data.nomor_induk_siswa}</td>
              <td class="border group-hover:font-medium">${data.nama_lengkap}</td>
              <td class="border group-hover:font-medium">${data.kelas}</td>
              <td class="border group-hover:font-medium">${data.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan'}</td>
              <td class="border group-hover:font-medium">${data.nama_ayah}</td>
              <td class="border group-hover:font-medium">${data.nama_ibu}</td>
              <td class="border group-hover:font-medium">${data.tempat_lahir}</td>
              <td class="border group-hover:font-medium">${data.tanggal_lahir}</td>
              <td class="border h-full flex flex-row justify-center items-center py-1 gap-2">
                <button class="px-2 bg-lime-800 text-white rounded-md hover:bg-lime-600"> Detail</button>
                <button class="px-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-500"> Edit</button>
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
  });
</script>