<?php

function Helper_Load_Files($main_folder, $sub_folder, $nested_folder, $file_name) {
    // Pastikan BASE_PATH memiliki DIRECTORY_SEPARATOR di akhir
    $basePath = rtrim(BASE_PATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    // Tetapkan path file JS dan CSS
    $fileJSPath = $basePath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $main_folder . DIRECTORY_SEPARATOR . $sub_folder . DIRECTORY_SEPARATOR . $nested_folder . DIRECTORY_SEPARATOR . $file_name . ".js";
    $fileCSSPath = $basePath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $main_folder . DIRECTORY_SEPARATOR . $sub_folder . DIRECTORY_SEPARATOR . $nested_folder . DIRECTORY_SEPARATOR . $file_name . ".css";

    // SpreedSheet Path
    $fileXlsxPath = BASE_PATH . "/assets/$main_folder/$sub_folder/$file_name.xlsx";

    // Debugging opsional (aktifkan jika diperlukan)
    // echo "<pre>";
    // echo "Checked JS Path: $fileJSPath\n";
    // echo "Checked CSS Path: $fileCSSPath\n";
    // echo "</pre>";

    // Jika file tidak ditemukan, lemparkan Exception

    // Kirimkan konten file jika ditemukan
    if (file_exists($fileJSPath)) {
        header('Content-Type: application/javascript');
        readfile($fileJSPath);
        exit;
    }

    if (file_exists($fileXlsxPath)) {
        // Header for file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . basename($fileXlsxPath) . '"');
        header('Content-Length: ' . filesize($fileXlsxPath));
        header('Pragma: public');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        // Read and output the file
        readfile($fileXlsxPath);
        exit;
    } else {
        // File not found, return 404 or appropriate error message
        http_response_code(404);
        echo "File not found.";
        exit;
    }

    // if (file_exists($fileCSSPath)) {
    //     header('Content-Type: text/css');
    //     readfile($fileCSSPath);
    //     exit;
    // }
}
