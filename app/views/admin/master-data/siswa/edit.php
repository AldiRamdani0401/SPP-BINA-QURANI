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
    <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Form Edit Data Siswa</h1>
    <hr class="bg-lime-400 py-[1.8px] rounded-full">
  </div>
  <!-- Form Modal -->
  <form id="form-modal" method="POST" action="/master-data/siswa/create" enctype="multipart/form-data"
    class="flex flex-col gap-5 justify-between">
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
          <label for="edit-nama-lengkap" id="label-edit-nama-lengkap" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Nama Lengkap Siswa :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nama-lengkap" name="edit-nama-lengkap"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Nama Lengkap" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" title="Nama Lengkap Siswa wajib diisi." required>
        </div>
        <!-- Nomor Induk Siswa -->
        <div class="flex flex-col gap-1">
          <label for="edit-nomor-induk-siswa" id="label-edit-nomor-induk-siswa" class="font-medium text-slate-700">
            <span>NISN : </span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nomor-induk-siswa" inputmode="numeric"
            name="edit-nomor-induk-siswa"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            maxlength="10"
            placeholder="Nomor Induk Siswa" title="Hanya menerima angka 0-9 (wajib: 10 digit)" required
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <!-- Tempat Lahir -->
        <div class="group flex flex-col gap-1">
          <label for="edit-tempat-lahir" id="label-edit-tempat-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Tempat Lahir :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-tempat-lahir" name="edit-tempat-lahir"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 " required
            placeholder="Tempat Lahir" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Tanggal Lahir -->
        <div class="group flex flex-col gap-1">
          <label for="edit-tanggal-lahir" id="label-edit-tanggal-lahir" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Tanggal Lahir :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="date" id="edit-tanggal-lahir" name="edit-tanggal-lahir"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 ">
        </div>
        <!-- Jenis Kelamin -->
        <div class="group flex flex-col gap-1">
          <label for="edit-jenis-kelamin" id="label-edit-jenis-kelamin" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Jenis Kelamin :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <select id="edit-jenis-kelamin" name="edit-jenis-kelamin"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300">
            <option disabled selected value="">Pilih Jenis Kelamin</option>
            <option value="L">👦🏻 Laki-Laki</option>
            <option value="P">👧🏻 Perempuan</option>
          </select>
        </div>
        <!-- Kelas -->
        <div class="group flex flex-col gap-1">
          <label for="edit-kelas" id="label-edit-kelas" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Kelas :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <select id="edit-kelas" name="edit-kelas"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300">
            <option disabled selected value="">Pilih Kelas</option>
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
          <label for="edit-nik-ayah" id="label-edit-nik-ayah" class="font-medium text-slate-700">
            <span>NIK Ayah :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nik-ayah" inputmode="numeric" pattern="[0-9\s]{13,19}" name="edit-nik-ayah"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="NIK Ayah / Wali" title="Hanya menerima angka 0-9"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <!-- Nama Lengkap Ayah -->
        <div class="group flex flex-col gap-1">
          <label for="edit-nama-lengkap-ayah" id="label-edit-nama-lengkap-ayah" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Nama Lengkap Ayah / Wali :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nama-lengkap-ayah" name="edit-nama-lengkap-ayah"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Nama Lengkap Ayah" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Email Ayah -->
        <div class="flex flex-col gap-1">
          <label for="edit-email-ayah" id="label-edit-email-ayah" class="font-medium text-slate-700">
            <span>Email Ayah :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="email" id="edit-email-ayah" name="edit-email-ayah"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="example@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            title="Masukkan email yang valid">
        </div>
        <!-- Nomor Telepon Ayah -->
        <div class="flex flex-col gap-1">
          <label for="edit-nomor-telepon-ayah" id="label-edit-nomor-telepon-ayah" class="font-medium text-slate-700">
            <span>Nomor Telepon Ayah :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="tel" id="edit-nomor-telepon-ayah" name="edit-nomor-telepon-ayah"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300"
            placeholder="08XX-XXXX-XXXX" pattern="08[0-9]{8,11}" maxlength="13"
            title="Nomor telepon harus dimulai dengan '08' diikuti 8 hingga 11 digit angka."
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
        </div>
        <!-- NIK Ibu -->
        <div class="flex flex-col gap-1">
          <label for="edit-nik-ibu" id="label-edit-nik-ibu" class="font-medium text-slate-700">
            <span>NIK Ibu / Wali :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nik-ibu" inputmode="numeric" pattern="[0-9\s]{13,19}" name="edit-nik-ibu"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="NIK Ibu / Wali" title="Hanya menerima angka 0-9"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <!-- Nama Lengkap Ibu -->
        <div class="group flex flex-col gap-1">
          <label for="edit-nama-lengkap-ibu" id="label-edit-nama-lengkap-ibu" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
            <span>Nama Lengkap Ibu / Wali :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="edit-nama-lengkap-ibu" name="edit-nama-lengkap-ibu"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Nama Lengkap Ibu" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Email Ibu -->
        <div class="flex flex-col gap-1">
          <label for="edit-email-ibu" id="label-edit-email-ibu" class="font-medium text-slate-700">
            <span>Email Ibu :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="email" id="edit-email-ibu" name="edit-email-ibu"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="example@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            title="Masukkan email yang valid">
        </div>
        <!-- Nomor Telepon Ibu -->
        <div class="flex flex-col gap-1">
          <label for="edit-nomor-telepon-ibu" id="label-edit-nomor-telepon-ibu" class="font-medium text-slate-700">
            <span>Nomor Telepon Ibu :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="tel" id="edit-nomor-telepon-ibu" name="edit-nomor-telepon-ibu"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300"
            placeholder="08XX-XXXX-XXXX" pattern="08[0-9]{8,11}" maxlength="13"
            title="Nomor telepon harus dimulai dengan '08' diikuti 8 hingga 11 digit angka."
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
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
          <label for="provinsi" id="label-provinsi" class="font-medium text-slate-700">
            <span>Provinsi :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="provinsi" name="provinsi"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Provinsi" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Kabupaten -->
        <div class="flex flex-col gap-1">
          <label for="kabupaten" id="label-kabupaten" class="font-medium text-slate-700">
            <span>Kabupaten :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="kabupaten" name="kabupaten"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Kabupaten" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Kecamatan -->
        <div class="flex flex-col gap-1">
          <label for="kecamatan" id="label-kecamatan" class="font-medium text-slate-700">
            <span>Kecamatan :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="kecamatan" name="kecamatan"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Kecamatan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- Desa / Kelurahan -->
        <div class="flex flex-col gap-1">
          <label for="desa" id="label-desa" class="font-medium text-slate-700">
            <span>Desa / Kelurahan :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="desa" name="desa"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300"
            placeholder="Desa / Kelurahan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
        </div>
        <!-- RT -->
        <div class="flex flex-col gap-1">
          <label for="rt" id="label-rt" class="font-medium text-slate-700">
            <span>RT :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="rt" inputmode="numeric" name="rt"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Rukun Tetangga / RT" title="Hanya menerima angka 0-9"
            maxlength="3"
            requrired
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <!-- RW -->
        <div class="flex flex-col gap-1">
          <label for="rw" id="label-rw" class="font-medium text-slate-700">
            <span>RW :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="rw" inputmode="numeric" name="rw"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
            placeholder="Rukun Warga / RW" title="Hanya menerima angka 0-9"
            maxlength="3"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <!-- Kode Post -->
        <div class="flex flex-col gap-1">
          <label for="kode-post" id="label-kode-post" class="font-medium text-slate-700">
            <span>Kode Post :</span>
            <span id="empty" class="text-red-500 text-lg">*</span>
          </label>
          <input type="text" id="kode-post" inputmode="numeric" name="kode-post"
            class="px-2 border border-slate-300 rounded-md focus:ring focus:ring-1 focus:ring-blue-300 "
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
          <img src="http://localhost:100/assets/images/default-image.png" id="preview-image"
            class="h-full w-full border rounded-md object-cover" alt="default image">
        </output>
        <input type="file" id="photo-profile" name="photo-profile" accept="image/*" class="mt-2 border rounded-r-md"
          onchange="updatePreview(event)">
      </div>
    </div>
    <div class="flex flex-row gap-5 justify-between">
      <button type="button"
        class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md" onclick="closeModalTambah()">Batal</button>
      <div class="flex flex-row gap-5">
        <button type="reset"
          class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md">Reset</button>
        <button
          class="bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md">Submit</button>
      </div>
    </div>
  </form>
</div>

<script>
  // States
  const dt_ayah = <?= json_encode($dataAyah) ?>;
  const dt_ibu = <?= json_encode($dataIbu) ?>;

  // Kelas
  const dt_kelas = <?= json_encode($dataKelas) ?>;
  function setKelasOption () {
    const kelasSelectElement = document.getElementById('edit-kelas');
    dt_kelas.forEach(value => {
      const option = document.createElement('option');
      option.value = value.nama_kelas;
      option.text = value.nama_kelas;
      kelasSelectElement.appendChild(option);
    });
  }

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
  // ** Nomor Induk Siswa
  function handleInputNomorIndukSiswa(e) {
    const value = e.target.value;
    const element = document.getElementById('label-edit-nomor-induk-siswa');
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
  // ** Kelas
  function handleSelectKelas(e) {
    const value = e.target.value;
    const element = document.getElementById('label-kelas');
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
  // ** Nama Lengkap Ayah
  let editNamaLengkapAyah;
  function handleNamaLengkapAyah(e){
    const value = e.target.value;
    const element = document.getElementById('label-edit-nama-lengkap-ayah');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof editNamaLengkapAyah === "undefined"){
        editNamaLengkapAyah = value;
      } else {
        if (editNamaLengkapAyah !== "undefined" && editNamaLengkapAyah === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
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
  // ** Nama Lengkap Ibu
  let editNamaLengkapIbu;
  function handleNamaLengkapIbu(e){
    const value = e.target.value;
    const element = document.getElementById('label-edit-nama-lengkap-ibu');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof editNamaLengkapIbu === "undefined"){
        editNamaLengkapIbu = value;
      } else {
        if (editNamaLengkapIbu !== "undefined" && editNamaLengkapIbu === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Email Ibu
  let editEmailIbu;
  function handleEmailIbu(e){
    const value = e.target.value;
    const element = document.getElementById('label-edit-email-ibu');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof editEmailIbu === "undefined"){
        editEmailIbu = value;
      } else {
        if (editEmailIbu !== "undefined" && editEmailIbu === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Nomor Telepon Ibu
  let editNomorTeleponIbu;
  function handleNomorTeleponIbu(e){
    const value = e.target.value;
    const element = document.getElementById('label-edit-nomor-telepon-ibu');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof editNomorTeleponIbu === "undefined"){
        editNomorTeleponIbu = value;
      } else {
        if (editNomorTeleponIbu !== "undefined" && editNomorTeleponIbu === value ) {
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
    const element = document.getElementById('label-provinsi');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kabupaten
  function handleKabupaten(e){
    const value = e.target.value;
    const element = document.getElementById('label-kabupaten');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kecamatan
  function handleKecamatan(e){
    const value = e.target.value;
    const element = document.getElementById('label-kecamatan');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Desa
  function handleDesa(e){
    const value = e.target.value;
    const element = document.getElementById('label-desa');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** RT
  function handleRT(e){
    const value = e.target.value;
    const element = document.getElementById('label-rt');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** RW
  function handleRW(e){
    const value = e.target.value;
    const element = document.getElementById('label-rw');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** KodePost
  function handleKodePost(e){
    const value = e.target.value;
    const element = document.getElementById('label-kode-post');
    clearTimeout(editTimer);
    editTimer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Photo Profile: Preview
  function updatePreview(event) {
    const file = event.target.files[0]; // Ambil file dari input
    const previewImage = document.getElementById('preview-image'); // Elemen gambar untuk preview

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
  document.getElementById('form-modal').addEventListener('reset', () => {
    const previewImage = document.getElementById('preview-image');
    previewImage.src = "http://localhost:100/assets/images/default-image.png"; // Gambar default
    handlerResetLabels();
  });
  // ** Nama Lengkap Siswa : Input
  const editInputNamaLengkapSiswa = document.getElementById('edit-nama-lengkap');
  editInputNamaLengkapSiswa.addEventListener('keyup', (e) => handleInputNamaLengkapSiswa(e));
  // ** Nomor Induk Siswa : Input
  const editInputNomorIndukSiswa = document.getElementById('edit-nomor-induk-siswa');
  editInputNomorIndukSiswa.addEventListener('keyup', (e) => handleInputNomorIndukSiswa(e));
  // ** Tempat Lahir : Input
  const editInputTempatLahir = document.getElementById('edit-tempat-lahir');
  editInputTempatLahir.addEventListener('keyup', (e) => handleInputTempatLahir(e));
  // ** Tanggal Lahir : Select
  const editSelectTanggalLahir = document.getElementById('edit-tanggal-lahir');
  editSelectTanggalLahir.addEventListener('change', (e) => handleSelectTanggalLahir(e));
  // ** Jenis Kelamin : Select
  const editSelectJenisKelamin = document.getElementById('edit-jenis-kelamin');
  editSelectJenisKelamin.addEventListener('change', (e) => handleJenisKelamin(e));
  // ** Kelas : Select
  const editSelectKelas = document.getElementById('kelas');
  editSelectKelas.addEventListener('change', (e) => handleSelectKelas(e));
  // ** NIK Ayah : Input
  const editInputNikAyahElement = document.getElementById('edit-nik-ayah');
  editInputNikAyahElement.addEventListener('keyup', (e) => handleInputNIK(e));
  // ** Nama Lengkap Ayah : Input
  const editInputNamaLengkapAyah = document.getElementById('edit-nama-lengkap-ayah');
  editInputNamaLengkapAyah.addEventListener('focus', (e) => handleNamaLengkapAyah(e));
  editInputNamaLengkapAyah.addEventListener('keyup', (e) => handleNamaLengkapAyah(e));
  // ** Email Ayah : Input
  const editInputEmailAyah = document.getElementById('edit-email-ayah');
  editInputEmailAyah.addEventListener('focus', (e) => handleEmailAyah(e));
  editInputEmailAyah.addEventListener('keyup', (e) => handleEmailAyah(e));
  // ** Nomor Telepon Ayah : Input
  const editInputNomorTeleponAyah = document.getElementById('edit-nomor-telepon-ayah');
  editInputNomorTeleponAyah.addEventListener('focus', (e) => handleNomorTeleponAyah(e));
  editInputNomorTeleponAyah.addEventListener('keyup', (e) => handleNomorTeleponAyah(e));
  // ** NIK Ibu : Input
  const editInputNikIbu = document.getElementById('edit-nik-ibu');
  editInputNikIbu.addEventListener('keyup', (e) => handleInputNIK(e));
  // ** Nama Lengkap Ibu : Input
  const editInputNamaLengkapIbu = document.getElementById('edit-nama-lengkap-ibu');
  editInputNamaLengkapIbu.addEventListener('focus', (e) => handleNamaLengkapIbu(e));
  editInputNamaLengkapIbu.addEventListener('keyup', (e) => handleNamaLengkapIbu(e));
  // ** Email Ibu : Input
  const editInputEmailIbu = document.getElementById('edit-email-ibu');
  editInputEmailIbu.addEventListener('focus', (e) => handleEmailIbu(e));
  editInputEmailIbu.addEventListener('keyup', (e) => handleEmailIbu(e));
  // ** Nomor Telepon Ibu : Input
  const editInputNomorTeleponIbu = document.getElementById('edit-nomor-telepon-ibu');
  editInputNomorTeleponIbu.addEventListener('focus', (e) => handleNomorTeleponIbu(e));
  editInputNomorTeleponIbu.addEventListener('keyup', (e) => handleNomorTeleponIbu(e));
  // ** Provinsi : Input
  const editInputProvinsi = document.getElementById('provinsi');
  editInputProvinsi.addEventListener('keyup', (e) => handleProvinsi(e));
  // ** Kabupaten : Input
  const editInputKabupaten = document.getElementById('kabupaten');
  editInputKabupaten.addEventListener('keyup', (e) => handleKabupaten(e));
  // ** Kecamatan : Input
  const editInputKecamatan = document.getElementById('kecamatan');
  editInputKecamatan.addEventListener('keyup', (e) => handleKecamatan(e));
  // ** Desa : Input
  const editInputDesa = document.getElementById('desa');
  editInputDesa.addEventListener('keyup', (e) => handleDesa(e));
  // ** RT : Input
  const editInputRT = document.getElementById('rt');
  editInputRT.addEventListener('keyup', (e) => handleRT(e));
  // ** RW : Input
  const editInputRW = document.getElementById('rw');
  editInputRW.addEventListener('keyup', (e) => handleRW(e));
  // ** KodePost : Input
  const editInputKodePost = document.getElementById('kode-post');
  editInputKodePost.addEventListener('keyup', (e) => handleKodePost(e));


  // INITIAL
  // ** Kelas  : Select
  setKelasOption();
</script>
