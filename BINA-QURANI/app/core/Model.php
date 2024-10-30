<?php

require_once 'Database.php';

class Model {
    protected $db;

    public function __construct() {
        $database = new Database(); // Membuat instansi Database
        $this->db = $database->getConnection(); // Mendapatkan koneksi database
    }

    // Metode untuk memuat model
    public function load($modelName): object {
        $modelClass = ucfirst(string: $modelName) . 'Model'; // Mengonversi nama model ke kelas
        $modelPath = __DIR__ . "/../models/$modelClass.php"; // Menentukan jalur model

        if (file_exists(filename: $modelPath)) {
            require $modelPath; // Memuat file model
            if (class_exists(class: $modelClass)) {
                return new $modelClass(); // Mengembalikan instance model
            } else {
                throw new Exception(message: "Class $modelClass not found");
            }
        } else {
            throw new Exception(message: "Model file $modelPath not found");
        }
    }

    // Metode umum untuk mengeksekusi query
    protected function query($sql, $params = []): bool|mysqli_stmt {
        $stmt = $this->db->prepare(query: $sql); // Menyiapkan statement
        $stmt->execute(params: $params); // Mengeksekusi statement dengan parameter
        return $stmt;
    }
}
