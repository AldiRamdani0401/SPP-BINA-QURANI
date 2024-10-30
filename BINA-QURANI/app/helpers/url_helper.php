<?php
function base_url($path = ''): string {
    // Mendapatkan protokol HTTP atau HTTPS
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Mendapatkan nama host (domain)
    $host = $_SERVER['HTTP_HOST'];

    // Mendapatkan direktori dari skrip utama
    $directory = dirname(path: $_SERVER['SCRIPT_NAME']);

    // Menggabungkan semuanya dan menambahkan path jika ada
    return $protocol . $host . rtrim(string: $directory, characters: '/') . '/' . ltrim(string: $path, characters: '/');
}
