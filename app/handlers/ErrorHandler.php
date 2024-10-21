<?php

require_once __DIR__ . "/../core/View.php";

class ErrorHandler {
    protected $view;

    public function __construct() {
        $this->view = new View(); // Inisialisasi View
    }

    public function handle404(): void {
        $data = [
            'title' => 'Error',
            'label' => 'Error: 404 - Not Found',
            'message' => 'The page you are looking for does not exist.'
        ];
        $this->render(view: 'error', data: $data); // Render tampilan 404
    }

    public function handle500(): void {
        $data = [
            'title' => 'Error',
            'label' => 'Error : 500 - Internal Server Error',
            'message' => 'An unexpected error occurred. Please try again later.'
        ];
        $this->render(view: 'error', data: $data); // Render tampilan 500
    }

    protected function render($view, $data = []): void {
        $this->view->setData(data: $data); // Mengatur data untuk tampilan
        $this->view->render(view: $view); // Merender tampilan
    }
}
