<?php

class SiswaModel extends Model
{
  public function getAllDataSiswa($limit = 10, $offset = 0): array
  {
      // Query untuk mengambil data siswa sesuai pagination
      $sql = "SELECT
                  nomor_induk_siswa, nama_lengkap, photo_siswa,
                  kelas, jenis_kelamin, tempat_lahir, tanggal_lahir,
                  nama_ayah, nama_ibu, rt, rw, desa, kecamatan, kabupaten,
                  provinsi, kode_pos, di_buat, di_perbarui
              FROM tb_siswa ORDER BY id LIMIT ? OFFSET ?";
      $stmt = $this->db->prepare($sql);
      $stmt->bind_param("ii", $limit, $offset);
      $stmt->execute();
      $result = $stmt->get_result();
      $siswaData = $result->fetch_all(MYSQLI_ASSOC);

      // Query untuk menghitung total data siswa
      $countSql = "SELECT COUNT(*) as total FROM tb_siswa";
      $countResult = $this->db->query($countSql);
      $totalCount = $countResult->fetch_assoc()['total'];

      // Mengembalikan hasil data siswa beserta total count
      return [
          'total' => $totalCount, // Total data siswa
          'data' => $siswaData,   // Data siswa hasil query pagination
      ];
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