<nav id="navbar-admin" class="flex flex-row justify-between p-0" style="background:#626F47;border:1px solid red;">
  <!-- Nav Brand -->
  <div id="nav-brand" class="flex flex-row">
    <a href="/admin" class="flex flex-row align-items-center h-full">
      <img src="<?php echo base_url(path: 'assets/images/logo.png'); ?>" height="50" alt="logo bina qur'ani karawang">
      <div id="logo-text">
        <h5 class="text-white mb-0">Portal Web SPP</h5>
        <p class="text-white mb-0" style="font-size:13px;">Bina Qur'ani Karawang</p>
      </div>
    </a>
  </div>
  <!-- Nav Notification & Circle Image -->
  <div class="d-flex gap-3">
    <!-- Nav Notification -->
    <div id="notification" class="p-1 my-auto" style="cursor:pointer;"
      onclick="openNavDropdown(this.id)">
      <img src="<?= base_url(path: 'assets/icon/icon-notification.png') ?>" height="30" style="border-radius:35px;">
      <!-- Dropdown Notification -->
      <div id="dropdown-notification" class="position-absolute d-none" style="top:68px;right:90px;">
        <div class="py-1" style="background:#D9D9D9;border-radius:0 0 10px 10px;width:200px;">
          <ul class="d-flex flex-column gap-1" style="list-style-type:none;padding:0;">
            <li class="px-2" style="background:#ACC675;width:100%;">Pembayaran 1</li>
            <li class="px-2" style="background:#ACC675;width:100%;">Pembayaran 2</li>
            <li class="px-2" style="background:#ACC675;width:100%;">Pembayaran 3</li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Nav Circle Image -->
    <div id="circle-image" class="nav-hover-rounded p-1 my-auto" style="cursor:pointer;"
      onclick="openNavDropdown(this.id)">
      <img src="<?= base_url(path: 'assets/images/team/hilda-amelia.jpg')?>" height="50" style="border-radius:30px;">
      <!-- Dropdown Circle Image -->
      <div id="dropdown-circle-image" class="position-absolute d-none" style="top:68px;right:20px;">
        <div class="py-1" style="background:#D9D9D9;border-radius:0 0 10px 10px;width:200px;">
          <ul class="d-flex flex-column gap-1" style="list-style-type:none;padding:0;">
            <li class="px-2" style="background:#ACC675;width:100%;">My Profile</li>
            <li class="px-2" style="background:#ACC675;width:100%;">Logout</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- <button type="button" class="flex md-none" onclick="showMenu()" id="dropdown-button"
    class="text-decoration-none rounded-2 d-md-none d-md-flex"
    style="width:50px;height:40px;background:transparent;border:1px solid white;margin:1px 0;">
    <hr style="height:3px; background-color:white; border: none; opacity:2; border-radius:5px; margin:5px;">
    <hr style="height:3px; background-color:white; border: none; opacity:2; border-radius:5px; margin:5px;">
    <hr style="height:3px; background-color:white; border: none; opacity:2; border-radius:5px; margin:5px;">
  </button> -->
  <div id="dropdown-menu" class="d-none d-sm-flex" style="width:100%;padding:0;"></div>
</nav>
<script>

  function showMenu() {
    const menuItems = Array.from(document.getElementsByClassName('nav-menu-item'));
    const dropdownButton = document.getElementById('dropdown-button');
    const containerDropdownMenu = document.getElementById('dropdown-menu');

    const isDropdownOpen = containerDropdownMenu.getAttribute('drop') === 'true';

    if (!isDropdownOpen) {
      containerDropdownMenu.innerHTML = '';

      // Tambahkan setiap item menu ke dalam kontainer dropdown
      menuItems.forEach(item => {
        const newItem = item.cloneNode(true);
        newItem.classList.add('dropdown-item');
        containerDropdownMenu.appendChild(newItem);
      });

      // Tambahkan navLogin ke dropdown
      const navLogin = document.createElement('a');
      navLogin.href = '/login';
      navLogin.textContent = 'Login';
      navLogin.classList.add('dropdown-item');
      navLogin.setAttribute('id', 'dropdown-item-login');
      containerDropdownMenu.appendChild(navLogin);

      containerDropdownMenu.setAttribute('drop', 'true');
      containerDropdownMenu.classList.remove('d-none');
      dropdownButton.setAttribute('style', 'width:50px;height:40px;background:#A3B83B;border:1px solid white;margin:1px 0;');
    } else {
      containerDropdownMenu.innerHTML = '';
      containerDropdownMenu.classList.add('d-none');
      containerDropdownMenu.setAttribute('drop', 'false');
      dropdownButton.setAttribute('style', 'width:50px;height:40px;background:transparent;border:1px solid white;margin:1px 0;');
    }
  }


  function handleMenuClick() {
    // Close Dropdown on Item Selection
    const containerDropdownMenu = document.getElementById('dropdown-menu');
    const dropdownButton = document.getElementById('dropdown-button');

    containerDropdownMenu.innerHTML = '';
    containerDropdownMenu.classList.add('d-none');
    containerDropdownMenu.setAttribute('drop', 'false');
    dropdownButton.setAttribute('style', 'width:50px;height:40px;background:transparent;border:1px solid white;margin:1px 0;');
  }

  let selectedNav = [];
  function openNavDropdown(param) {
    const btnOnClick = document.getElementById(param);
    const dropdownId = 'dropdown-' + param;
    const dropdownElement = document.getElementById(dropdownId);
    const isHidden = dropdownElement.classList.contains('d-none');

    // Menutup semua dropdown yang terbuka
    const allDropdowns = document.querySelectorAll('#navbar-admin [id^="dropdown-"]'); // Ambil semua elemen dengan id yang dimulai dengan 'dropdown-' hanya pada navbar-admin
    allDropdowns.forEach(dropdown => {
      if (!dropdown.classList.contains('d-none')) {
        dropdown.classList.add('d-none'); // Tutup dropdown yang terbuka
        const btnId = dropdown.id.replace('dropdown-', ''); // Mendapatkan ID tombol yang sesuai
        const btn = document.getElementById(btnId);
        if (btn) {
          btn.classList.remove('btn-nav-active'); // Hapus kelas aktif dari tombol yang sesuai
        }
      }
    });

    if (isHidden) {
      selectedNav = [param]; // Reset selectedNav agar hanya menyimpan param yang baru
      dropdownElement.classList.remove('d-none'); // Buka dropdown yang dipilih
      btnOnClick.classList.add('btn-nav-active'); // Tambahkan kelas aktif ke tombol yang dipilih
    }
  }

</script>

</script>