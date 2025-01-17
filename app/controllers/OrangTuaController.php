<?php
require __DIR__ . "/../core/Controller.php";

class OrangTuaController extends Controller
{
  protected $role = 'admin';

  public function show($id = null): void
  {
    $data = [
      'title' => "Data Orang Tua | Admin",
    ];
    $this->render(role: $this->role, view: 'orang-tua/index', data: $data);
  }

  public function getAllDataOrangTua(): void
  {
    $orangTuaModel = $this->model->load(modelName: 'OrangTua');
    header(header: 'Content-Type: application/json');
    $orangTua = $orangTuaModel->getAllDataOrangTua();
    echo json_encode(value: [array_keys($orangTua[0]), $orangTua]);
  }
}
