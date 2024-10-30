<?php

require_once "View.php"; // Memuat kelas View
require_once "Model.php"; // Memastikan Model juga di-load

class Controller {
    protected $view;
    protected $model;

    public function __construct() {
        $this->view = new View(); // Inisialisasi View
        $this->model = new Model(); // Inisialisasi Model
    }

    protected function render($role, $view, $data = []): void {
        $this->view->setRole(role: $role);
        $this->view->setData(data: $data); // Mengatur data untuk tampilan
        $this->view->render(view: $view); // Merender tampilan
    }

    protected function redirect($url): never {
        header(header: "Location: $url"); // Mengalihkan ke URL baru
        exit;
    }
}
