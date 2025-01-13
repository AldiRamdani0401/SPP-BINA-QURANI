<?php

function Helper_Load_Images ($main_folder, $sub_folder, $file_name) {
  $fileJPGPath = BASE_PATH . "/assets/$main_folder/$sub_folder/$file_name.jpg";
    $fileJPEGPath = BASE_PATH . "/assets/$main_folder/$sub_folder/$file_name.jpeg";
    $filePNGPath = BASE_PATH . "/assets/$main_folder/$sub_folder/$file_name.png";

    // Periksa apakah file ada
    if (file_exists($fileJPGPath)) {
        // Pastikan file adalah gambar JPG
        $mimeType = mime_content_type($fileJPGPath);
        if ($mimeType !== 'image/jpeg') {
            throw new Exception("Invalid file type: $mimeType");
        }
        // Kirim header untuk gambar JPG
        header('Content-Type: image/jpeg');
        header('Content-Length: ' . filesize($fileJPGPath));
        // Buka file dan keluarkan kontennya
        readfile($fileJPGPath);
    }

    if (file_exists($filePNGPath)) {
        // Pastikan file adalah gambar JPG
        $mimeType = mime_content_type($filePNGPath);
        if ($mimeType !== 'image/png') {
            throw new Exception("Invalid file type: $mimeType");
        }

        // Kirim header untuk gambar JPG
        header('Content-Type: image/png');
        header('Content-Length: ' . filesize($filePNGPath));

        // Buka file dan keluarkan kontennya
        readfile($filePNGPath);
    }
}