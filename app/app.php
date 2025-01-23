<?php

require_once 'Routes.php';

class App
{
  private $routes;

  public function __construct()
  {
    $this->routes = new Routes();
    $this->initializeRoutes();
  }

  /** INITIAL ROUTES
   *
  **/
  private function initializeRoutes()
  {
    /* ======= AUTH =========== */
      $this->routes->post("/login", "AuthController@login", $middleware = false);
    /* ======= End of AUTH ===== */

    /* ======= GENERAL =========== */
      $this->routes->get("/", "GeneralController@index", $middleware = false);
    /* ======= End of GENERAL ===== */

    /* ======= ADMIN =========== */
    /* @@@ DASHBOARD @@@ */
      $this->routes->get("/admin", "AdminController@index", $middleware = true);
    /* @@@ MASTER DATA @@@ */
        /* ### SISWA ### */
          $this->routes->get("/admin/master-data/siswa", "MasterDataController@siswa", $middleware = true);
          $this->routes->post("/master-data/siswa/create", "MasterDataController@createDataSiswa", $middleware = true);
          $this->routes->post("/master-data/siswa/{siswa_id}/update", "MasterDataController@updateDataSiswa", $middleware = true);
        /* ### End of SISWA ### */
        /* ### ORANG TUA SISWA ### */
          $this->routes->get("/admin/master-data/orang-tua-siswa", "MasterDataController@orangTuaSiswa", $middleware = true);
          $this->routes->post("/master-data/orang-tua/create", "MasterDataController@createDataOrangTuaSiswa", $middleware = true);
        /* ### End of ORANG TUA SISWA ### */
        /* >>> kelas <<< */
        $this->routes->get("/admin/master-data/kelas", "MasterDataController@kelas", $middleware = true);
        /* >>> biaya spp <<< */
        $this->routes->get("/admin/master-data/biaya-spp", "MasterDataController@spp", $middleware = true);
        /* >>> pembayaran <<< */
        $this->routes->get("/admin/master-data/pembayaran", "MasterDataController@pembayaran", $middleware = true);
        /* >>> admin <<< */
        $this->routes->get("/admin/master-data/admin", "MasterDataController@admin", $middleware = true);
    /* @@@ End of MASTER DATA @@@ */

    /* @@@ PEMBAYARAN SPP @@@ */
        /* >>> verifikasi <<< */
        $this->routes->get("/admin/pembayaran-spp/verifikasi", "PembayaranSppController@verifikasi", $middleware = true);
        /* >>> tunggakan <<< */
        $this->routes->get("/admin/pembayaran-spp/tunggakan", "PembayaranSppController@tunggakan", $middleware = true);
    /* @@@ End of PEMBAYARAN SPP @@@ */

    /* @@@ PENGATURAN SPP @@@ */
        /* >>> biaya spp <<< */
        $this->routes->get("/admin/pengaturan-spp/biaya-spp", "PengaturanSppController@biayaSpp", $middleware = true);
        /* >>> kategori spp <<< */
        $this->routes->get("/admin/pengaturan-spp/kategori-spp", "PengaturanSppController@kategoriSpp", $middleware = true);
        /* >>> status spp <<< */
        $this->routes->get("/admin/pengaturan-spp/status-spp", "PengaturanSppController@statusSpp", $middleware = true);
    /* @@@ End of PENGATURAN SPP @@@ */

    /* @@@ MANAJEMEN AKUN @@@ */
        /* >>> pengguna <<< */
        $this->routes->get("/admin/pengaturan-spp/biaya-spp", "PengaturanSppController@biayaSpp", $middleware = true);
        /* >>> profile <<< */
    /* @@@ End of MANAJEMEN AKUN @@@ */

    /* @@@ LAPORAN & STATISTIK @@@ */
        /* >>> pembayaran <<< */
        $this->routes->get("/admin/pengaturan-spp/biaya-spp", "PengaturanSppController@biayaSpp", $middleware = true);
        /* >>> tunggakan <<< */
    /* @@@ End of LAPORAN & STATISTIK @@@ */

    /* @@@ PENGATURAN APLIKASI @@@ */
        /* >>> notifikasi <<< */
        $this->routes->get("/admin/pengaturan-spp/biaya-spp", "PengaturanSppController@biayaSpp", $middleware = true);
    /* @@@ End of PENGATURAN APLIKASI @@@ */
    /* ======= End of ADMIN ==== */

    /* ======= SYSTEM =========== */
    /* @@@ STORAGES @@@ */
      /* >>> FILES <<< */
      $this->routes->get("/{main_folder}/{sub_folder}/{nested_folder}/{file_name}", "FileController@load", $middleware = false);
      /* >>> FILES <<< */
    /* @@@ End of STORAGES @@@ */
    /* ======= End of SYSTEM ==== */

    /** Get URL & HTTP Method **/
    $url = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    /** Resolve Route **/
    $this->routes->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
  }
}
