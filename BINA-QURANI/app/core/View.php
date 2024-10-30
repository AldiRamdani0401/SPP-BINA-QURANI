<?php

class View {
    // Menyimpan data yang akan digunakan dalam tampilan
    protected $data = [];
    protected $whoIs = null;

    // Metode untuk menetapkan data
    public function setData($data): void {
        // Pastikan data yang diberikan adalah array
        $this->data = is_array(value: $data) ? $data : [];
    }

    public function setRole($role): void {
        // Pastikan data yang diberikan adalah array
        $this->whoIs = $role;
    }

    // Metode untuk merender tampilan
    public function render($view): void {
        // Mengubah data menjadi variabel lokal
        extract(array: $this->data);

        $page = null;
        $file = null;

        switch($this->whoIs) {
            case 'user':
                echo "whoIs : $this->whoIs";
                $page = 'user';
                $file = $view;
                break;
            case 'admin':
                $page = 'admin';
                $file = $view;
                break;
            default:
                $page = null;
                $file = $view;
                break;
        }

        if ($page !== null) {
            include __DIR__ . "/../views/components/{$page}/header.php";
            $render = __DIR__ . "/../views/pages/{$page}/{$file}.php";
            include $render;
            include __DIR__ . "/../views/components/{$page}/footer.php";
            return;
        } else {
            include __DIR__ . "/../views/components/general/header.php";
            include __DIR__ . "/../views/pages/{$file}.php";
            include __DIR__ . "/../views/components/general/footer.php";
            return;
        }

        // switch ($view) {
        //     case 'user':
        //         include __DIR__ . "/../views/pages/{$view}.php";
        //         break;
        //     default:
        //         include __DIR__ . "/../views/components/general/header.php";
        //         include __DIR__ . "/../views/{$view}.php";
        //         include __DIR__ . "/../views/components/general/footer.php";
        //         break;
        // }

        // Memasukkan file tampilan
        // include __DIR__ . "/../views/{$view}.php";
    }
}
