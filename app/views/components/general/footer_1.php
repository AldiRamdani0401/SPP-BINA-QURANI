        </div>
        <footer class="px-5 pt-3 pb-2" style="background:<?= $title != "Login" ? '#626F47' : '#33372C'?>;">
          <?php if ($title == "Home") : ?>
          <div class="d-flex flex-sm-column flex-md-row justify-content-md-between align-items-center my-auto">
            <div id="footer-brand" class="col-8 d-flex align-items-center justify-content-start my-auto">
              <div class="text-decoration-none d-flex align-items-center">
                <img src="./assets/images/logo.png" height="120" alt="logo bina qur'ani karawang" class="me-2"
                  style="width: 150px;"> <!-- Atur lebar gambar di sini -->
                <div id="logo-text">
                  <h5 class="text-white mb-0">Portal Web SPP</h5>
                  <p class="text-white mb-0" style="font-size:13px;">Bina Qur'ani Karawang</p>
                </div>
              </div>
            </div>
            <div class="col d-flex flex-column align-items-center my-auto">
              <div class="row">
                <div class="col text-center">
                  <a href="#" class="footer-menu text-decoration-none d-block">Home</a>
                  <a href="#about" class="footer-menu text-decoration-none d-block">About</a>
                  <a href="#" class="footer-menu text-decoration-none d-block">Home</a>
                </div>
                <div class="col text-center">
                  <a href="#" class="footer-menu text-decoration-none d-block">Home</a>
                  <a href="#about" class="footer-menu text-decoration-none d-block">About</a>
                  <a href="#about" class="footer-menu text-decoration-none d-block">About</a>
                </div>
              </div>
            </div>
          </div>
          <div id="social-media" class="d-flex justify-content-center align-items-center my-3">
            <a href="#" class="text-decoration-none me-3 text-white">Home</a>
            <a href="#about" class="text-decoration-none me-3 text-white">About</a>
            <a href="#about" class="text-decoration-none text-white">Contact</a>
          </div>

          <hr class="m-2" style="height: 2px; background-color: white; border: none;">
          <?php endif; ?>
          <div class="text-center text-white">
            <p style="font-size:13px;">Copyright &#169; Bina Qur'ani Karawang | 2024</p>
          </div>
        </footer>
      </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
<!-- <script>
  // Cek apakah ada perubahan file setiap 2 detik
  setInterval(function() {
    location.reload();
  }, 5000);
</script> -->