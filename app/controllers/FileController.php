<?php

require_once BASE_PATH . "/helpers/files/Helper_Load_Images.php";
require_once BASE_PATH . "/helpers/files/Helper_Load_Files.php";

class FileController {
  /**
   * Load and return the content of a file.
   *
   * @param string $filePath The path to the file to be loaded.
   * @return string|false The content of the file, or false if loading fails.
   */
  public function load($main_folder, $sub_folder, $nested_folder = null, $file_name) {
    // images
    switch ($main_folder) {
      case 'images':
        Helper_Load_Images($main_folder, $sub_folder, $file_name);
        break;
      case 'files':
        Helper_Load_Files($main_folder, $sub_folder, $nested_folder, $file_name);
      // case 'files':
      //   Helper_Load_Images($main_folder, $sub_folder, $file_name);
      //   break;

      default:
        echo 'not found';
        break;
    }
  }
}
