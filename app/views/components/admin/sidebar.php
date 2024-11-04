<div id="sidebar" class="py-2 max-h-[90%] bg-[#8FA06A] overflow-auto">
  <ul class="flex flex-col gap-1 m-0 p-0 list-none">
    <!-- Dashboard -->
    <li class="flex justify-center items-center py-3 bg-[#7B8C56] hover:bg-[#46522e] hover:font-bold cursor-pointer">
      <a href="/admin" class="flex items-center gap-2 px-2 w-full">
        <img src="<?= base_url(path: 'assets/icon/dashboard-icon.png')?>" class="p-1">
        <span class="text-lg text-white">Dashboard</span>
      </a>
    </li>
    <!-- Master Data -->
    <li class="w-full bg-[#7B8C56] hover:font-bold hover:bg-[#46522e] cursor-pointer">
      <div id="master-data" class="flex justify-between" onclick="openSideBarDropdown(this.id)">
        <div class="flex justify-center items-center gap-2 p-3">
          <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
          <span class="text-lg text-white">Master Data</span>
        </div>
        <div class="p-3 flex justify-center"
          style="background:#6A813A;">
          <img id="sidebar-dropdown-icon-master-data" src="<?= base_url(path: 'assets/icon/plus-math.png')?>">
        </div>
      </div>
    </li>
    <ul id="dropdown-master-data" class="hidden p-0 pl-3 list-none">
      <li class="sidebar-dropdown">
        <a href="/admin/data-siswa" class="flex items-center cursor-pointer">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png')?>">
            <span class="text-sm text-white">Data Siswa</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" href="/admin/data-orang-tua-siswa" class="flex items-center">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Data Orang Tua Siswa</span>
          </div>
        </a>
      </li>
      <li id="data-kelas" class="sidebar-dropdown">
        <a class="flex items-center">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Data Kelas</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Data Biaya SPP</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center cursor-pointer">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Data Pembayaran</span>
          </div>
        </a>
      </li>
    </ul>
    <!-- Pembayaran SPP -->
    <li class="bg-[#7B8C56] hover:font-bold hover:bg-[#46522e] cursor-pointer">
      <div id="pembayaran-spp" class="flex justify-between" onclick="openSideBarDropdown(this.id)">
        <div class="flex justify-center items-center gap-2 p-3">
          <img src="<?= base_url(path: 'assets/icon/receive-cash.png') ?>">
          <span class="text-lg text-white">Pembayaran SPP</span>
        </div>
        <div class="p-3 flex justify-center bg-[#6A813A]">
          <img id="sidebar-dropdown-icon-pembayaran-spp" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>">
        </div>
      </div>
    </li>
    <ul id="dropdown-pembayaran-spp" class="hidden p-0 pl-3 list-none">
      <li class="sidebar-dropdown">
        <a class="flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Konfirmasi Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Riwayat Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Tunggakan Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Pembayaran Bulanan</span>
          </div>
        </a>
      </li>
    </ul>
    <!-- Pengaturan SPP -->
    <li class="bg-[#7B8C56] hover:font-bold hover:bg-[#46522e] cursor-pointer">
      <div id="pengaturan-spp" class="flex justify-between" onclick="openSideBarDropdown(this.id)">
        <div class="flex justify-between items-center gap-2 p-3">
          <img src="<?= base_url(path: 'assets/icon/icon-config-spp.png') ?>">
          <span class="text-lg text-white">Pengaturan SPP</span>
        </div>
        <div class="p-3 flex justify-center bg-[#6A813A]">
          <img id="sidebar-dropdown-icon-pengaturan-spp" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>">
        </div>
      </div>
    </li>
    <ul id="dropdown-pengaturan-spp" class="hidden p-0 pl-3 list-none">
      <li class="sidebar-dropdown">
        <a class=" flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Kelola Biaya SPP</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Kelola Potongan Biaya</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center cursor-pointer"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Kelola Jatuh Tempo SPP</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Riwayat Pembaruan Biaya</span>
          </div>
        </a>
      </li>
    </ul>
    <!-- Manajemen Akun -->
    <li class="bg-[#7B8C56] hover:font-bold hover:bg-[#46522e] cursor-pointer">
      <div id="manajemen-akun" class="flex justify-between" onclick="openSideBarDropdown(this.id)">
        <div class="flex justify-between items-center gap-2 p-3">
          <img src="<?= base_url(path: 'assets/icon/icon-manage-account.png') ?>">
          <span class="text-lg text-white">Manajemen Akun</span>
        </div>
        <div class="p-3 flex justify-center bg-[#6A813A]">
          <img id="sidebar-dropdown-icon-manajemen-akun" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>">
        </div>
      </div>
    </li>
    <ul id="dropdown-manajemen-akun" class="hidden p-0 pl-3 list-none">
      <li class="sidebar-dropdown">
        <a class=" flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Manajemen Akun Siswa</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Manajemen Akun Orang Tua Siswa</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Manajemen Akun Admin</span>
          </div>
        </a>
      </li>
    </ul>
    <!-- Laporan & Statistik -->
    <li class="bg-[#7B8C56] hover:font-bold hover:bg-[#46522e] cursor-pointer">
      <div id="laporan-statistik" class="flex justify-between" onclick="openSideBarDropdown(this.id)">
        <div class="flex justify-between items-center gap-2 p-3">
          <img src="<?= base_url(path: 'assets/icon/icon-laporan-statistik.png') ?>">
          <span class="text-lg text-white">Laporan & Statistik</span>
        </div>
        <div class="p-3 flex justify-center bg-[#6A813A]">
          <img id="sidebar-dropdown-icon-laporan-statistik" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>">
        </div>
      </div>
    </li>
    <ul id="dropdown-laporan-statistik" class="hidden p-0 list-none">
      <li class="sidebar-dropdown">
        <a class=" flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Statistik Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Laporan Per Kelas</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Cetak Laporan</span>
          </div>
        </a>
      </li>
    </ul>
    <!-- Pengaturan Aplikasi -->
    <li class="bg-[#7B8C56] hover:font-bold hover:bg-[#46522e] cursor-pointer">
      <div id="pengaturan-aplikasi" class="flex justify-between" onclick="openSideBarDropdown(this.id)">
        <div class="flex justify-between items-center gap-2 p-3">
          <img src="<?= base_url(path: 'assets/icon/icon-pengaturan.png') ?>">
          <span class="text-lg text-white">Pengaturan Aplikasi</span>
        </div>
        <div class="p-3 flex justify-center bg-[#6A813A]">
          <img id="sidebar-dropdown-icon-pengaturan-aplikasi" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>">
        </div>
      </div>
    </li>
    <ul id="dropdown-pengaturan-aplikasi" class="hidden p-0 list-none">
      <li class="sidebar-dropdown">
        <a class=" flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Metode Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="flex items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="flex justify-between items-center gap-2 p-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>">
            <span class="text-sm text-white">Pengaturan Aplikasi</span>
          </div>
        </a>
      </li>
    </ul>
  </ul>
</div>


<script>
  function openSideBarDropdown(param) {
    const btnOnClick = document.getElementById(param);
    const dropdownId = 'dropdown-' + param;
    const dropdownIcon = document.getElementById('sidebar-dropdown-icon-' + param);
    const dropdownElement = document.getElementById(dropdownId);
    const isHidden = dropdownElement.classList.contains('hidden');
    if (isHidden) {
      dropdownElement.classList.remove('hidden');
      btnOnClick.style.backgroundColor = '#46522e';
      btnOnClick.classList.add('font-bold');
      dropdownIcon.setAttribute('src', '<?= base_url(path: './assets/icon/minus.png') ?>');
    } else {
      dropdownElement.classList.add('hidden');
      btnOnClick.style.backgroundColor = '';
      btnOnClick.classList.remove('font-bold');
      dropdownIcon.setAttribute('src', '<?= base_url(path: 'assets/icon/plus-math.png') ?>');
    }
  }
</script>