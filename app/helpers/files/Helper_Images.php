<?php
function Helper_Images($targetFolder, $subFolder, $imageFile) {
  // Membuat nama file baru
  $newName = $targetFolder . "_" . basename($imageFile['name']);
  $target_dir = is_null($subFolder) ? BASE_PATH . "/assets/images/$targetFolder/" :  BASE_PATH . "/assets/images/$targetFolder/$subFolder/";

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
      echo "<br> File berhasil diunggah ke " . $target_file . "<br>";
      $fileNameWithoutExt = pathinfo($imageFile['name'], PATHINFO_FILENAME);

      // Hilangkan ekstensi file
      $newName = $targetFolder . "_" . $fileNameWithoutExt;

      $photoPath = is_null($subFolder) ? "/images/$targetFolder/_/$newName" : "/images/$targetFolder/$subFolder/$newName";
      echo "<br> path: $photoPath <br>";
      return $photoPath; // Mengembalikan path file
  } else {
      echo "File tidak dapat diunggah.";
      return false; // Upload gagal
  }
}
