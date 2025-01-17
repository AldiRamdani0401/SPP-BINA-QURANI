<?php

class OrangTuaModel extends Model
{
  public function getAllDataOrangTua(): array
  {
    $sql = "SELECT
        nomor_identitas_kependudukan, nama_lengkap, photo, tempat_lahir,
        email, nomor_telepon, tanggal_lahir, jenis_kelamin, rt, rw, desa,
        kecamatan, kabupaten, provinsi, kode_pos, hubungan, pekerjaan, di_buat, di_perbarui
      FROM tb_orang_tua_siswa";

    $result = $this->db->query(query: $sql);
    return $result->fetch_all(mode: MYSQLI_ASSOC); // Mengambil semua baris hasil sebagai array associative
  }
  public function getDataSiswaById($id): array|bool|null
  {
      $sql = "SELECT * FROM tb_orang_tua_siswa WHERE id = ?";
      $stmt = $this->db->prepare($sql);

      $stmt->bind_param("i", $id);

      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc();
  }
}