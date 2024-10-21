<?php
require __DIR__ . "/../core/Controller.php";

class AdminController extends Controller {
    protected $role = 'admin';
    public function index(): void {
        $data = [
            'title' => "Dashboard | Admin",
        ];
        $this->render(role: $this->role, view: 'dashboard', data: $data); // Merender tampilan user dengan data
    }

    // public function show($id): void {
    //     $userModel = $this->model->load(modelName: 'User');
    //     $user = $userModel->getUser($id);
    //     $data = ["data" => $user];
    //     $this->render(role: $this->role, view: 'user', data: $data);
    // }

    // Data Siswa
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
        $this->render(role: $this->role, view: 'index', data: $data);
    }

    public function listUsers(): void {
        $userModel = $this->model->load(modelName: 'User'); // Memuat UserModel
        $users = $userModel->getAllUsers(); // Mengambil semua pengguna
        $this->render(role: $this->role, view: 'userList', data: ['users' => $users]); // Merender tampilan userList dengan data pengguna
    }
}
