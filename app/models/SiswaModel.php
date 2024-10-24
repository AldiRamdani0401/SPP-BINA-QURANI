<?php

class SiswaModel extends Model
{
  public function getAllDataSiswa($filterBy = null, $orderBy = 'nomor_induk_siswa', $limit = 10, $offset = 10): array
  {
    // Query untuk menghitung total data siswa
    $countSql = "SELECT COUNT(*) as total FROM tb_siswa";

    // Menambahkan filter ke query total jika ada
    if ($filterBy) {
      $countSql .= " WHERE " . $filterBy;
    }

    $countResult = $this->db->query(query: $countSql);
    $totalCount = $countResult->fetch_assoc()['total'];

    if($totalCount < 2) {
      $limit = 1;
      $offset = 0;
    }

    // Membangun query dasar
    $sql = "SELECT
                nomor_induk_siswa, nama_lengkap, photo_siswa,
                kelas, jenis_kelamin, tempat_lahir, tanggal_lahir,
                nama_ayah, nama_ibu, rt, rw, desa, kecamatan, kabupaten,
                provinsi, kode_pos, di_buat, di_perbarui
            FROM tb_siswa";

    // Menambahkan filter jika ada
    if ($filterBy) {
      $sql .= " WHERE " . $filterBy;
    }

    // Menambahkan pengurutan
    if ($orderBy) {
      $sql .= " ORDER BY " . $orderBy;
    }

    $sql .= " LIMIT ? OFFSET ?";
    error_log($sql);
    // Menyiapkan dan mengeksekusi query
    $stmt = $this->db->prepare(query: $sql);
    $stmt->bind_param("ii", $limit,$offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $siswaData = $result->fetch_all(mode: MYSQLI_ASSOC);

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