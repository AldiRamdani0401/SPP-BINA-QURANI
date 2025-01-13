<?php

function Helper_Load_Files($main_folder, $sub_folder, $nested_folder, $file_name) {
    // Pastikan BASE_PATH memiliki DIRECTORY_SEPARATOR di akhir
    $basePath = rtrim(BASE_PATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    // Tetapkan path file JS dan CSS
    $fileJSPath = $basePath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $main_folder . DIRECTORY_SEPARATOR . $sub_folder . DIRECTORY_SEPARATOR . $nested_folder . DIRECTORY_SEPARATOR . $file_name . ".js";
    $fileCSSPath = $basePath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $main_folder . DIRECTORY_SEPARATOR . $sub_folder . DIRECTORY_SEPARATOR . $nested_folder . DIRECTORY_SEPARATOR . $file_name . ".css";

    // Debugging opsional (aktifkan jika diperlukan)
    // echo "<pre>";
    // echo "Checked JS Path: $fileJSPath\n";
    // echo "Checked CSS Path: $fileCSSPath\n";
    // echo "</pre>";

    // Jika file tidak ditemukan, lemparkan Exception
    if (!file_exists($fileJSPath)) {
        throw new Exception(
            "File not found: $file_name (Checked paths: " .
            $fileJSPath . ", " . $fileCSSPath . ")"
        );
    }

    // Kirimkan konten file jika ditemukan
    if (file_exists($fileJSPath)) {
        header('Content-Type: application/javascript');
        readfile($fileJSPath);
        exit;
    }

    // if (file_exists($fileCSSPath)) {
    //     header('Content-Type: text/css');
    //     readfile($fileCSSPath);
    //     exit;
    // }
}
