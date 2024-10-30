<nav style="background:<?= $title != "Login" ? '#626F47' : '#33372C' ?>; width:100%;">
  <div class="px-3" style="height:100%;">
    <div class="d-flex flex-md-row justify-content-between align-items-center gap-5" style="height:100%;">
      <?php if ($title != "Login" && $title != "Error"): ?>
        <div id="nav-brand" class="d-flex align-items-center justify-content-center w-sm-auto">
          <a href="/" class="text-decoration-none d-flex align-items-center">
            <img src="./assets/images/logo.png" height="40" alt="logo bina qur'ani karawang" class="me-2">
            <div id="logo-text">
              <h5 class="text-white mb-0">Portal Web SPP</h5>
              <p class="text-white mb-0" style="font-size:13px;">Bina Qur'ani Karawang</p>
            </div>
          </a>
        </div>
      <?php endif; ?>

      <div id="nav-menu"
        class="d-flex flex-sm-column flex-md-row align-items-center justify-content-center gap-2 d-none d-sm-flex">
        <?php if ($title != "Login" && $title != "Error"): ?>
          <a href="#" class="nav-menu-item nav-hover text-decoration-none" onclick="handleMenuClick()">Beranda</a>
          <a href="#about" class="nav-menu-item nav-hover text-decoration-none" onclick="handleMenuClick()">Tentang</a>
          <a href="#service" class="nav-menu-item nav-hover text-decoration-none" onclick="handleMenuClick()">Layanan</a>
          <a href="#contact" class="nav-menu-item nav-hover text-decoration-none" onclick="handleMenuClick()">Contact</a>
          <a href="#team" class="nav-menu-item nav-hover text-decoration-none" onclick="handleMenuClick()">Team</a>
        <?php endif; ?>
      </div>


      <?php if ($title != "Login" && $title != "Error"): ?>
        <a href="/login" id="nav-login" class="nav-hover text-decoration-none d-none d-sm-flex">Login</a>
        <button type="button" onclick="showMenu()" id="dropdown-button"
          class="text-decoration-none rounded-2 d-md-none d-md-flex"
          style="width:50px;height:40px;background:transparent;border:1px solid white;margin:1px 0;">
          <hr style="height:3px; background-color:white; border: none; opacity:2; border-radius:5px; margin:5px;">
          <hr style="height:3px; background-color:white; border: none; opacity:2; border-radius:5px; margin:5px;">
          <hr style="height:3px; background-color:white; border: none; opacity:2; border-radius:5px; margin:5px;">
        </button>
      <?php else: ?>
        <a href="/" class="nav-hover text-decoration-none ms-auto">Back to Home</a>
      <?php endif; ?>
    </div>
  </div>
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

</script>