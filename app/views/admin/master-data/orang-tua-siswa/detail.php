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

<style>
  /* Untuk Firefox */
  .thin-scrollbar {
    scrollbar-width: thin; /* Mengatur lebar scrollbar menjadi tipis */
    scrollbar-color: rgba(0, 0, 0, 0.4) rgba(0, 0, 0, 0.1); /* Mengatur warna scroll track dan thumb */
  }

  /* Untuk browser berbasis WebKit seperti Chrome, Safari */
  .thin-scrollbar::-webkit-scrollbar {
    width: 6px; /* Mengatur lebar scrollbar */
    height: 6px; /* Untuk scrollbar horizontal */
  }

  .thin-scrollbar::-webkit-scrollbar-track {
    background-color: rgba(0, 0, 0, 0.1); /* Warna track */
  }

  .thin-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.4); /* Warna thumb scrollbar */
    border-radius: 10px; /* Membuat ujung scrollbar lebih membulat */
  }

  .thin-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0, 0, 0, 0.7); /* Hover pada scrollbar */
  }
</style>

<!-- Detail Data Siswa -->
<div class="flex flex-col gap-4 py-2 px-4 bg-white w-[50%] h-fit rounded-xl shadow-xl">
  <div class="">
    <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Detail Data Orang Tua</h1>
    <hr class="bg-lime-400 py-[1.8px] rounded-full">
  </div>
  <!-- Container Detail Data Orang Tua -->
  <div id="container-detail-data-siswa"
    class="flex flex-col gap-5 justify-between">
    <div class="flex flex-row gap-3">
      <!-- Sub-Container 1 : Slide Data -->
       <div class="flex flex-col w-full gap-5 max-h-[300px] px-2 py-6 shadow-inner overflow-auto thin-scrollbar">
         <!-- Slide 1 : Data Diri Orang Tua -->
         <div class="group flex flex-col gap-2 w-full py-2 px-3 rounded-md shadow-lg text-nowrap border">
           <!-- Title Card -->
           <div class="">
             <div class="text-lg font-bold">Data Diri</div>
             <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
           </div>
           <!-- Nama Lengkap -->
           <div id="nama-lengkap" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nama Lengkap</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nama-lengkap-value" class="w-full px-2">?</span>
           </div>
           <!-- NIK -->
           <div id="nik-orangtua" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">NIK</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nik-orangtua-value" class="w-full px-2">?</span>
           </div>
           <!-- Tempat Lahir -->
           <div id="tempat-lahir" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tempat Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tempat-lahir-value" class="w-full px-2">?</span>
           </div>
           <!-- Tanggal Lahir -->
           <div id="tanggal-lahir" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tanggal Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tanggal-lahir-value" class="w-full px-2">?</span>
           </div>
           <!-- Jenis Kelamin -->
           <div id="jenis-kelamin" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Jenis Kelamin</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="jenis-kelamin-value" class="w-full px-2">?</span>
           </div>
           <!-- Nomor Telepon -->
           <div id="nomor-telepon" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nomor Telepon</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nomor-telepon-value" class="w-full px-2">?</span>
           </div>
           <!-- Email -->
           <div id="email" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Email</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="email-value" class="w-full px-2">?</span>
           </div>
           <!-- Pekerjaan -->
           <div id="pekerjaan" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Pekerjaan</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="pekerjaan-value" class="w-full px-2">?</span>
           </div>
         </div>
         <!-- Slide 2 : Data Keluarga -->
         <div class="group flex flex-col gap-2 w-full py-2 px-3 rounded-md shadow-lg text-nowrap border">
           <!-- Title Card -->
           <div class="">
             <div class="text-lg font-bold">Data Keluarga</div>
             <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
           </div>
          <!-- Data Suami / Istri & Anak -->
          <div class="relative mt-2">
            <h1 class="absolute bg-white text-slate-700 top-[-10px] left-8 px-1 text-sm font-bold">Data <span id="label-pasangan">Istri</span></h1>
            <hr class="py-[1px] bg-slate-400 rounded-full">
          </div>
           <!-- NIK Suami / Istri -->
           <div id="nik-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">NIK</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nik-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Nama Lengkap Pasangan -->
           <div id="nama-lengkap-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nama Lengkap</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nama-lengkap-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Tempat Lahir Pasangan -->
           <div id="tempat-lahir-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tempat Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tempat-lahir-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Tanggal Lahir Pasangan -->
           <div id="tanggal-lahir-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tanggal Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tanggal-lahir-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Jenis Kelamin Pasangan -->
           <div id="jenis-kelamin-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Jenis Kelamin</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="jenis-kelamin-pasangan-value" class="w-full px-2">?</span>
           </div>
            <!-- Nomor Telepon Pasangan -->
            <div id="nomor-telepon-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nomor Telepon</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nomor-telepon-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Email Pasangan -->
           <div id="email-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Email</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="email-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Pekerjaan Pasangan -->
           <div id="pekerjaan-pasangan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Pekerjaan</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="pekerjaan-pasangan-value" class="w-full px-2">?</span>
           </div>
           <!-- Data Anak -->
           <div class="relative mt-2">
            <h1 class="absolute bg-white text-slate-700 top-[-10px] left-8 px-1 text-sm font-bold">Data Anak</h1>
            <hr class="py-[1px] bg-slate-400 rounded-full">
           </div>
           <!-- NISN Anak -->
           <div id="nisn-anak" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">NISN</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nisn-anak-value" class="w-full px-2">?</span>
           </div>
           <!-- Nama Lengkap Anak -->
           <div id="nama-lengkap-anak" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nama Lengkap</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nama-lengkap-anak-value" class="w-full px-2">?</span>
           </div>
           <!-- Jenis Kelamin Anak -->
           <div id="jenis-kelamin-anak" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Jenis Kelamin</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="jenis-kelamin-anak-value" class="w-full px-2">?</span>
           </div>
           <!-- Kelas -->
           <div id="kelas-anak" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kelas</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="kelas-anak-value" class="w-full px-2">?</span>
           </div>
           <!-- Tempat Lahir -->
           <div id="tempat-lahir-anak" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tempat Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tempat-lahir-anak-value" class="w-full px-2">?</span>
           </div>
           <!-- Tanggal Lahir -->
           <div id="tanggal-lahir-anak" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tanggal Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tanggal-lahir-anak-value" class="w-full px-2">?</span>
           </div>
         </div>
         <!-- Slide 3 : Alamat -->
         <div class="group flex flex-col gap-2 w-full py-2 px-3 rounded-md shadow-lg text-nowrap border">
           <!-- Title Card -->
           <div class="">
             <div class="text-lg font-bold">Alamat</div>
             <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
           </div>
           <!-- Provinsi -->
           <div id="provinsi" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Provinsi</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="provinsi-value" class="w-full px-2">?</span>
           </div>
           <!-- Kabupaten -->
           <div id="kabupaten" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kabupaten</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="kabupaten-value" class="w-full px-2">?</span>
           </div>
            <!-- Kecamatan -->
            <div id="kecamatan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kecamatan</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="kecamatan-value" class="w-full px-2">?</span>
           </div>
            <!-- Desa -->
            <div id="desa" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Desa / Kelurahan</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="desa-value" class="w-full px-2">?</span>
           </div>
            <!-- RT / RW -->
            <div id="rt-rw" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">RT / RW</span>
                 <span class="font-medium">:</span>
               </div>
               <div class="flex flex-row w-full">
                <span id="rt-value" class="px-1">?</span>
                /
                <span id="rw-value" class="px-1">?</span>
               </div>
           </div>
            <!-- Kode Post -->
            <div id="kode-post" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kode Post</span>
                 <span class="font-medium">:</span>
               </div>
              <span id="kode-post-value" class="w-full px-1">?</span>
           </div>
         </div>
       </div>
      <!-- Sub-Container 2 : Photo Profile -->
      <div class="group flex flex-col w-80 h-fit gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Photo Profile</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-yellow-300 group-focus-within:bg-blue-500">
        </div>
        <!-- Photo Profile -->
        <output name="x" class="h-60 w-full">
          <img src="http://localhost:100/images/logo/_/default-image" id="detail-photo-profile"
            class="h-full w-full border rounded-md object-cover" alt="default image">
        </output>
      </div>
    </div>
    <div class="flex flex-row gap-5 justify-between">
      <button type="button"
        class="bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-10 py-1 text-lg  rounded-md" onclick="closeModalDetail()">Kembali</button>
      <div class="flex flex-row gap-5">
        <button type="button" id="btn-edit"
          class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md">Edit</button>
          <form action="/master-data/orang-tua/delete" method="POST" id="delete-form">
            <input type="hidden" name="_method" value="DELETE" />
            <input type="hidden" id="deleted-nik" name="nik" />
            <button type="button"
            class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md"
            onclick="deleteEditDataOrangTuaSiswa()">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // === ACTIONS ===
  function deleteEditDataOrangTuaSiswa() {
    const targetElement = document.getElementById('container-modal-detail');
    Swal.fire({
      title: "<span class='text-red-500 font-semibold'>Danger Zone</span><br><hr class='my-1'>Hapus Data Orang Tua,<br> Anda Yakin?",
      showConfirmButton: true,
      showDenyButton: false,
      showCancelButton: true,
      cancelButtonColor: 'blue',
      confirmButtonColor: 'red',
      confirmButtonText: `Ya, Saya Yakin`,
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
      },
    }).then((result) => {
        if (result.isConfirmed) {
          // Jika tombol Confirm ditekan, submit formulir
          document.getElementById("delete-form").submit();
        }
      });
}

  // === MODALS ===
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
    const dataAnak = orangTua?.anak();
    const dataPasangan = orangTua.pasangan(orangTua?.detail?.nama_lengkap, dataAnak);
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

    if (dataAnak && dataPasangan) {
      // ** (Data Pasangan: NIK, Nama Lengkap, Email, Nomor Telepon)
      const labelPasangan = document.getElementById('label-pasangan');
      labelPasangan.innerText = orangTua.detail?.hubungan === "Ayah" ? 'Istri' : 'Suami';
      const nikPasangan = document.getElementById('nik-pasangan-value');
      nikPasangan.innerText = dataPasangan.nomor_identitas_kependudukan;
      const namaPasangan = document.getElementById('nama-lengkap-pasangan-value');
      namaPasangan.innerText = dataPasangan.nama_lengkap;
      const tempatLahirPasangan = document.getElementById('tempat-lahir-pasangan-value');
      tempatLahirPasangan.innerText = dataPasangan.tempat_lahir;
      const tanggalLahirPasangan = document.getElementById('tanggal-lahir-pasangan-value');
      tanggalLahirPasangan.innerText = Handler_Format_Date(dataPasangan.tanggal_lahir);
      const jenisKelaminPasangan = document.getElementById('jenis-kelamin-pasangan-value');
      jenisKelaminPasangan.innerText = dataPasangan?.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';;
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
        tanggalLahirAnak.innerText = Handler_Format_Date(dataAnak?.tanggal_lahir);
    }

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
    // ** Photo Profile
    const photoProfile = document.getElementById('detail-photo-profile');
    photoProfile.src = orangTua.detail.photo;

    // Set Edit Button Action
    const containerDetailOrangTua = document.getElementById('container-detail-data-siswa');
    const buttonEdit = containerDetailOrangTua.querySelector('#btn-edit');
    buttonEdit.addEventListener('click', () => {
      loadModalEdit(orangTua.detail.nomor_identitas_kependudukan);
    });

    const hiddenDeletedNIK = containerDetailOrangTua.querySelector('#deleted-nik');
          hiddenDeletedNIK.value = orangTua.detail.nomor_identitas_kependudukan;
  }
  // ** Modals Detail : Close
  function closeModalDetail() {
    orangTua.detail = [];
    const targetElement = document.getElementById('container-modal-detail');
    // Reset Data Anak
    const spanAnakElements = targetElement.querySelectorAll('span[id$="anak-value"]');
    Array.from(spanAnakElements).map((element) => {
      element.innerText = "?";
    })
    // Reset Data Pasangan
    const spanPasanganElements = targetElement.querySelectorAll('span[id$="pasangan-value"]');
    Array.from(spanPasanganElements).map((element) => {
      element.innerText = "?";
    })
    targetElement.classList.remove('absolute');
    targetElement.classList.add('hidden');
  }
</script>
