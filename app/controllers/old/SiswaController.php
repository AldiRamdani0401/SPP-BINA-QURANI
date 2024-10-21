<?php
require __DIR__ . "/../core/Controller.php";

class SiswaController extends Controller {
    protected $role = 'admin';
    public function show($id = null): void {
        $userModel = $this->model->load(modelName: 'Siswa');
        if ($id != null) {
          $siswa = $userModel->getDataSiswaById($id);
        } else {
          $siswa = $userModel->getAllDataSiswa();
        }

        $data = [
          'title' => "Data Siswa | Admin",
          "data" => $siswa
        ];
        $this->render(role: $this->role, view: 'siswa/index', data: $data);
    }
}
