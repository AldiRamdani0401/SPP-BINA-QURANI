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
  <form id="form-modal" method="POST" action="/master-data/siswa/create" enctype="multipart/form-data"
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
              <label for="nik" id="label-nik" class="font-medium text-slate-700 text-nowrap">
                <span>Nomor Identitas Kependudukan (NIK) :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="nik" inputmode="numeric" pattern="[0-9\s]{13,19}" name="nomor-identitas-kependudukan"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="NIK sesuai KTP" title="Pastikan sesuai KTP"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <!-- Nama Lengkap -->
            <div class="group flex flex-col gap-1">
              <label for="nama-lengkap-ayah" id="label-nama-lengkap-ayah" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                <span>Nama Lengkap :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="nama-lengkap" name="nama-lengkap"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Nama Lengkap sesuai KTP" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
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
            <!-- Content 2 -->
           <div class="flex flex-col">
             <!-- Hubungan -->
             <div class="group flex flex-col gap-1">
               <label for="edit-jenis-kelamin" id="label-edit-jenis-kelamin" class="font-medium text-slate-700 text-[16px] focus:font-semibold">
                 <span>Hubungan :</span>
                 <span id="empty" class="text-red-500 text-lg">*</span>
               </label>
               <select id="edit-jenis-kelamin" name="jenis-kelamin"
                 class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300">
                 <option disabled selected value="">Pilih Jenis Kelamin</option>
                 <option value="Ayah">👦🏻 Ayah</option>
                 <option value="Ibu">👧🏻 Ibu</option>
               </select>
             </div>
             <!-- Email -->
             <div class="flex flex-col gap-1">
               <label for="email" id="label-email" class="font-medium text-slate-700">
                 <span>Email :</span>
                 <span id="empty" class="text-red-500 text-lg">*</span>
               </label>
               <input type="email" id="email" name="email"
                 class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                 placeholder="example@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                 title="Masukkan email yang valid">
             </div>
             <!-- Nomor Telepon -->
             <div class="flex flex-col gap-1">
               <label for="nomor-telepon" id="label-nomor-telepon" class="font-medium text-slate-700">
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
               <label for="pekerjaan" id="label-pekerjaan" class="font-medium text-slate-700">
                 <span>Pekerjaan :</span>
                 <span id="empty" class="text-red-500 text-lg">*</span>
               </label>
               <input type="text" id="pekerjaan" name="pekerjaan"
                 class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                 placeholder="example@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                 title="Masukkan pekerjaan yang valid">
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
              <label for="provinsi" id="label-provinsi" class="font-medium text-slate-700">
                <span>Provinsi :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="provinsi" name="provinsi"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Provinsi" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Kabupaten -->
            <div class="flex flex-col gap-1">
              <label for="kabupaten" id="label-kabupaten" class="font-medium text-slate-700">
                <span>Kabupaten :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="kabupaten" name="kabupaten"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Kabupaten" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Kecamatan -->
            <div class="flex flex-col gap-1">
              <label for="kecamatan" id="label-kecamatan" class="font-medium text-slate-700">
                <span>Kecamatan :</span>
                <span id="empty" class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="kecamatan" name="kecamatan"
                class="px-2 border border-slate-300 rounded-md focus:ring-1 focus:ring-blue-300 "
                placeholder="Kecamatan" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
            </div>
            <!-- Desa / Kelurahan -->
            <div class="flex flex-col gap-1">
              <label for="desa" id="label-desa" class="font-medium text-slate-700">
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
              <label for="rt" id="label-rt" class="font-medium text-slate-700">
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
              <label for="rw" id="label-rw" class="font-medium text-slate-700">
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
              <label for="kode-post" id="label-kode-post" class="font-medium text-slate-700">
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
          <img src="/images/logo/_/default-image" id="preview-image"
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
  const md_ayah = <?= json_encode($dataAyah) ?>;
  const md_ibu = <?= json_encode($dataIbu) ?>;

  // Kelas
  const md_kelas = <?= json_encode($dataKelas) ?>;
  function setKelasOption () {
    const kelasSelectElement = document.getElementById('kelas');
    md_kelas.forEach(value => {
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

  let timer; // Variabel timer di luar fungsi untuk menjaga state debounce
  // ** Nama Lengkap Siswa
  function handleInputNamaLengkapSiswa(e) {
    const value = e.target.value;
    const element = document.getElementById('label-nama-lengkap');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Nomor Induk Siswa
  function handleInputNomorIndukSiswa(e) {
    const value = e.target.value;
    const element = document.getElementById('label-nomor-induk-siswa');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Tempat Lahir
  function handleInputTempatLahir(e) {
    const value = e.target.value;
    const element = document.getElementById('label-tempat-lahir');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Tanggal Lahir
  function handleSelectTanggalLahir(e) {
    const value = e.target.value;
    const element = document.getElementById('label-tanggal-lahir');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Jenis Kelamin
  function handleJenisKelamin(e) {
    const value = e.target.value;
    const element = document.getElementById('label-jenis-kelamin');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kelas
  function handleSelectKelas(e) {
    const value = e.target.value;
    const element = document.getElementById('label-kelas');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** NIK
  function handleInputNIK(e) {
    const value = e.target.value;
    const inputId = e.target.id;
    const element = document.getElementById(inputId);
    let result;
    clearTimeout(timer); // Hapus timer sebelumnya
    timer = setTimeout(() => {
      if (inputId == 'nik-ayah') {
        result = md_ayah.find((data) => data.nomor_identitas_kependudukan == value);
        document.getElementById('nama-lengkap-ayah').value = result?.nama_lengkap ?? '';
        document.getElementById('email-ayah').value = result?.email ?? '';
        document.getElementById('nomor-telepon-ayah').value = result?.nomor_telepon ?? '';
      } else {
        result = md_ibu.find((data) => data.nomor_identitas_kependudukan == value);
        document.getElementById('nama-lengkap-ibu').value = result?.nama_lengkap ?? '';
        document.getElementById('email-ibu').value = result?.email ?? '';
        document.getElementById('nomor-telepon-ibu').value = result?.nomor_telepon ?? '';
      }
      const nikElement = document.getElementById(inputId == 'nik-ayah' ? 'label-nik-ayah' : 'label-nik-ibu' );
      const namaLengkapElement = document.getElementById(inputId == 'nik-ayah' ? 'label-nama-lengkap-ayah' : 'label-nama-lengkap-ibu' );
      const emailElement = document.getElementById(inputId == 'nik-ayah' ? 'label-email-ayah' : 'label-email-ibu' );
      const nomorTeleponElement = document.getElementById(inputId == 'nik-ayah' ? 'label-nomor-telepon-ayah' : 'label-nomor-telepon-ibu' );
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
  let namaLengkapAyah;
  function handleNamaLengkapAyah(e){
    const value = e.target.value;
    const element = document.getElementById('label-nama-lengkap-ayah');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof namaLengkapAyah === "undefined"){
        namaLengkapAyah = value;
      } else {
        if (namaLengkapAyah !== "undefined" && namaLengkapAyah === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Email Ayah
  let emailAyah;
  function handleEmailAyah(e){
    const value = e.target.value;
    const element = document.getElementById('label-email-ayah');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof emailAyah === "undefined"){
        emailAyah = value;
      } else {
        if (emailAyah !== "undefined" && emailAyah === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Telepon Ayah
  let teleponAyah;
  function handleNomorTeleponAyah(e){
    const value = e.target.value;
    const element = document.getElementById('label-nomor-telepon-ayah');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof teleponAyah === "undefined"){
        teleponAyah = value;
      } else {
        if (teleponAyah !== "undefined" && teleponAyah === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Nama Lengkap Ibu
  let namaLengkapIbu;
  function handleNamaLengkapIbu(e){
    const value = e.target.value;
    const element = document.getElementById('label-nama-lengkap-ibu');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof namaLengkapIbu === "undefined"){
        namaLengkapIbu = value;
      } else {
        if (namaLengkapIbu !== "undefined" && namaLengkapIbu === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Email Ibu
  let emailIbu;
  function handleEmailIbu(e){
    const value = e.target.value;
    const element = document.getElementById('label-email-ibu');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof emailIbu === "undefined"){
        emailIbu = value;
      } else {
        if (emailIbu !== "undefined" && emailIbu === value ) {
          handleCheckInputValue(value, element);
        } else {
          handleCheckInputValue("", element);
        }
      }
    }, 500);
  }
  // ** Nomor Telepon Ibu
  let nomorTeleponIbu;
  function handleNomorTeleponIbu(e){
    const value = e.target.value;
    const element = document.getElementById('label-nomor-telepon-ibu');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
      if (typeof nomorTeleponIbu === "undefined"){
        nomorTeleponIbu = value;
      } else {
        if (nomorTeleponIbu !== "undefined" && nomorTeleponIbu === value ) {
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
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kabupaten
  function handleKabupaten(e){
    const value = e.target.value;
    const element = document.getElementById('label-kabupaten');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Kecamatan
  function handleKecamatan(e){
    const value = e.target.value;
    const element = document.getElementById('label-kecamatan');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** Desa
  function handleDesa(e){
    const value = e.target.value;
    const element = document.getElementById('label-desa');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** RT
  function handleRT(e){
    const value = e.target.value;
    const element = document.getElementById('label-rt');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** RW
  function handleRW(e){
    const value = e.target.value;
    const element = document.getElementById('label-rw');
    clearTimeout(timer);
    timer = setTimeout(() => {
      handleCheckInputValue(value, element);
    }, 500);
  }
  // ** KodePost
  function handleKodePost(e){
    const value = e.target.value;
    const element = document.getElementById('label-kode-post');
    clearTimeout(timer);
    timer = setTimeout(() => {
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
      previewImage.src = "/images/logo/_/default-image";
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
    previewImage.src = "/images/logo/_/default-image"; // Gambar default
    handlerResetLabels();
  });
  // ** Nama Lengkap Siswa : Input
  const inputNamaLengkapSiswa = document.getElementById('nama-lengkap');
  inputNamaLengkapSiswa.addEventListener('keyup', (e) => handleInputNamaLengkapSiswa(e));
  // ** Nomor Induk Siswa : Input
  const inputNomorIndukSiswa = document.getElementById('nomor-induk-siswa');
  inputNomorIndukSiswa.addEventListener('keyup', (e) => handleInputNomorIndukSiswa(e));
  // ** Tempat Lahir : Input
  const inputTempatLahir = document.getElementById('tempat-lahir');
  inputTempatLahir.addEventListener('keyup', (e) => handleInputTempatLahir(e));
  // ** Tanggal Lahir : Select
  const selectTanggalLahir = document.getElementById('tanggal-lahir');
  selectTanggalLahir.addEventListener('change', (e) => handleSelectTanggalLahir(e));
  // ** Jenis Kelamin : Select
  const selectJenisKelamin = document.getElementById('jenis-kelamin');
  selectJenisKelamin.addEventListener('change', (e) => handleJenisKelamin(e));
  // ** Kelas : Select
  const selectKelas = document.getElementById('kelas');
  selectKelas.addEventListener('change', (e) => handleSelectKelas(e));
  // ** NIK Ayah : Input
  const inputNikAyahElement = document.getElementById('nik-ayah');
  inputNikAyahElement.addEventListener('keyup', (e) => handleInputNIK(e));
  // ** Nama Lengkap Ayah : Input
  const inputNamaLengkapAyah = document.getElementById('nama-lengkap-ayah');
  inputNamaLengkapAyah.addEventListener('focus', (e) => handleNamaLengkapAyah(e));
  inputNamaLengkapAyah.addEventListener('keyup', (e) => handleNamaLengkapAyah(e));
  // ** Email Ayah : Input
  const inputEmailAyah = document.getElementById('email-ayah');
  inputEmailAyah.addEventListener('focus', (e) => handleEmailAyah(e));
  inputEmailAyah.addEventListener('keyup', (e) => handleEmailAyah(e));
  // ** Nomor Telepon Ayah : Input
  const inputNomorTeleponAyah = document.getElementById('nomor-telepon-ayah');
  inputNomorTeleponAyah.addEventListener('focus', (e) => handleNomorTeleponAyah(e));
  inputNomorTeleponAyah.addEventListener('keyup', (e) => handleNomorTeleponAyah(e));
  // ** NIK Ibu : Input
  const inputNikIbuElement = document.getElementById('nik-ibu');
  inputNikIbuElement.addEventListener('keyup', (e) => handleInputNIK(e));
  // ** Nama Lengkap Ibu : Input
  const inputNamaLengkapIbu = document.getElementById('nama-lengkap-ibu');
  inputNamaLengkapIbu.addEventListener('focus', (e) => handleNamaLengkapIbu(e));
  inputNamaLengkapIbu.addEventListener('keyup', (e) => handleNamaLengkapIbu(e));
  // ** Email Ibu : Input
  const inputEmailIbu = document.getElementById('email-ibu');
  inputEmailIbu.addEventListener('focus', (e) => handleEmailIbu(e));
  inputEmailIbu.addEventListener('keyup', (e) => handleEmailIbu(e));
  // ** Nomor Telepon Ibu : Input
  const inputNomorTeleponIbu = document.getElementById('nomor-telepon-ibu');
  inputNomorTeleponIbu.addEventListener('focus', (e) => handleNomorTeleponIbu(e));
  inputNomorTeleponIbu.addEventListener('keyup', (e) => handleNomorTeleponIbu(e));
  // ** Provinsi : Input
  const inputProvinsi = document.getElementById('provinsi');
  inputProvinsi.addEventListener('keyup', (e) => handleProvinsi(e));
  // ** Kabupaten : Input
  const inputKabupaten = document.getElementById('kabupaten');
  inputKabupaten.addEventListener('keyup', (e) => handleKabupaten(e));
  // ** Kecamatan : Input
  const inputKecamatan = document.getElementById('kecamatan');
  inputKecamatan.addEventListener('keyup', (e) => handleKecamatan(e));
  // ** Desa : Input
  const inputDesa = document.getElementById('desa');
  inputDesa.addEventListener('keyup', (e) => handleDesa(e));
  // ** RT : Input
  const inputRT = document.getElementById('rt');
  inputRT.addEventListener('keyup', (e) => handleRT(e));
  // ** RW : Input
  const inputRW = document.getElementById('rw');
  inputRW.addEventListener('keyup', (e) => handleRW(e));
  // ** KodePost : Input
  const inputKodePost = document.getElementById('kode-post');
  inputKodePost.addEventListener('keyup', (e) => handleKodePost(e));

  // INITIAL
  // ** Kelas  : Select
  setKelasOption();
  console.log(document.getElementById('jenis-kelamin').value);
</script>
