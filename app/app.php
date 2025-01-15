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

  private function initializeRoutes()
  {
    //== Auth ==
    $this->routes->post("/login", "AuthController@login", $middleware = false);

    // Definisikan rute GET
    // == GENERAL ==
    $this->routes->get("/", "GeneralController@index", $middleware = false);

    // == ADMIN ==
    $this->routes->get("/admin", "AdminController@index", $middleware = true);
    $this->routes->get("/admin/master-data/siswa", "MasterDataController@siswa", $middleware = true);
    $this->routes->post("/master-data/siswa/create", "MasterDataController@createDataSiswa", $middleware = true);
    $this->routes->post("/master-data/siswa/{siswa_id}/update", "MasterDataController@updateDataSiswa", $middleware = true);
    $this->routes->get("/admin/master-data/orang-tua-siswa", "MasterDataController@orangTuaSiswa", $middleware = true);

    // == FILES ==
    $this->routes->get("/{main_folder}/{sub_folder}/{nested_folder}/{file_name}", "FileController@load", $middleware = false);



    // $this->routes->get("/about", "AboutController@index");

    // // Definisikan rute POST
    // $this->routes->post("/contact", "ContactController@submit");

    // Tangkap URL dan metode HTTP
    $url = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    // Resolve rute
    $this->routes->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
  }
}
