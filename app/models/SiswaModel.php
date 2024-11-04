<?php

class SiswaModel extends Model
{
  public function getAllDataSiswa($filterBy = null, $orderBy = 'nomor_induk_siswa', $limit = 10, $offset = null): array
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
    }

    error_log("TOTAL : $totalCount");

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

    if ($limit >= 10 && $offset != null) {
      $sql .= " LIMIT ? OFFSET ?";
    } else {
      $sql .= " LIMIT ? ";
    }
    error_log($sql);
    // Menyiapkan dan mengeksekusi query
    $stmt = $this->db->prepare(query: $sql);

    if ($limit >= 10 && $offset != null) {
      $stmt->bind_param("ii", $limit,$offset);
    } else {
      $stmt->bind_param("i", $limit);
    }

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