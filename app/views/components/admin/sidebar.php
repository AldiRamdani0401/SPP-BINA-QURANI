<div id="sidebar" class="py-2 d-none d-sm-block" style="background:#8FA06A;height:90%;overflow:auto;">
  <ul class="d-flex flex-column gap-1 m-0 p-0" style="list-style-type:none;">
    <li class="d-flex px-2 align-items-center" style="text-decoration:none;background:#7B8C56;height:70px;">
      <a href="/admin" class="d-flex align-items-center gap-2 px-2" style="text-decoration:none; width:100%;">
        <img src="<?= base_url(path: 'assets/icon/dashboard-icon.png')?>" height="20">
        <span style="font-size:20px;color:white;">Dashboard</span>
      </a>
    </li>
    <li style="background:#7B8C56;">
      <div id="master-data" class="d-flex justify-content-between align-items-center"
        style="text-decoration:none;cursor:pointer;" onclick="openSideBarDropdown(this.id)">
        <div class="d-flex align-items-center gap-2 px-3">
          <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
          <span style="font-size:20px;color:white;">Master Data</span>
        </div>
        <div class="d-flex justify-content-center align-items-center"
          style="background:#6A813A; width:41px; height:70px;">
          <img id="sidebar-dropdown-icon-master-data" src="<?= base_url(path: 'assets/icon/plus-math.png')?>" height="20">
        </div>
      </div>
    </li>
    <ul id="dropdown-master-data" class="d-none p-0" style="list-style-type:none;">
      <li class="sidebar-dropdown">
        <a href="/admin/data-siswa" class=" d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png')?>" height="20">
            <span style="font-size:20px;color:white;">Data Siswa</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Data Orang Tua Siswa</span>
          </div>
        </a>
      </li>
      <li id="data-kelas" class="sidebar-dropdown">
        <a class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Data Kelas</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Data Biaya SPP</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Data Pembayaran</span>
          </div>
        </a>
      </li>
    </ul>
    <li style="background:#7B8C56;">
      <div id="pembayaran-spp" class="d-flex justify-content-between align-items-center"
      style="text-decoration:none;cursor:pointer;" onclick="openSideBarDropdown(this.id)">
        <div class="d-flex align-items-center gap-2 px-3">
          <img src="<?= base_url(path: 'assets/icon/receive-cash.png') ?>" height="20">
          <span style="font-size:20px;color:white;">Pembayaran SPP</span>
        </div>
        <div class="d-flex justify-content-center align-items-center"
          style="background:#6A813A; width:41px; height:70px;">
          <img id="sidebar-dropdown-icon-pembayaran-spp" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>" height="20">
        </div>
      </div>
    </li>
    <ul id="dropdown-pembayaran-spp" class="d-none p-0" style="list-style-type:none;">
      <li class="sidebar-dropdown">
        <a class=" d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Konfirmasi Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Riwayat Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Tunggakan Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Pembayaran Bulanan</span>
          </div>
        </a>
      </li>
    </ul>
    <li style="background:#7B8C56;">
      <div id="pengaturan-spp" class="d-flex justify-content-between align-items-center"
      style="text-decoration:none;cursor:pointer;" onclick="openSideBarDropdown(this.id)">
        <div class="d-flex align-items-center gap-2 px-3">
          <img src="<?= base_url(path: 'assets/icon/icon-config-spp.png') ?>" height="20">
          <span style="font-size:20px;color:white;">Pengaturan SPP</span>
        </div>
        <div class="d-flex justify-content-center align-items-center"
          style="background:#6A813A; width:41px; height:70px;">
          <img id="sidebar-dropdown-icon-pengaturan-spp" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>" height="20">
        </div>
      </div>
    </li>
    <ul id="dropdown-pengaturan-spp" class="d-none p-0" style="list-style-type:none;">
      <li class="sidebar-dropdown">
        <a class=" d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Kelola Biaya SPP</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Kelola Potongan Biaya</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Kelola Jatuh Tempo SPP</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Riwayat Pembaruan Biaya</span>
          </div>
        </a>
      </li>
    </ul>
    <li style="background:#7B8C56;">
      <div id="manajemen-akun" class="d-flex justify-content-between align-items-center"
      style="text-decoration:none;cursor:pointer;" onclick="openSideBarDropdown(this.id)">
        <div class="d-flex align-items-center gap-2 px-3">
          <img src="<?= base_url(path: 'assets/icon/icon-manage-account.png') ?>" height="20">
          <span style="font-size:20px;color:white;">Manajemen Akun</span>
        </div>
        <div class="d-flex justify-content-center align-items-center"
          style="background:#6A813A; width:41px; height:70px;">
          <img id="sidebar-dropdown-icon-manajemen-akun" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>" height="20">
        </div>
      </div>
    </li>
    <ul id="dropdown-manajemen-akun" class="d-none p-0" style="list-style-type:none;">
      <li class="sidebar-dropdown">
        <a class=" d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Manajemen Akun Siswa</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Manajemen Akun Orang Tua Siswa</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Manajemen Akun Admin</span>
          </div>
        </a>
      </li>
    </ul>
    <li style="background:#7B8C56;">
      <div id="laporan-statistik" class="d-flex justify-content-between align-items-center"
      style="text-decoration:none;cursor:pointer;" onclick="openSideBarDropdown(this.id)">
        <div class="d-flex align-items-center gap-2 px-3">
          <img src="<?= base_url(path: 'assets/icon/icon-laporan-statistik.png') ?>" height="20">
          <span style="font-size:20px;color:white;">Laporan & Statistik</span>
        </div>
        <div class="d-flex justify-content-center align-items-center"
          style="background:#6A813A; width:41px; height:70px;">
          <img id="sidebar-dropdown-icon-laporan-statistik" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>" height="20">
        </div>
      </div>
    </li>
    <ul id="dropdown-laporan-statistik" class="d-none p-0" style="list-style-type:none;">
      <li class="sidebar-dropdown">
        <a class=" d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Statistik Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Laporan Per Kelas</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Cetak Laporan</span>
          </div>
        </a>
      </li>
    </ul>
    <li style="background:#7B8C56;">
      <div id="pengaturan-aplikasi" class="d-flex justify-content-between align-items-center"
      style="text-decoration:none;cursor:pointer;" onclick="openSideBarDropdown(this.id)">
        <div class="d-flex align-items-center gap-2 px-3">
          <img src="<?= base_url(path: 'assets/icon/icon-pengaturan.png') ?>" height="20">
          <span style="font-size:20px;color:white;">Pengaturan Aplikasi</span>
        </div>
        <div class="d-flex justify-content-center align-items-center"
          style="background:#6A813A; width:41px; height:70px;">
          <img id="sidebar-dropdown-icon-pengaturan-aplikasi" src="<?= base_url(path: 'assets/icon/plus-math.png') ?>" height="20">
        </div>
      </div>
    </li>
    <ul id="dropdown-pengaturan-aplikasi" class="d-none p-0" style="list-style-type:none;">
      <li class="sidebar-dropdown">
        <a class=" d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Metode Pembayaran</span>
          </div>
        </a>
      </li>
      <li class="sidebar-dropdown">
        <a id="master-data" class="d-flex justify-content-between align-items-center"
          style="text-decoration:none;cursor:pointer;">
          <div class="d-flex align-items-center gap-2 px-3">
            <img src="<?= base_url(path: 'assets/icon/database-icon.png') ?>" height="20">
            <span style="font-size:20px;color:white;">Pengaturan Aplikasi</span>
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
    const isHidden = dropdownElement.classList.contains('d-none');
    if (isHidden) {
      dropdownElement.classList.remove('d-none');
      btnOnClick.style.backgroundColor = '#46522e';
      btnOnClick.classList.add('fw-bold');
      dropdownIcon.setAttribute('src', '<?= base_url(path: './assets/icon/minus.png') ?>');
    } else {
      dropdownElement.classList.add('d-none');
      btnOnClick.style.backgroundColor = '';
      btnOnClick.classList.remove('fw-bold');
      dropdownIcon.setAttribute('src', '<?= base_url(path: 'assets/icon/plus-math.png') ?>');
    }
  }
</script>