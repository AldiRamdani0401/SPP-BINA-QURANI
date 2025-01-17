<?php
function Helper_Images($targetFolder, $imageFile) {
  // Membuat nama file baru
  $newName = $targetFolder . "_" . basename($imageFile['name']);
  $target_dir = BASE_PATH . "/assets/images/$targetFolder/";

  // Pastikan folder target ada, jika tidak maka buat
  if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
  }

  $target_file = $target_dir . $newName;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Cek apakah file benar-benar gambar
  $check = getimagesize($imageFile["tmp_name"]);
  if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
  } else {
      echo "File is not an image.";
      $uploadOk = 0;
  }

  // Jika file valid, lanjutkan ke proses upload
  if ($uploadOk && move_uploaded_file($imageFile["tmp_name"], $target_file)) {
      echo "File berhasil diunggah ke " . $target_file;
      return "/images/$targetFolder/$newName"; // Mengembalikan path file
  } else {
      echo "File tidak dapat diunggah.";
      return false; // Upload gagal
  }
}
