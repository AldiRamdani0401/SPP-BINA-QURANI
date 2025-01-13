<?php
require __DIR__ . "/../core/Controller.php";

class PembayaranController extends Controller
{
  protected $role = 'admin';
  public function show($id = null): void
  {
    $data = [
      'title' => "Data Pembayaran | Admin",
    ];
    $this->render(role: $this->role, view: 'pembayaran/index', data: $data);
  }

  // public function getAllDataKelas(): void
  // {
  //   $kelasModel = $this->model->load(modelName: 'Kelas');
  //   header(header: 'Content-Type: application/json');
  //   $kelas = $kelasModel->getAllDataKelas();
  //   echo json_encode(value: [array_keys($kelas[0]), $kelas]);
  // }
}
