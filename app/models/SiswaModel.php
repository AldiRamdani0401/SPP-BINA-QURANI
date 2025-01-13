<?php

require_once BASE_PATH . "/core/Database.php";

class SiswaModel
{
  private $db;

  // Constructor untuk inisialisasi database
  public function __construct($database)
  {
    $this->db = $database;
  }

  // Fungsi untuk mendapatkan semua data siswa (dengan pagination)
  public function getAllDataSiswa($limit = 10, $offset = 0)
  {
    $sql = "SELECT * FROM siswa LIMIT :limit OFFSET :offset";
    $params = [
      'limit' => $limit,
      'offset' => $offset
    ];

    $data = $this->db->query($sql, $params);

    // Menghitung total data siswa
    $totalSql = "SELECT COUNT(*) as total FROM siswa";
    $totalResult = $this->db->query($totalSql);

    return [
      'data' => $data,
      'total' => $totalResult[0]['total'] ?? 0
    ];
  }

  // Fungsi untuk mendapatkan data siswa berdasarkan ID
  public function getSiswaById($id)
  {
    $sql = "SELECT * FROM siswa WHERE id = :id";
    $params = ['id' => $id];
    return $this->db->query($sql, $params)[0] ?? null;
  }

  // Fungsi untuk menambahkan data siswa
  public function addSiswa($data)
  {
    $sql = "INSERT INTO siswa (nama_lengkap, nomor_induk, kelas, tanggal_lahir, jenis_kelamin)
                VALUES (:nama_lengkap, :nomor_induk, :kelas, :tanggal_lahir, :jenis_kelamin)";
    $params = [
      'nama_lengkap' => $data['nama_lengkap'],
      'nomor_induk' => $data['nomor_induk'],
      'kelas' => $data['kelas'],
      'tanggal_lahir' => $data['tanggal_lahir'],
      'jenis_kelamin' => $data['jenis_kelamin']
    ];
    return $this->db->execute($sql, $params);
  }

  // Fungsi untuk mengupdate data siswa berdasarkan ID
  public function updateSiswa($id, $data)
  {
    $sql = "UPDATE siswa
                SET nama_lengkap = :nama_lengkap, nomor_induk = :nomor_induk, kelas = :kelas,
                    tanggal_lahir = :tanggal_lahir, jenis_kelamin = :jenis_kelamin
                WHERE id = :id";
    $params = [
      'id' => $id,
      'nama_lengkap' => $data['nama_lengkap'],
      'nomor_induk' => $data['nomor_induk'],
      'kelas' => $data['kelas'],
      'tanggal_lahir' => $data['tanggal_lahir'],
      'jenis_kelamin' => $data['jenis_kelamin']
    ];
    return $this->db->execute($sql, $params);
  }

  // Fungsi untuk menghapus data siswa berdasarkan ID
  public function deleteSiswa($id)
  {
    $sql = "DELETE FROM siswa WHERE id = :id";
    $params = ['id' => $id];
    return $this->db->execute($sql, $params);
  }
}
