<?php
require __DIR__ . "/../core/Controller.php";

class UserController extends Controller {
    protected $role = 'user';
    public function index(): void {
        $data = [
            'title' => "Dashboard | User",
            'message' => "Welcome To User Page"
        ];
        $this->render(role: $this->role, view: 'dashboard', data: $data); // Merender tampilan user dengan data
    }

    public function show($id): void {
        $userModel = $this->model->load(modelName: 'User');
        $user = $userModel->getUser($id);
        $data = ["data" => $user];
        $this->render(role: $this->role, view: 'user', data: $data);
    }

    public function listUsers(): void {
        $userModel = $this->model->load(modelName: 'User'); // Memuat UserModel
        $users = $userModel->getAllUsers(); // Mengambil semua pengguna
        $this->render(role: $this->role, view: 'userList', data: ['users' => $users]); // Merender tampilan userList dengan data pengguna
    }
}
