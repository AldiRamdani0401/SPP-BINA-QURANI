<?php

class KelasModel extends Model
{
  public function getAllDataKelas(): array
  {
    $sql = "SELECT nama_kelas FROM tb_kelas";
    $result = $this->db->query(query: $sql);
    return $result->fetch_all(mode: MYSQLI_ASSOC); // Mengambil semua baris hasil sebagai array associative
  }
  public function getDataKelasById($id): array|bool|null
  {
      $sql = "SELECT * FROM tb_siswa WHERE id = ?";
      $stmt = $this->db->prepare($sql);

      $stmt->bind_param("i", $id);

      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc();
  }
}