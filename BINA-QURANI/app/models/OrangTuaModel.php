<?php

class OrangTuaModel extends Model
{
  public function getAllDataOrangTua(): array
  {
    $sql = "SELECT
        id, nama_lengkap,nomor_identitas_kependudukan,tempat_lahir
        ,tanggal_lahir,jenis_kelamin,photo,rt,rw,desa,kecamatan
        ,kabupaten,provinsi,kode_pos,di_buat,di_perbarui,email
        ,nomor_telepon,hubungan,pekerjaan
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