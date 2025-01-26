<?php
// Load Data Ayah
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, tempat_lahir, tanggal_lahir, jenis_kelamin, email, nomor_telepon, hubungan, pekerjaan, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo  FROM tb_orang_tua_siswa WHERE hubungan = ?");

$ayah = "Ayah";
$stmt->bind_param("s", $ayah);
$stmt->execute();
$result = $stmt->get_result();
$dataAyah = $result->fetch_all(MYSQLI_ASSOC);

// Load Data Ibu
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, tempat_lahir, tanggal_lahir, jenis_kelamin, email, nomor_telepon, hubungan, pekerjaan, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo  FROM tb_orang_tua_siswa WHERE hubungan = ?");

$ibu = "Ibu";
$stmt->bind_param("s", $ibu);
$stmt->execute();
$result = $stmt->get_result();
$dataIbu = $result->fetch_all(MYSQLI_ASSOC);
?>


<!-- Form Edit Data Orang Tua -->
<div class="flex flex-col gap-4 py-2 px-4 bg-white w-fit  h-fit rounded-xl shadow-xl">
  <div class="">
    <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Form Edit Data Orang Tua</h1>
    <hr class="bg-lime-400 py-[1.8px] rounded-full">
  </div>
  <!-- Form Modal -->
  <form id="form-edit-modal" enctype="multipart/form-data" method="POST" action="/master-data/orang-tua/update"
    class="flex flex-col gap-5 justify-between">
    <input type="hidden" name="_method" value="PUT" />
    <div class="flex flex-row gap-3 justify-between">
      <!-- Container 1 : Data Diri Siswa -->
      <div class="group flex flex-col w-64 gap-2 border py-2 px-3 rounded-md shadow-lg">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Data Diri</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
        </div>
        <!-- Nama Lengkap -->
        <div class="group flex flex-col gap-1">
          <label for="edit-nama-lengkap" id="label-edit-nama-lengkap" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Nama Lengkap Siswa :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nama-lengkap" name="nama-lengkap"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
            placeholder="Nama Lengkap" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" title="Nama Lengkap Siswa wajib diisi." required>
        </div>
        <!-- NIK -->
        <div class="flex flex-col gap-1">
          <label for="edit-nik" id="label-edit-nik" class="font-medium text-slate-700">
            <span>NIK : </span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nik" inputmode="numeric"
            name="nomor-identitas-kependudukan"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
            maxlength="10"
            placeholder="NIK sesuai KTP" title="Hanya menerima angka 0-9 (wajib: 10 digit)" required
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <!-- Tempat Lahir -->
        <div class="group flex flex-col gap-1">
          <label for="edit-tempat-lahir" id="label-edit-tempat-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Tempat Lahir :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-tempat-lahir" name="tempat-lahir"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 " required
            placeholder="Tempat Lahir" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Tanggal Lahir -->
        <div class="group flex flex-col gap-1">
          <label for="edit-tanggal-lahir" id="label-edit-tanggal-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Tanggal Lahir :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="date" id="edit-tanggal-lahir" name="tanggal-lahir"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 ">
        </div>
        <!-- Jenis Kelamin -->
        <div class="group flex flex-col gap-1">
          <label for="edit-jenis-kelamin" id="label-edit-jenis-kelamin" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Jenis Kelamin :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <select id="edit-jenis-kelamin" name="jenis-kelamin"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300">
            <option disabled selected value="">Pilih Jenis Kelamin</option>
            <option value="L">👦🏻 Laki-Laki</option>
            <option value="P">👧🏻 Perempuan</option>
          </select>
        </div>
      </div>
      <!-- Container 2 : Data Diri Siswa -->
      <div class="group flex flex-col w-64 gap-2 border py-2 px-3 rounded-md shadow-lg">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Data Diri</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
        </div>
        <!-- Hubungan -->
        <div class="group flex flex-col gap-1">
          <label for="edit-hubungan" id="label-edit-hubungan" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Hubungan :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <select id="edit-hubungan" name="hubungan"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300">
            <option disabled selected value="">Pilih Hubungan</option>
            <option value="Ayah">👦🏻 Ayah</option>
            <option value="Ibu">👧🏻 Ibu</option>
            <option value="Wali">👴🏻👵🏻 Wali</option>
          </select>
        </div>
        <!-- Pekerjaan -->
        <div class="group flex flex-col gap-1">
          <label for="edit-pekerjaan" id="label-edit-pekerjaan" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Pekerjaan :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-pekerjaan" name="pekerjaan"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 " required
            placeholder="Pekerjaan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Email -->
        <div class="flex flex-col gap-1">
          <label for="edit-email" id="label-edit-email" class="font-medium text-slate-700">
            <span>Email :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input
            type="email"
            id="edit-email"
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
          <label for="edit-nomor-telepon" id="label-edit-nomor-telepon" class="font-medium text-slate-700">
            <span>Nomor Telepon :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="tel"
            id="edit-nomor-telepon"
            name="nomor-telepon"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300"
            placeholder="08XX-XXXX-XXXX"
            pattern="08[0-9]{8,11}"
            maxlength="13"
            title="Nomor telepon harus dimulai dengan '08' diikuti 8 hingga 11 digit angka."
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
        </div>
      </div>
      <!-- Container 3 : Alamat -->
      <div class="group flex flex-col w-64 gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg h-fit">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Alamat</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-yellow-400 group-focus-within:bg-blue-500">
        </div>
        <!-- Provinsi -->
        <div class="flex flex-col gap-1">
          <label for="edit-provinsi" id="edit-label-provinsi" class="font-medium text-slate-700">
            <span>Provinsi :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-provinsi" name="provinsi"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
            placeholder="Provinsi" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Kabupaten -->
        <div class="flex flex-col gap-1">
          <label for="edit-kabupaten" id="edit-label-kabupaten" class="font-medium text-slate-700">
            <span>Kabupaten :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-kabupaten" name="kabupaten"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
            placeholder="Kabupaten" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Kecamatan -->
        <div class="flex flex-col gap-1">
          <label for="edit-kecamatan" id="edit-label-kecamatan" class="font-medium text-slate-700">
            <span>Kecamatan :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-kecamatan" name="kecamatan"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
            placeholder="Kecamatan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Desa / Kelurahan -->
        <div class="flex flex-col gap-1">
          <label for="edit-desa" id="edit-label-desa" class="font-medium text-slate-700">
            <span>Desa / Kelurahan :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-desa" name="desa"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300"
            placeholder="Desa / Kelurahan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- RT & RW -->
        <div class="flex flex-row w-full gap-1">
          <!-- RT -->
          <div class="flex flex-col gap-1 w-1/2">
            <label for="edit-rt" id="edit-label-rt" class="font-medium text-slate-700">
              <span>RT :</span>
              <span id="empty" class="text-red-500 text-lg">*</span>
            </label>
            <input type="text" id="edit-rt" inputmode="numeric" name="rt"
              class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300"
              placeholder="Rukun Tetangga / RT" title="Hanya menerima angka 0-9"
              maxlength="3"
              requrired
              onkeypress="return event.charCode >= 48 && event.charCode <= 57">
          </div>
          <!-- RW -->
          <div class="flex flex-col gap-1 w-1/2">
            <label for="edit-rw" id="edit-label-rw" class="font-medium text-slate-700">
              <span>RW :</span>
              <span id="empty" class="text-red-500 text-lg">*</span>
            </label>
            <input type="text" id="edit-rw" inputmode="numeric" name="rw"
              class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
              placeholder="Rukun Warga / RW" title="Hanya menerima angka 0-9"
              maxlength="3"
              onkeypress="return event.charCode >= 48 && event.charCode <= 57">
          </div>
        </div>
        <!-- Kode Post -->
        <div class="flex flex-col gap-1">
          <label for="edit-kode-post" id="edit-label-kode-post" class="font-medium text-slate-700">
            <span>Kode Post :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-kode-post" inputmode="numeric" name="kode-post"
            class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
            placeholder="Kode Post" title="Hanya menerima angka 0-9" maxlength="6"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
          <img src="http://localhost:100/images/logo/_/default-image" id="edit-preview-image"
            class="h-full w-full border rounded-md object-cover" alt="default image">
        </output>
        <input type="file" id="edit-photo-profile" name="photo-profile" accept="image/*" class="mt-2 border rounded-r-md"
          onchange="updatePreview(event)">
      </div>
    </div>
    <!-- Buttons -->
    <div class="flex flex-row gap-5 justify-between">
      <button type="button"
        class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md" onclick="closeModalEdit()">Batal</button>
      <div class="flex flex-row gap-5">
        <button type="button"
          class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg rounded-md" onclick="handleResetEdit()">Reset</button>
        <button
          type="button"
          class="bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md"
          onclick="loadConfirmEdit()"
          >Submit
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  // States
  const dt_ayah = <?= json_encode($dataAyah) ?>;
  const dt_ibu = <?= json_encode($dataIbu) ?>;

  // == Handlers
  function handleCheckInputValue(value, target) {
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
    } else {
      span.className = "font-bold text-green-500";
      span.innerHTML = "&#10003;";
      span.id = "no-empty";
    }

    // Tambahkan elemen baru ke target
    target.appendChild(span);
  }

  let editTimer; // Variabel editTimer di luar fungsi untuk menjaga state debounce
  // ** Nama Lengkap Siswa
  function handleInputNamaLengkapSiswa(e) {
    const value = e.target.value;
    const element = document.getElementById('label-edit-nama-lengkap');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** NIK
  function handleNIK(e) {
    const value = e.target.value;
    const element = document.getElementById('label-edit-nik');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Tempat Lahir
  function handleInputTempatLahir(e) {
    const value = e.target.value;
    const element = document.getElementById('label-edit-tempat-lahir');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Tanggal Lahir
  function handleSelectTanggalLahir(e) {
    const value = e.target.value;
    const element = document.getElementById('label-edit-tanggal-lahir');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Jenis Kelamin
  function handleJenisKelamin(e) {
    const value = e.target.value;
    const element = document.getElementById('label-edit-jenis-kelamin');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }

  // ** NIK
  function handleInputNIK(e) {
    const value = e.target.value;
    const inputId = e.target.id;
    const element = document.getElementById(inputId);
    let result;
    clearTimeout(editTimer); // Hapus editTimer sebelumnya
    editTimer = setTimeout(() => {
      if (inputId == 'edit-nik-ayah') {
        result = dt_ayah.find((data) => data.nomor_identitas_kependudukan == value);
                      document.getElementById('edit-nama-lengkap-ayah').value = result?.nama_lengkap ?? '';
                      document.getElementById('edit-email-ayah').value = result?.email ?? '';
                      document.getElementById('edit-nomor-telepon-ayah').value = result?.nomor_telepon ?? '';
      } else {
        result = md_ibu.find((data) => data.nomor_identitas_kependudukan == value);
                      document.getElementById('edit-nama-lengkap-ibu').value = result?.nama_lengkap ?? '';
                      document.getElementById('edit-email-ibu').value = result?.email ?? '';
                      document.getElementById('edit-nomor-telepon-ibu').value = result?.nomor_telepon ?? '';
      }
      const nikElement = document.getElementById(inputId == 'edit-nik-ayah' ? 'label-edit-nik-ayah' : 'label-edit-nik-ibu' );
      const namaLengkapElement = document.getElementById(inputId == 'edit-nik-ayah' ? 'label-edit-nama-lengkap-ayah' : 'label-edit-nama-lengkap-ibu' );
      const emailElement = document.getElementById(inputId == 'edit-nik-ayah' ? 'label-edit-email-ayah' : 'label-edit-email-ibu' );
      const nomorTeleponElement = document.getElementById(inputId == 'edit-nik-ayah' ? 'label-edit-nomor-telepon-ayah' : 'label-edit-nomor-telepon-ibu' );
      if (result) {
        handleCheckInputValue(value, nikElement);
        handleCheckInputValue(result?.nama_lengkap, namaLengkapElement);
        handleCheckInputValue(result?.email, emailElement);
        handleCheckInputValue(result?.nomor_telepon, nomorTeleponElement);
      } else {
        handleCheckInputValue("", nikElement);
        handleCheckInputValue("", namaLengkapElement);
        handleCheckInputValue("", emailElement);
        handleCheckInputValue("", nomorTeleponElement);
      }
    }, 1000); // Waktu debounce 1 detik
  }
  // ** Email Ayah
  let editEmailAyah;
  function handleEmailAyah(e){
    const value = e.target.value;
    const element = document.getElementById('label-edit-email-ayah');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof editEmailAyah === "undefined"){
        editEmailAyah = value;
      } else {
        if (editEmailAyah !== "undefined" && editEmailAyah === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Telepon Ayah
  let editTeleponAyah;
  function handleNomorTeleponAyah(e){
    const value = e.target.value;
    const element = document.getElementById('label-edit-nomor-telepon-ayah');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof editTeleponAyah === "undefined"){
        editTeleponAyah = value;
      } else {
        if (editTeleponAyah !== "undefined" && editTeleponAyah === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Provinsi
  function handleProvinsi(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-provinsi');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kabupaten
  function handleKabupaten(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-kabupaten');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kecamatan
  function handleKecamatan(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-kecamatan');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Desa
  function handleDesa(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-desa');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** RT
  function handleRT(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-rt');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** RW
  function handleRW(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-rw');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** KodePost
  function handleKodePost(e){
    const value = e.target.value;
    const element = document.getElementById('edit-label-kode-post');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Photo Profile: Preview
  function updatePreview(event) {
    const file = event.target.files[0]; // Ambil file dari input
    const previewImage = document.getElementById('edit-preview-image'); // Elemen gambar untuk preview

    if (file) {
      const reader = new FileReader(); // FileReader untuk membaca file
      reader.onload = function(e) {
        previewImage.src = e.target.result; // Set src dengan data URL dari file
      };
      reader.readAsDataURL(file); // Membaca file sebagai data URL
    } else {
      // Jika tidak ada file, kembalikan ke gambar default
      previewImage.src = "http://localhost:100/assets/images/default-image.png";
    }
  };

  // ** RESET HANDLERS
  function handlerResetLabels() {
    const labelElements = document.querySelectorAll('label[id^="label-"]'); // Mengambil semua label dengan ID yang diawali "label-"

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
  }

  // Load Elements
  // ** Form Event
  document.getElementById('form-edit-modal').addEventListener('reset', () => {
    const previewImage = document.getElementById('edit-preview-image');
    previewImage.src = "http://localhost:100/assets/images/default-image.png"; // Gambar default
    handlerResetLabels();
  });
  // ** Nama Lengkap Siswa : Input
  const editInputNamaLengkapSiswa = document.getElementById('edit-nama-lengkap');
  editInputNamaLengkapSiswa.addEventListener('keyup', (e) => handleInputNamaLengkapSiswa(e));
  // ** NIK : Input
  const editInputNIK = document.getElementById('edit-nik');
  editInputNIK.addEventListener('keyup', (e) => handleNIK(e));
  // ** Tempat Lahir : Input
  const editInputTempatLahir = document.getElementById('edit-tempat-lahir');
  editInputTempatLahir.addEventListener('keyup', (e) => handleInputTempatLahir(e));
  // ** Tanggal Lahir : Select
  const editSelectTanggalLahir = document.getElementById('edit-tanggal-lahir');
  editSelectTanggalLahir.addEventListener('change', (e) => handleSelectTanggalLahir(e));
  // ** Jenis Kelamin : Select
  const editSelectJenisKelamin = document.getElementById('edit-jenis-kelamin');
  editSelectJenisKelamin.addEventListener('change', (e) => handleJenisKelamin(e));
  // ** Email : Input
  const editInputEmail = document.getElementById('edit-email');
  editInputEmail.addEventListener('focus', (e) => handleEmailAyah(e));
  editInputEmail.addEventListener('keyup', (e) => handleEmailAyah(e));
  // ** Nomor Telepon : Input
  const editInputNomorTelepon = document.getElementById('edit-nomor-telepon');
  editInputNomorTelepon.addEventListener('focus', (e) => handleNomorTeleponAyah(e));
  editInputNomorTelepon.addEventListener('keyup', (e) => handleNomorTeleponAyah(e));
  // ** Provinsi : Input
  const editInputProvinsi = document.getElementById('edit-provinsi');
  editInputProvinsi.addEventListener('keyup', (e) => handleProvinsi(e));
  // ** Kabupaten : Input
  const editInputKabupaten = document.getElementById('edit-kabupaten');
  editInputKabupaten.addEventListener('keyup', (e) => handleKabupaten(e));
  // ** Kecamatan : Input
  const editInputKecamatan = document.getElementById('edit-kecamatan');
  editInputKecamatan.addEventListener('keyup', (e) => handleKecamatan(e));
  // ** Desa : Input
  const editInputDesa = document.getElementById('edit-desa');
  editInputDesa.addEventListener('keyup', (e) => handleDesa(e));
  // ** RT : Input
  const editInputRT = document.getElementById('edit-rt');
  editInputRT.addEventListener('keyup', (e) => handleRT(e));
  // ** RW : Input
  const editInputRW = document.getElementById('edit-rw');
  editInputRW.addEventListener('keyup', (e) => handleRW(e));
  // ** KodePost : Input
  const editInputKodePost = document.getElementById('edit-kode-post');
  editInputKodePost.addEventListener('keyup', (e) => handleKodePost(e));

  // Handle Reset Edit Form
  function handleResetEdit() {
    // Get data NIK
    const formEditModal = document.getElementById('form-edit-modal')
    const nik = formEditModal.getAttribute('nik');
    const result = dt_ayah.find((data) => {
      if (data.nomor_identitas_kependudukan == nik) {
        return data
      }
    }) || dt_ibu.find((data) => {
      if (data.nomor_identitas_kependudukan == nik) {
        return data
      }
    });
    // Set Data Diri
    editInputNamaLengkapSiswa.value = result.nama_lengkap;
    editInputNIK.value = result.nomor_identitas_kependudukan;
    editInputTempatLahir.value = result.tempat_lahir;
    editSelectTanggalLahir.value = result.tanggal_lahir;
    editSelectJenisKelamin.value = result.jenis_kelamin;
    // Set Data Alamat
    editInputProvinsi.value = result.provinsi;
    editInputKabupaten.value = result.kabupaten;
    editInputKecamatan.value = result.kecamatan;
    editInputDesa.value = result.desa;
    editInputRT.value = result.rt;
    editInputRW.value = result.rw;
    editInputKodePost.value = result.kode_pos;
    // Photo Profile
    const previewImage = document.getElementById('edit-preview-image');
    previewImage.src = result.photo;
    const inputImage = document.getElementById('edit-photo-profile');
    inputImage.value = "";
  }

    // ** Modals Edit Action : Confirm
    function loadConfirmEdit() {
      const targetElement = document.getElementById('container-modal-edit');
      const formEdit = document.getElementById('form-edit-modal'); // Ambil elemen form

      Swal.fire({
        title: "Pembaruan Data Orang Tua,<br> Anda Yakin?",
        showConfirmButton: true,
        showDenyButton: false,
        showCancelButton: true,
        cancelButtonColor: 'orange',
        confirmButtonColor: 'blue',
        confirmButtonText: `Ya, Saya Yakin`,
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
        if (result.isConfirmed) {
          // Jika tombol Confirm ditekan, submit formulir
          formEdit.submit();
        }
      });
    }

  // ** Modals Edit : Open
  function loadModalEdit(nik) {
    // Get Detail Data
    orangTua.detail = orangTua.main_datas.find((data) => parseInt(data.nomor_identitas_kependudukan) === parseInt(nik));

    console.log('Edit : ', orangTua.detail);
    const elements = document.getElementById('container-modal-edit');
          elements.classList.remove('hidden');
          elements.classList.add('absolute');
    const formEditModal = document.getElementById('form-edit-modal');
          formEditModal.setAttribute('nik', orangTua.detail.nomor_identitas_kependudukan);
    const swalMask = document.getElementById('swal-mask');
    if (swalMask) {
      elements.removeChild(swalMask);
    }

    // Handle Label
    function handleCheckInputValue(value, target) {
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
      } else {
        span.className = "font-bold text-green-500";
        span.innerHTML = "&#10003;";
        span.id = "no-empty";
      }

      // Tambahkan elemen baru ke target
      target.appendChild(span);
    }

      // SET INPUT & LABEL VALUE
      let tempValue = null;

      // Nama Lengkap
      const editInputNamaLengkap = document.getElementById('edit-nama-lengkap');
      const labelEditInputNamaLengkap = document.getElementById('label-edit-nama-lengkap');
      tempValue = orangTua.detail.nama_lengkap;
      editInputNamaLengkap.value = tempValue;
      handleCheckInputValue(tempValue, labelEditInputNamaLengkap);
      // NIK
      const editInputNIK = document.getElementById('edit-nik');
      const labelEditInputNIK = document.getElementById('label-edit-nik');
      tempValue = orangTua.detail.nomor_identitas_kependudukan;
      editInputNIK.value = tempValue;
      handleCheckInputValue(tempValue, labelEditInputNIK);
      // Tempat Lahir
      const editInputTempatLahir = document.getElementById('edit-tempat-lahir');
      const labelEditInputTempatLahir = document.getElementById('label-edit-tempat-lahir');
      tempValue = orangTua.detail.tempat_lahir;
      editInputTempatLahir.value = tempValue;
      handleCheckInputValue(tempValue, labelEditInputTempatLahir);
      // Tanggal Lahir
      const editInputTanggalLahir = document.getElementById('edit-tanggal-lahir');
      const labelEditInputTanggalLahir = document.getElementById('label-edit-tanggal-lahir');
      tempValue = orangTua.detail.tanggal_lahir;
      editInputTanggalLahir.value = tempValue;
      handleCheckInputValue(tempValue, labelEditInputTanggalLahir);
      editInputTanggalLahir.value = orangTua.detail.tanggal_lahir;
      // Jenis Kelamin
      const editSelectJenisKelamin = document.getElementById('edit-jenis-kelamin');
      tempValue = orangTua.detail.jenis_kelamin;
      editSelectJenisKelamin.value = tempValue;
      const labelEditSelectJenisKelamin = document.getElementById('label-edit-jenis-kelamin');
      handleCheckInputValue(tempValue, labelEditSelectJenisKelamin);
      // Hubungan
      const editSelectHubungan = document.getElementById('edit-hubungan');
      tempValue = orangTua.detail.hubungan;
      editSelectHubungan.value = tempValue;
      const labelEditSelectHubungan = document.getElementById('label-edit-hubungan');
      handleCheckInputValue(tempValue, labelEditSelectHubungan);
      // Pekerjaan
      const editInputPekerjaan = document.getElementById('edit-pekerjaan');
      tempValue = orangTua.detail.pekerjaan;
      editInputPekerjaan.value = tempValue;
      const labelEditInputPekerjaan = document.getElementById('label-edit-pekerjaan');
      handleCheckInputValue(tempValue, labelEditInputPekerjaan);
      // Email
      const editInputEmail = document.getElementById('edit-email');
      tempValue = orangTua.detail.email;
      editInputEmail.value = tempValue;
      const labelEditInputEmail = document.getElementById('label-edit-email');
      handleCheckInputValue(tempValue, labelEditInputEmail);
      // Nomor Telepon
      const editInputNomorTelepon = document.getElementById('edit-nomor-telepon');
      tempValue = orangTua.detail.nomor_telepon;
      editInputNomorTelepon.value = tempValue;
      const labelEditInputNomorTelepon = document.getElementById('label-edit-nomor-telepon');
      handleCheckInputValue(tempValue, labelEditInputNomorTelepon);
      // Data Alamat
      // ** Provinsi
      const editInputProvinsi = document.getElementById('edit-provinsi');
      tempValue = orangTua.detail.provinsi;
      editInputProvinsi.value = tempValue;
      const labelEditInputProvinsi = document.getElementById('edit-label-provinsi');
      handleCheckInputValue(tempValue, labelEditInputProvinsi);
      // ** Kabupaten
      const editInputKabupaten = document.getElementById('edit-kabupaten');
      tempValue = orangTua.detail.kabupaten;
      editInputKabupaten.value = tempValue;
      const labelEditInputKabupaten = document.getElementById('edit-label-kabupaten');
      handleCheckInputValue(tempValue, labelEditInputKabupaten);
      // ** Kecamatan
      const editInputKecamatan = document.getElementById('edit-kecamatan');
      tempValue = orangTua.detail.kecamatan;
      editInputKecamatan.value = tempValue;
      const labelEditInputKecamatan = document.getElementById('edit-label-kecamatan');
      handleCheckInputValue(tempValue, labelEditInputKecamatan);
      // ** Desa
      const editInputDesa = document.getElementById('edit-desa');
      tempValue = orangTua.detail.desa;
      editInputDesa.value = tempValue;
      const labelEditInputDesa = document.getElementById('edit-label-desa');
      handleCheckInputValue(tempValue, labelEditInputDesa);
      // ** RT
      const editInputRT = document.getElementById('edit-rt');
      tempValue = orangTua.detail.rt;
      editInputRT.value = tempValue;
      const labelEditInputRT = document.getElementById('edit-label-rt');
      handleCheckInputValue(tempValue, labelEditInputRT);
      // ** RW
      const editInputRW = document.getElementById('edit-rw');
      tempValue = orangTua.detail.rw;
      editInputRW.value = tempValue;
      const labelEditInputRW = document.getElementById('edit-label-rw');
      handleCheckInputValue(tempValue, labelEditInputRW);
      // ** Kode Post
      const editInputKodePost = document.getElementById('edit-kode-post');
      tempValue = orangTua.detail.kode_pos;
      editInputKodePost.value = tempValue;
      const labelEditInputKodePost = document.getElementById('edit-label-kode-post');
      handleCheckInputValue(tempValue, labelEditInputKodePost);
      // ** Photo Profile
      // priview image
      const editPhotoProfile = document.getElementById('edit-preview-image');
      editPhotoProfile.src = orangTua.detail.photo;
      // input photo profile
      const editInputPhotoProfile = document.getElementById('edit-photo-profile');
      editInputPhotoProfile.src = orangTua.detail.photo;
  }

  // ** Modals Edit : Close
  function closeModalEdit() {
    const targetElement = document.getElementById('container-modal-edit');
    Swal.fire({
      title: "Batal Edit Data Orang Tua,<br> Anda Yakin?",
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
</script>
