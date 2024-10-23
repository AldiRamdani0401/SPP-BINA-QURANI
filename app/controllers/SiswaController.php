<?php
require __DIR__ . "/../core/Controller.php";

class SiswaController extends Controller
{
  protected $role = 'admin';
  public function show($id = null): void
  {
    $data = [
      'title' => "Data Siswa | Admin",
    ];
    $this->render(role: $this->role, view: 'siswa/index', data: $data);
  }

  public function getAllDataSiswa(): void
  {
      $siswaModel = $this->model->load(modelName: 'Siswa');

      // Membaca input dari body request
      $input = json_decode(json: file_get_contents(filename: 'php://input'), associative: true);

      // Debugging: Cetak isi input
      file_put_contents(filename: 'php://stderr', data: print_r(value: $input, return: true));

      // Jika input tidak valid
      if ($input === null) {
          echo json_encode(value: ['error' => 'Invalid JSON input']);
          return;
      }

      // Mendapatkan parameter tambahan jika ada, dengan validasi tambahan
      $filterBy = isset($input['filterBy']) && $input['filterBy'] != '' ? $input['filterBy'] : null;
      $orderBy = isset($input['orderBy']) && $input['orderBy'] != '' ? $input['orderBy'] : 'id';
      $limit = isset($input['limit']) ? (int) $input['limit'] : 10;
      $offset = isset($input['offset']) ? (int) $input['offset'] : 0;

      header(header: 'Content-Type: application/json');

      // Ambil data dari model dengan limit, offset, groupBy, orderBy, dan filterBy
      $siswa = $siswaModel->getAllDataSiswa($filterBy, $orderBy, $limit, $offset);

      // Return data siswa dan total count dalam format JSON
      echo json_encode(value: $siswa);
  }

}
