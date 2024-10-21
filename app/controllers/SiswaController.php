<?php
require __DIR__ . "/../core/Controller.php";

class SiswaController extends Controller
{
  protected $role = 'admin';
  public function show($id = null): void
  {
    $data = [
      'title' => "Data Siswa | Admin",
    ];
    $this->render(role: $this->role, view: 'siswa/index', data: $data);
  }

  public function getAllDataSiswa(): void
  {
    $siswaModel = $this->model->load(modelName: 'Siswa');
    header(header: 'Content-Type: application/json');
    $siswa = $siswaModel->getAllDataSiswa();
    echo json_encode(value: [array_keys($siswa[0]), $siswa]);
  }
}
