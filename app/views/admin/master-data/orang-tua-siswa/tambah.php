<?php
// Load Data Kelas
$stmt = $conn->prepare("SELECT id, nama_kelas FROM tb_kelas");
$stmt->execute();
$result = $stmt->get_result();
$dataKelas = $result->fetch_all(MYSQLI_ASSOC);

// Load Data Ayah
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, email, nomor_telepon  FROM tb_orang_tua_siswa WHERE hubungan = ?");
$ayah = "Ayah";
$stmt->bind_param("s", $ayah);
$stmt->execute();
$result = $stmt->get_result();
$dataAyah = $result->fetch_all(MYSQLI_ASSOC);

// Load Data Ibu
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, email, nomor_telepon  FROM tb_orang_tua_siswa WHERE hubungan = ?");
$ibu = "Ibu";
$stmt->bind_param("s", $ibu);
$stmt->execute();
$result = $stmt->get_result();
$dataIbu = $result->fetch_all(MYSQLI_ASSOC);
?>


<!-- Form Tambah Data Siswa -->
<div class="flex flex-col gap-4 py-2 px-4 bg-white w-fit  h-fit rounded-xl shadow-xl">
  <div class="">
    <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Form Tambah Data Orang Tua</h1>
    <hr class="bg-lime-400 py-[1.8px] rounded-full">
  </div>
  <!-- Form Modal -->
  <form id="form-modal-tambah" method="POST" action="/master-data/orang-tua/create" enctype="multipart/form-data"
    class="flex flex-col gap-5 justify-between">
    <div class="flex flex-row gap-3 justify-between">
      <!-- Container 1 : Data Orang Tua Siswa -->
      <div class="group flex flex-col h-fit w-fit gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Data Diri</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-green-500 group-focus-within:bg-blue-500">
        </div>
        <!-- Sub Container -->
         <div class="flex flex-row gap-5">
            <!-- Content 1 -->
           <div class="flex flex-col">
            <!-- NIK -->
            <div class="flex flex-col gap-1">
              <label for="nik" id="label-tambah-nik" class="font-medium text-slate-700 text-nowrap">
                <span>Nomor Identitas Kependudukan (NIK) :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="nik" inputmode="numeric" pattern="[0-9\s]{13,19}" name="nomor-identitas-kependudukan"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="NIK sesuai KTP" title="Pastikan sesuai KTP"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                maxLength="16"
                required>
            </div>
            <!-- Nama Lengkap -->
            <div class="group flex flex-col gap-1">
              <label for="nama-lengkap" id="label-tambah-nama-lengkap" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                <span>Nama Lengkap :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="nama-lengkap" name="nama-lengkap"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Nama Lengkap sesuai KTP" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" required>
            </div>
            <!-- Tempat Lahir -->
            <div class="group flex flex-col gap-1">
              <label for="tempat-lahir" id="label-tambah-tempat-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                <span>Tempat Lahir :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="tempat-lahir" name="tempat-lahir"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 " required
                placeholder="Tempat Lahir" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Tanggal Lahir -->
            <div class="group flex flex-col gap-1">
              <label for="tanggal-lahir" id="label-tambah-tanggal-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                <span>Tanggal Lahir :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="date" id="tanggal-lahir" name="tanggal-lahir"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 ">
            </div>
            <!-- Jenis Kelamin -->
            <div class="group flex flex-col gap-1">
              <label for="jenis-kelamin" id="label-tambah-jenis-kelamin" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                <span>Jenis Kelamin :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <select id="jenis-kelamin" name="jenis-kelamin"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300">
                <option disabled selected value="">Pilih Jenis Kelamin</option>
                <option value="L">👦🏻 Laki-Laki</option>
                <option value="P">👧🏻 Perempuan</option>
              </select>
            </div>
           </div>
            <!-- Content 2 -->
           <div class="flex flex-col">
             <!-- Hubungan : -->
             <div class="group flex flex-col gap-1">
               <label for="hubungan" id="label-tambah-hubungan" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                 <span>Hubungan :</span>
                 <span id="empty" class="text-red-500 text-lg">*</span>
               </label>
               <select id="hubungan" name="hubungan"
                 class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300">
                 <option disabled selected value="">Pilih Hubungan</option>
                 <option value="Ayah">👦🏻 Ayah</option>
                 <option value="Ibu">👧🏻 Ibu</option>
               </select>
             </div>
            <!-- Email -->
            <div class="flex flex-col gap-1">
              <label for="email" id="label-tambah-email" class="font-medium text-slate-700">
                <span>Email :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input
                type="email"
                id="email"
                name="email"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300"
                placeholder="example@example.com"
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                title="Masukkan email yang valid"
                oninput="validateEmailInput(this)"
              >
            </div>
             <!-- Nomor Telepon -->
             <div class="flex flex-col gap-1">
               <label for="nomor-telepon" id="label-tambah-nomor-telepon" class="font-medium text-slate-700">
                 <span>Nomor Telepon :</span>
                 <span id="empty" class="text-red-500 text-lg">*</span>
               </label>
               <input type="tel"
                 id="nomor-telepon"
                 name="nomor-telepon"
                 class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300"
                 placeholder="08XX-XXXX-XXXX"
                 pattern="08[0-9]{8,11}"
                 maxlength="13"
                 title="Nomor telepon harus dimulai dengan '08' diikuti 8 hingga 11 digit angka."
                 oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
             </div>
             <!-- Pekerjaan -->
             <div class="flex flex-col gap-1">
               <label for="pekerjaan" id="label-tambah-pekerjaan" class="font-medium text-slate-700">
                 <span>Pekerjaan :</span>
                 <span id="empty" class="text-red-500 text-lg">*</span>
               </label>
               <input type="text" id="pekerjaan" name="pekerjaan"
                 class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                 placeholder="Nama Pekerjaan" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                 title="Masukkan pekerjaan yang valid" required>
             </div>
           </div>
         </div>
      </div>
      <!-- Container 3 : Alamat -->
      <div class="group flex flex-col w-fit gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Alamat</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-yellow-400 group-focus-within:bg-blue-500">
        </div>
        <div class="flex flex-row gap-5">
          <div class="flex flex-col">
            <!-- Provinsi -->
            <div class="flex flex-col gap-1">
              <label for="provinsi" id="label-tambah-provinsi" class="font-medium text-slate-700">
                <span>Provinsi :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="provinsi" name="provinsi"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Provinsi" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Kabupaten -->
            <div class="flex flex-col gap-1">
              <label for="kabupaten" id="label-tambah-kabupaten" class="font-medium text-slate-700">
                <span>Kabupaten :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="kabupaten" name="kabupaten"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Kabupaten" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Kecamatan -->
            <div class="flex flex-col gap-1">
              <label for="kecamatan" id="label-tambah-kecamatan" class="font-medium text-slate-700">
                <span>Kecamatan :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="kecamatan" name="kecamatan"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Kecamatan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Desa / Kelurahan -->
            <div class="flex flex-col gap-1">
              <label for="desa" id="label-tambah-desa" class="font-medium text-slate-700">
                <span>Desa / Kelurahan :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="desa" name="desa"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300"
                placeholder="Desa / Kelurahan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
          </div>
          <div class="flex flex-col">
            <!-- RT -->
            <div class="flex flex-col gap-1">
              <label for="rt" id="label-tambah-rt" class="font-medium text-slate-700">
                <span>RT :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="rt" inputmode="numeric" name="rt"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Rukun Tetangga / RT" title="Hanya menerima angka 0-9"
                maxlength="3"
                requrired
                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- RW -->
            <div class="flex flex-col gap-1">
              <label for="rw" id="label-tambah-rw" class="font-medium text-slate-700">
                <span>RW :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="rw" inputmode="numeric" name="rw"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Rukun Warga / RW" title="Hanya menerima angka 0-9"
                maxlength="3"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- Kode Post -->
            <div class="flex flex-col gap-1">
              <label for="kode-post" id="label-tambah-kode-post" class="font-medium text-slate-700">
                <span>Kode Post :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="kode-post" inputmode="numeric" name="kode-post"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Kode Post" title="Hanya menerima angka 0-9" maxlength="6"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
          </div>
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
          <img src="/images/logo/_/default-image" id="tambah-preview-image"
            class="h-full w-full border rounded-md object-cover" alt="default image">
        </output>
        <input type="file" id="photo-profile" name="photo-profile" accept="image/*" class="mt-2 border rounded-r-md"
          onchange="updatePreviewTambahImage(event)">
      </div>
    </div>
    <div class="flex flex-row gap-5 justify-between">
      <button type="button"
        class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md" onclick="closeModalTambah()">Batal</button>
      <div class="flex flex-row gap-5">
        <button type="reset"
          class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md"
          onclick="handlerResetFormTambah()">Reset</button>
        <button
          class="bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md">Submit</button>
      </div>
    </div>
  </form>
</div>

<script>
  // States
  const md_ayah = <?= json_encode($dataAyah) ?>;
  const md_ibu = <?= json_encode($dataIbu) ?>;

  // == Handlers
  function handleCheckInputValue(value, target, inputElement = null, invalidMSG = "") {
    // Hapus elemen lama jika ada
    const existingMessage = target.querySelector("span#empty") || target.querySelector("span#no-empty");
    if (existingMessage) {
      existingMessage.remove();
    }

    // Buat elemen baru
    const span = document.createElement("span");
    if (value === "") {
      span.className = "text-red-500 text-lg";
      span.textContent = "*";
      span.id = "empty";

      // Tandai input sebagai invalid
      inputElement?.classList.add("bg-red-200");
      inputElement?.classList.remove("bg-green-200");
      inputElement?.setCustomValidity(invalidMSG); // Pesan kesalahan
    } else {
      span.className = "font-bold text-green-500";
      span.innerHTML = "&#5003;";
      span.id = "no-empty";

      // Tandai input sebagai valid
      inputElement?.classList.remove("bg-red-200");
      inputElement?.classList.add("bg-green-200");
      inputElement?.setCustomValidity(""); // Reset pesan kesalahan
    }

    // Tambahkan elemen baru ke target
    target.appendChild(span);
  }

  let timer; // Variabel timer di luar fungsi untuk menjaga state debounce
  // ** NIK
  function handleInputTambahNIK(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-nik');
    let result;
    clearTimeout(timer); // Hapus timer sebelumnya
    timer = setTimeout(() => {
      result = md_ayah.find((data) => data.nomor_identitas_kependudukan === value) || md_ibu.find((data) => data.nomor_identitas_kependudukan === value);
      if (result) {
        handleCheckInputValue("", element, inputElement, "Data dengan NIK tersebut Sudah Ada!");
      } else {
        if (value.length == 16 && value !== "") {
          handleCheckInputValue(value, element, inputElement, "");
        } else if (value.length < 16 && value !== "") {
          console.log(value);
          handleCheckInputValue("", element, inputElement, "Format NIK Tidak Valid! (WAJIB: 16 Digit)");
        } else {
          handleCheckInputValue("", element, inputElement, "NIK Wajib di isi!");
        }
      }
    }, 500); // Waktu debounce 1 detik
  }
  // ** Nama Lengkap
  function handleInputTambahNamaLengkap(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-nama-lengkap');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Nama Lengkap Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Tempat Lahir
  function handleInputTambahTempatLahir(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-tempat-lahir');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Tempat Lahir Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Tanggal Lahir
  function handleSelectTambahTanggalLahir(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-tanggal-lahir');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Tanggal Lahir Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Jenis Kelamin
  function handleSelectTambahJenisKelamin(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-jenis-kelamin');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Jenis Kelamin Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Hubungan
  function handleTambahHubungan(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-hubungan');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Hubungan Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Email
  function validateEmailInput(inputElement) {
    const validCharacters = /^[a-z0-9._%+-]*@[a-z0-9.-]*$/i;

    // Simpan posisi kursor
    const cursorPosition = inputElement.selectionStart;

    if (!validCharacters.test(inputElement.value)) {
      // Hapus karakter tidak valid terakhir
      inputElement.value = inputElement.value.replace(/[^a-z0-9._%+-@]/gi, "");
    }
  }

  function handleTambahEmail(e) {
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-email');
    clearTimeout(timer);
    timer = setTimeout(() => {
      result = md_ayah.find((data) => data.email === value) || md_ibu.find((data) => data.email === value);
      if (result) {
        console.log('email sudah ada', value)
        handleCheckInputValue("", element, inputElement, "Email tersebut Sudah Ada!");
      } else {
        if (value !== "") {
          if (value.length > 8 && value.includes("@") && value.indexOf("@") > 0 && value.indexOf("@") < value.length - 1) {
            handleCheckInputValue(value, element, inputElement, ""); // Email valid
          } else {
            handleCheckInputValue("", element, inputElement, "Format Email Tidak Valid! (contoh: example@example.com)"); // Email tidak valid
          }
        } else {
          handleCheckInputValue("", element, inputElement, "Email Wajib diisi!"); // Email kosong
        }
      }
    }, 500);
  }
  // ** Nomor Telepon
  let nomorTelepon;
  function handleTambahNomorTelepon(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-nomor-telepon');
    clearTimeout(timer);
    timer = setTimeout(() => {
      console.log(md_ayah)
      result = md_ayah.find((data) => data.nomor_telepon === value) || md_ibu.find((data) => data.nomor_telepon === value);
      if (result) {
        console.log('Nomor telepon sudah ada', value)
        handleCheckInputValue("", element, inputElement, "Nomor Telepon tersebut Sudah Ada!");
      } else {
        if (value !== "") {
          if (value.length > 10) {
            handleCheckInputValue(value, element, inputElement, ""); // Nomor Telepon valid
          } else {
            handleCheckInputValue("", element, inputElement, "Format Nomor Telepon Tidak Valid! (Minimal: 10 digit)"); // Nomor Telepon tidak valid
          }
        } else {
          handleCheckInputValue("", element, inputElement, "Nomor Telepon Wajib diisi!"); // Nomor Telepon kosong
        }
      }
    }, 500);
  }
  // ** Pekerjaan
  let pekerjaan;
  function handleTambahPekerjaan(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-pekerjaan');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Pekerjaan Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Provinsi
  function handleTambahProvinsi(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-provinsi');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Provinsi Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Kabupaten
  function handleTambahKabupaten(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-kabupaten');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Kabupaten Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Kecamatan
  function handleTambahKecamatan(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-kecamatan');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Kecamatan Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Desa
  function handleTambahDesa(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-desa');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Desa Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** RT
  function handleTambahRT(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-rt');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "RT Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** RW
  function handleTambahRW(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-rw');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "RW Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** KodePost
  function handleTambahKodePost(e){
    const value = e.target.value;
    const inputElement = e.target;
    const element = document.getElementById('label-tambah-kode-post');
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (value == '') {
        handleCheckInputValue(value, element, inputElement, "Kode Post Tidak Boleh Kosong!");
      } else {
        handleCheckInputValue(value, element, inputElement, '');
      }
    }, 500);
  }
  // ** Photo Profile: Preview
  function updatePreviewTambahImage(event) {
    const file = event.target.files[0]; // Ambil file dari input
    const previewImage = document.getElementById('tambah-preview-image'); // Elemen gambar untuk preview

    if (file) {
      const reader = new FileReader(); // FileReader untuk membaca file
      reader.onload = function(e) {
        previewImage.src = e.target.result; // Set src dengan data URL dari file
      };
      reader.readAsDataURL(file); // Membaca file sebagai data URL
    } else {
      // Jika tidak ada file, kembalikan ke gambar default
      previewImage.src = "/images/logo/_/default-image";
    }
  };

  // ** RESET HANDLERS
  function handlerResetFormTambah() {
    const form = document.getElementById('form-modal-tambah');

    // Remove Input
    const inputElements = form.getElementsByTagName('input');
    Array.from(inputElements).forEach((input) => {
      input.classList.remove('bg-green-200');
      input.classList.remove('bg-red-200');
      input.value = '';
    });

    // Remove Select
    const selectElements = form.getElementsByTagName('select');
    Array.from(selectElements).forEach((select) => {
      select.classList.remove('bg-green-200');
      select.value = '';
    });

    const labelElements = document.querySelectorAll('label[id^="label-tambah"]'); // Mengambil semua label dengan ID yang diawali "tambah-"
    // Iterasi melalui NodeList
    labelElements.forEach((element) => {
        const spanElement = element.querySelector('span[id="no-empty"]'); // Mencari span dengan ID "no-empty"
        if (spanElement) { // Memastikan elemen ditemukan

            // Hapus span "no-empty" dari elemen label
            spanElement.remove();

            // Tambahkan span baru dengan teks "*"
            const span = document.createElement("span");
            span.className = "text-red-500 text-lg";
            span.textContent = "*";
            span.id = "empty";
            element.appendChild(span); // Tambahkan span baru ke elemen label
        }
    });

    const previewImage = document.getElementById('tambah-preview-image');
    previewImage.src = "/images/logo/_/default-image"; // Gambar default
  }

  // Load Elements
  // ** Form Event
  // document.getElementById('form-modal-tambah').addEventListener('reset', () => {
  //   const previewImage = document.getElementById('tambah-preview-image');
  //   previewImage.src = "/images/logo/_/default-image"; // Gambar default
  //   handlerResetFormTambah();
  // });
  // ** Nama Lengkap Siswa : Input
  const inputNamaLengkapSiswa = document.getElementById('nama-lengkap');
  inputNamaLengkapSiswa.addEventListener('keyup', (e) => handleInputTambahNamaLengkap(e));
  // ** NIK : Input
  const inputNIK = document.getElementById('nik');
  inputNIK.addEventListener('keyup', (e) => handleInputTambahNIK(e));
  // ** Tempat Lahir : Input
  const inputTempatLahir = document.getElementById('tempat-lahir');
  inputTempatLahir.addEventListener('keyup', (e) => handleInputTambahTempatLahir(e));
  // ** Tanggal Lahir : Select
  const selectTanggalLahir = document.getElementById('tanggal-lahir');
  selectTanggalLahir.addEventListener('change', (e) => handleSelectTambahTanggalLahir(e));
  // ** Jenis Kelamin : Select
  const selectJenisKelamin = document.getElementById('jenis-kelamin');
  selectJenisKelamin.addEventListener('change', (e) => handleSelectTambahJenisKelamin(e));
  // ** Hubungan : Select
  const selectHubungan = document.getElementById('hubungan');
  selectHubungan.addEventListener('change', (e) => handleTambahHubungan(e));
  // ** Email : Input
  const inputEmail = document.getElementById('email');
  inputEmail.addEventListener('change', (e) => handleTambahEmail(e));
  // ** Nomor Telepon : Input
  const inputNomorTelepon = document.getElementById('nomor-telepon');
  inputNomorTelepon.addEventListener('change', (e) => handleTambahNomorTelepon(e));
  // ** Pekerjaan : Input
  const inputPekerjaan = document.getElementById('pekerjaan');
  inputPekerjaan.addEventListener('change', (e) => handleTambahPekerjaan(e));
  // ** Provinsi : Input
  const inputProvinsi = document.getElementById('provinsi');
  inputProvinsi.addEventListener('keyup', (e) => handleTambahProvinsi(e));
  // ** Kabupaten : Input
  const inputKabupaten = document.getElementById('kabupaten');
  inputKabupaten.addEventListener('keyup', (e) => handleTambahKabupaten(e));
  // ** Kecamatan : Input
  const inputKecamatan = document.getElementById('kecamatan');
  inputKecamatan.addEventListener('keyup', (e) => handleTambahKecamatan(e));
  // ** Desa : Input
  const inputDesa = document.getElementById('desa');
  inputDesa.addEventListener('keyup', (e) => handleTambahDesa(e));
  // ** RT : Input
  const inputRT = document.getElementById('rt');
  inputRT.addEventListener('keyup', (e) => handleTambahRT(e));
  // ** RW : Input
  const inputRW = document.getElementById('rw');
  inputRW.addEventListener('keyup', (e) => handleTambahRW(e));
  // ** KodePost : Input
  const inputKodePost = document.getElementById('kode-post');
  inputKodePost.addEventListener('keyup', (e) => handleTambahKodePost(e));

  // === MODALS ====
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
    const inputElements = targetElement.getElementsByTagName('input');

    // Cek apakah ada input yang tidak kosong
    const isNotEmpty = Array.from(inputElements).some((input) => input.value !== '');

    if (isNotEmpty) {
      // Jika ada input yang terisi (tidak kosong)
      Swal.fire({
        title: "Batal Tambah Data Orang Tua,<br> Anda Yakin?",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        cancelButtonColor: 'orange',
        denyButtonText: `Ya, Saya Yakin`,
        customClass: {
          popup: 'swal-absolute',
        },
        backdrop: false,
        didOpen: () => {
          const element = document.createElement('div');
          element.setAttribute('id', 'swal-mask');
          element.classList.add('h-full', 'w-full', 'bg-black', 'bg-opacity-60', 'absolute');
          targetElement.appendChild(element);
        },
        didClose: () => {
          const swalMask = document.getElementById('swal-mask');
          if (swalMask) {
            targetElement.removeChild(swalMask);
          }
        }
      }).then((result) => {
        if (result.isDenied) {
          targetElement.classList.remove('absolute');
          targetElement.classList.add('hidden');
          // Reset Form
          handlerResetFormTambah();
        }
      });
    } else {
      // Jika semua input kosong
      targetElement.classList.remove('absolute');
      targetElement.classList.add('hidden');
      // Reset Form
      handlerResetFormTambah();
    }
  }

  // INITIAL
  // ** Kelas  : Select
  // setKelasOption();
  // console.log(document.getElementById('jenis-kelamin').value);
</script>
