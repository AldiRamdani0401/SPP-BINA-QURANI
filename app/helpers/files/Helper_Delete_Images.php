<?php

function Helper_Delete_Images($fileName) {
  $fileJPGPath = BASE_PATH . "/assets/images/parents/$fileName.jpg";
  $fileJPEGPath = BASE_PATH . "/assets/images/parents/$fileName.jpeg";
  $filePNGPath = BASE_PATH . "/assets/images/parents/$fileName.png";
  echo $fileName . "<br>";
  if (file_exists($fileJPGPath)) {
      echo $fileJPGPath;
      unlink($fileJPGPath);
  }
  if (file_exists($fileJPEGPath)) {
      echo $fileJPEGPath;
      unlink($fileJPEGPath);
  }
  if (file_exists($filePNGPath)) {
      echo $filePNGPath;
      unlink($filePNGPath);
  }
}