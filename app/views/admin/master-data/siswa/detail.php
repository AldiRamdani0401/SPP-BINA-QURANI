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
    <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Detail Data Siswa</h1>
    <hr class="bg-lime-400 py-[1.8px] rounded-full">
  </div>
  <!-- Container Detail Data Siswa -->
  <div id="container-data-siswa"
    class="flex flex-col gap-5 justify-between">
    <div class="flex flex-row gap-3">
      <!-- Sub-Container 1 : Slide Data -->
       <div class="flex flex-col w-full gap-5 max-h-[300px] px-2 py-6 overflow-auto thin-scrollbar">
         <!-- Slide 1 : Data Diri Siswa -->
         <div class="group flex flex-col gap-2 w-full py-2 px-3 rounded-md shadow-lg text-nowrap border">
           <!-- Title Card -->
           <div class="">
             <div class="text-lg font-bold">Data Diri Siswa</div>
             <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
           </div>
           <!-- Nama Lengkap -->
           <div id="nama-lengkap" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nama Lengkap</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nama-lengkap-value" class="w-full px-2">Aldi Ramdani</span>
           </div>
           <!-- Nomor Induk Siswa -->
           <div id="nomor-induk-siswa" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">NISN</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nomor-induk-siswa-value" class="w-full px-2">11223344</span>
           </div>
           <!-- Tempat Lahir -->
           <div id="tempat-lahir" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tempat Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tempat-lahir-value" class="w-full px-2">Karawang</span>
           </div>
           <!-- Tanggal Lahir -->
           <div id="tanggal-lahir" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Tanggal Lahir</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="tanggal-lahir-value" class="w-full px-2">4 Januari 1998</span>
           </div>
           <!-- Jenis Kelamin -->
           <div id="jenis-kelamin" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Jenis Kelamin</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="jenis-kelamin-value" class="w-full px-2">Laki-Laki</span>
           </div>
           <!-- Kelas -->
           <div id="kelas" class="flex flex-row justify-between text-slate-700 text-[16px]">
              <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kelas</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="kelas-value" class="w-full px-2">1A</span>
           </div>
         </div>
         <!-- Slide 2 : Data Orang Tua -->
         <div class="group flex flex-col gap-2 w-full py-2 px-3 rounded-md shadow-lg text-nowrap border">
           <!-- Title Card -->
           <div class="">
             <div class="text-lg font-bold">Data Orang Tua</div>
             <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-blue-500 group-focus-within:bg-blue-500">
           </div>
          <!-- Data Ayah -->
          <div class="relative mt-2">
            <h1 class="absolute bg-white text-slate-700 top-[-10px] left-8 px-1 text-sm font-bold">Data Ayah</h1>
            <hr class="py-[1px] bg-slate-400 rounded-full">
          </div>
           <!-- NIK Ayah -->
           <div id="nik-ayah" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">NIK</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nik-ayah-value" class="w-full px-2">1122334455</span>
           </div>
           <!-- Nama Lengkap Ayah -->
           <div id="nama-lengkap-ayah" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nama Lengkap Ayah</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nama-lengkap-ayah-value" class="w-full px-2">Aldi</span>
           </div>
            <!-- Nomor Telepon Ayah -->
            <div id="nomor-telepon-ayah" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nomor Telepon Ayah</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nomor-telepon-ayah-value" class="w-full px-2">0858112233</span>
           </div>
           <!-- Email Ayah -->
           <div id="email-ayah" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Email Ayah</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="email-ayah-value" class="w-full px-2">aldi@gmail.com</span>
           </div>
           <!-- Data Ibu -->
           <div class="relative mt-2">
            <h1 class="absolute bg-white text-slate-700 top-[-10px] left-8 px-1 text-sm font-bold">Data Ibu</h1>
            <hr class="py-[1px] bg-slate-400 rounded-full">
           </div>
           <!-- NIK Ibu -->
           <div id="nik-ibu" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">NIK</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nik-ibu-value" class="w-full px-2">11223344</span>
           </div>
           <!-- Nama Lengkap Ibu -->
           <div id="nama-lengkap-ibu" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nama Lengkap Ibu</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nama-lengkap-ibu-value" class="w-full px-2">Hilda</span>
           </div>
           <!-- Nomor Telepon Ibu -->
           <div id="nomor-telepon-ibu" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Nomor Telepon Ibu</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="nomor-telepon-ibu-value" class="w-full px-2">0858112233</span>
           </div>
           <!-- Email Ibu -->
           <div id="email-ibu" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Email Ibu</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="email-ibu-value" class="w-full px-2">Hilda@gmail.com</span>
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
               <span id="provinsi-value" class="w-full px-2">0858112233</span>
           </div>
           <!-- Kabupaten -->
           <div id="kabupaten" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kabupaten</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="kabupaten-value" class="w-full px-2">0858112233</span>
           </div>
            <!-- Kecamatan -->
            <div id="kecamatan" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kecamatan</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="kecamatan-value" class="w-full px-2">0858112233</span>
           </div>
            <!-- Desa -->
            <div id="desa" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Desa / Kelurahan</span>
                 <span class="font-medium">:</span>
               </div>
               <span id="desa-value" class="w-full px-2">0858112233</span>
           </div>
            <!-- RT / RW -->
            <div id="rt-rw" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">RT / RW</span>
                 <span class="font-medium">:</span>
               </div>
               <div class="flex flex-row w-full">
                <span id="rt-value" class="px-1">001</span>
                /
                <span id="rw-value" class="px-1">002</span>
               </div>
           </div>
            <!-- Kode Post -->
            <div id="kode-post" class="flex flex-row justify-between text-slate-700 text-[16px]">
               <div class="flex flex-row gap-1 w-[60%] justify-between">
                 <span class="font-medium">Kode Post</span>
                 <span class="font-medium">:</span>
               </div>
              <span id="kode-post-value" class="w-full px-1">112233</span>
           </div>
         </div>
       </div>
      <!-- Sub-Container 2 : Photo Profile -->
      <div class="group flex flex-col w-80 h-fit gap-2 border pt-2 pb-3 px-3 rounded-md shadow-lg">
        <!-- Title Card -->
        <div class="">
          <div class="text-lg font-bold">Photo Profile Siswa</div>
          <hr class="py-[1.5px] bg-slate-400 rounded-full group-hover:bg-yellow-300 group-focus-within:bg-blue-500">
        </div>
        <!-- Photo Profile Siswa -->
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
        <button type="button"
          class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md" onclick="loadModalEdit()">Edit</button>
        <button
          class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
</script>
