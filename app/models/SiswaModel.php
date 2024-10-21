<?php

class SiswaModel extends Model
{
  public function getAllDataSiswa(): array
  {
    $sql = "SELECT
              nomor_induk_siswa, nama_lengkap, photo_siswa,
              kelas, jenis_kelamin, tempat_lahir, tanggal_lahir,
              nama_ayah, nama_ibu, rt, rw, desa, kecamatan, kabupaten,
              provinsi, kode_pos, di_buat, di_perbarui
            FROM tb_siswa";
    $result = $this->db->query(query: $sql);
    return $result->fetch_all(mode: MYSQLI_ASSOC); // Mengambil semua baris hasil sebagai array associative
  }
  public function getDataSiswaById($id): array|bool|null
  {
      $sql = "SELECT * FROM tb_siswa WHERE id = ?";
      $stmt = $this->db->prepare($sql);

      $stmt->bind_param("i", $id);

      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc();
  }
}