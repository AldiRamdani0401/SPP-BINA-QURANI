<?php
require BASE_PATH . "/helpers/files/Helper_Images.php";
require BASE_PATH . "/helpers/files/Helper_Delete_Images.php";

class MasterDataController
{
    // Database
    private $servername = "localhost";
    private $port = 9090;
    private $username = "root";
    private $password = "root";
    private $dbname = "db_spp_bina_qurani";
    private $tableSiswa = "tb_siswa";

    private $namaLengkap;
    private $nomorIndukSiswa;
    private $tempatLahir;
    private $tanggalLahir;
    private $jenisKelamin;
    private $kelas;
    private $nikAyah;
    private $namaLengkapAyah;
    private $emailAyah;
    private $nomorTeleponAyah;
    private $nikIbu;
    private $namaLengkapIbu;
    private $emailIbu;
    private $nomorTeleponIbu;
    private $provinsi;
    private $kabupaten;
    private $kecamatan;
    private $desa;
    private $rt;
    private $rw;
    private $kodePos;
    private $photoProfile;

    /* ======= SISWA ===== */
        /* @@@ SHOW : SISWA @@@ */
        public function siswa()
        {
            $path = BASE_PATH . "/views/admin/master-data/siswa/index.php";
            require_once $path;
        }
        /* @@@ CREATE : SISWA @@@ */
        public function createDataSiswa()
        {
            $error = false;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST['nama-lengkap'])) {
                    $this->namaLengkap = $_POST['nama-lengkap'];
                    // echo $this->namaLengkap;
                    echo '<pre>';
                    var_dump($_POST);
                    echo '</pre>';
                    // handleImage('admin');
                }
                if (!empty($_POST['nomor-induk-siswa'])) {
                    $this->nomorIndukSiswa = $_POST['nomor-induk-siswa'];
                }
                if (!empty($_POST['tempat-lahir'])) {
                    $this->tempatLahir = $_POST['tempat-lahir'];
                }
                if (!empty($_POST['tanggal-lahir'])) {
                    $this->tanggalLahir = $_POST['tanggal-lahir'];
                }
                if (!empty($_POST['jenis-kelamin'])) {
                    $this->jenisKelamin = $_POST['jenis-kelamin'];
                }
                if (!empty($_POST['kelas'])) {
                    $this->kelas = $_POST['kelas'];
                }
                if (!empty($_POST['nik-ayah'])) {
                    $this->nikAyah = $_POST['nik-ayah'];
                }
                if (!empty($_POST['nama-lengkap-ayah'])) {
                    $this->namaLengkapAyah = $_POST['nama-lengkap-ayah'];
                }
                if (!empty($_POST['email-ayah'])) {
                    $this->emailAyah = $_POST['email-ayah'];
                }
                if (!empty($_POST['nomor-telepon-ayah'])) {
                    $this->nomorTeleponAyah = $_POST['nomor-telepon-ayah'];
                }
                if (!empty($_POST['nik-ibu'])) {
                    $this->nikIbu = $_POST['nik-ibu'];
                }
                if (!empty($_POST['nama-lengkap-ibu'])) {
                    $this->namaLengkapIbu = $_POST['nama-lengkap-ibu'];
                }
                if (!empty($_POST['email-ibu'])) {
                    $this->emailIbu = $_POST['email-ibu'];
                }
                if (!empty($_POST['nomor-telepon-ibu'])) {
                    $this->nomorTeleponIbu = $_POST['nomor-telepon-ibu'];
                }
                if (!empty($_POST['provinsi'])) {
                    $this->provinsi = $_POST['provinsi'];
                }
                if (!empty($_POST['kabupaten'])) {
                    $this->kabupaten = $_POST['kabupaten'];
                }
                if (!empty($_POST['kecamatan'])) {
                    $this->kecamatan = $_POST['kecamatan'];
                }
                if (!empty($_POST['desa'])) {
                    $this->desa = $_POST['desa'];
                }
                if (!empty($_POST['rt'])) {
                    $this->rt = $_POST['rt'];
                }
                if (!empty($_POST['rw'])) {
                    $this->rw = $_POST['rw'];
                }
                if (!empty($_POST['kode-post'])) {
                    $this->kodePos = $_POST['kode-post'];
                }
                if (isset($_FILES['photo-profile']) && $_FILES['photo-profile']['error'] === UPLOAD_ERR_OK) {
                    $this->photoProfile = Helper_Images('students', $_FILES['photo-profile']);
                    echo $this->photoProfile;
                } else {
                    return true;
                }

                if (!$error) {
                    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } else {
                        $stmt = $conn->prepare("INSERT INTO $this->tableSiswa (
                                    nama_lengkap, nomor_induk_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, kelas,
                                    nama_ayah, nama_ibu, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo_siswa
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param(
                                "ssssssssssssiiis",
                                $this->namaLengkap, $this->nomorIndukSiswa, $this->tempatLahir, $this->tanggalLahir, $this->jenisKelamin, $this->kelas,
                                $this->namaLengkapAyah, $this->namaLengkapIbu, $this->provinsi, $this->kabupaten, $this->kecamatan, $this->desa, $this->rt, $this->rw, $this->kodePos, $this->photoProfile
                        );
                        $stmt->execute();
                        $stmt->close();
                        $conn->close();
                        header("location:/admin/master-data/siswa");
                    }
                } else {
                    echo 'error';
                }
            }
        }
        /* @@@ UPDATE : SISWA @@@ */
        public function updateDataSiswa()
        {
            echo '<pre>';
            var_dump($_POST);
            echo '</pre>';
        }

    /* ======= End of SISWA ===== */

    /* ======= ORANG TUA SISWA ===== */
        /* @@@ SHOW : ORANG TUA SISWA @@@ */
        public function orangTuaSiswa()
        {
            $path = BASE_PATH . "/views/admin/master-data/orang-tua-siswa/index.php";
            require_once $path;
        }
        /* @@@ CREATE : ORANG TUA SISWA @@@ */
        public function createDataOrangTuaSiswa()
        {
            $nik; $namaLengkap; $tempatLahir;
            $tanggalLahir; $jenisKelamin; $hubungan;
            $email; $nomorTelepon; $pekerjaan;
            $provinsi; $kabupaten; $kecamatan;
            $desa; $rt; $rw; $kodePos; $photoProfile;

            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";

            $error = false;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // ** NIK
                $nik = !empty($_POST['nomor-identitas-kependudukan']) ? $_POST['nomor-identitas-kependudukan'] : null;
                // ** Nama Lengkap
                $namaLengkap = !empty($_POST['nama-lengkap']) ? $_POST['nama-lengkap'] : null;
                // ** Tempat Lahir
                $tempatLahir = !empty($_POST['tempat-lahir']) ? $_POST['tempat-lahir'] : null;
                // ** Tanggal Lahir
                $tanggalLahir = !empty($_POST['tanggal-lahir']) ? $_POST['tanggal-lahir'] : null;
                // ** Jenis Kelamin
                $jenisKelamin = !empty($_POST['jenis-kelamin']) ? $_POST['jenis-kelamin'] : null;
                // ** Hubungan
                $hubungan = !empty($_POST['hubungan']) ? $_POST['hubungan'] : null;
                // ** Email
                $email = !empty($_POST['email']) ? $_POST['email'] : null;
                // ** Nomor Telepon
                $nomorTelepon = !empty($_POST['nomor-telepon']) ? $_POST['nomor-telepon'] : null;
                // ** Pekerjaan
                $pekerjaan = !empty($_POST['pekerjaan']) ? $_POST['pekerjaan'] : null;
                // ** Provinsi
                $provinsi = !empty($_POST['provinsi']) ? $_POST['provinsi'] : null;
                // ** Kabupaten
                $kabupaten = !empty($_POST['kabupaten']) ? $_POST['kabupaten'] : null;
                // ** Kecamatan
                $kecamatan = !empty($_POST['kecamatan']) ? $_POST['kecamatan'] : null;
                // ** Desa
                $desa = !empty($_POST['desa']) ? $_POST['desa'] : null;
                // ** RT
                $rt = !empty($_POST['rt']) ? $_POST['rt'] : null;
                // ** RW
                $rw = !empty($_POST['rw']) ? $_POST['rw'] : null;
                // ** Kode Pos
                $kodePos = !empty($_POST['kode-post']) ? $_POST['kode-post'] : null;
                // ** Photo Profile
                $photoProfile = (isset($_FILES['photo-profile']) && $_FILES['photo-profile']['error'] === UPLOAD_ERR_OK) ? Helper_Images('parents', null, $_FILES['photo-profile']) : null;

                // check validate data
                if ($nik && $namaLengkap && $tempatLahir &&
                $tanggalLahir && $jenisKelamin && $hubungan &&
                $email && $nomorTelepon && $pekerjaan &&
                $provinsi && $kabupaten && $kecamatan &&
                $desa && $rt && $rw && $kodePos && $photoProfile) {

                    // Database Connect
                    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } else {
                        // Query
                        $tableOrangTua = 'tb_orang_tua_siswa';
                        $stmt = $conn->prepare("INSERT INTO $tableOrangTua (
                                    nama_lengkap, nomor_identitas_kependudukan, tempat_lahir, tanggal_lahir, jenis_kelamin,
                                    email, nomor_telepon, hubungan, pekerjaan, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param(
                                "sssssssssssssssss",
                                $namaLengkap, $nik, $tempatLahir, $tanggalLahir, $jenisKelamin,
                                $email, $nomorTelepon, $hubungan, $pekerjaan, $provinsi, $kabupaten, $kecamatan, $desa, $rt, $rw, $kodePos, $photoProfile
                        );
                        $stmt->execute();
                        $stmt->close();
                        $conn->close();
                        header("location:/admin/master-data/orang-tua-siswa");
                    }
                } else {
                    echo 'error';
                }
            } else {
                echo 'error';
            }
        }

        /* @@@ UPDATE : ORANG TUA SISWA @@@ */
        public function updateDataOrangTuaSiswa() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && strtolower($_POST['_method']) === 'put') {
                // Ambil data dari form
                $namaLengkap = $_POST['nama-lengkap'] ?? null;
                $nik = $_POST['nomor-identitas-kependudukan'] ?? null;
                $tempatLahir = $_POST['tempat-lahir'] ?? null;
                $tanggalLahir = $_POST['tanggal-lahir'] ?? null;
                $jenisKelamin = $_POST['jenis-kelamin'] ?? null;
                $hubungan = $_POST['hubungan'] ?? null;
                $pekerjaan = $_POST['pekerjaan'] ?? null;
                $email = $_POST['email'] ?? null;
                $nomorTelepon = $_POST['nomor-telepon'] ?? null;
                $provinsi = $_POST['provinsi'] ?? null;
                $kabupaten = $_POST['kabupaten'] ?? null;
                $kecamatan = $_POST['kecamatan'] ?? null;
                $desa = $_POST['desa'] ?? null;
                $rt = $_POST['rt'] ?? null;
                $rw = $_POST['rw'] ?? null;
                $kodePos = $_POST['kode-post'] ?? null;

                // Penanganan foto
                $photo = null;
                if (isset($_FILES['photo-profile']) && $_FILES['photo-profile']['error'] === UPLOAD_ERR_OK) {
                    // Database Connect
                    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Hapus Image Lama
                    $querySelectPhoto = "SELECT photo FROM tb_orang_tua_siswa WHERE nomor_identitas_kependudukan = ?";

                    $stmtSelect = $conn->prepare($querySelectPhoto);
                    $stmtSelect->bind_param('s', $nik);
                    $stmtSelect->execute();
                    $result = $stmtSelect->get_result();
                    $row = $result->fetch_assoc();

                    $newPhotoName = pathinfo($_FILES['photo-profile']['name'], PATHINFO_FILENAME);

                    $oldPhotoName = basename($row['photo']);

                    if ($newPhotoName != $oldPhotoName) {
                        Helper_Delete_Images($oldPhotoName);
                        $photo = Helper_Images('parents', null, $_FILES['photo-profile']);
                    }
                    $stmtSelect->close();
                }

                // Pastikan NIK ada
                if (empty($nik)) {
                    die('Error: NIK harus diisi untuk melakukan update.');
                }

                // Build query
                $query = "UPDATE tb_orang_tua_siswa SET ";
                $params = [];
                if ($namaLengkap) { $query .= "nama_lengkap = ?, "; $params[] = $namaLengkap; }
                if ($tempatLahir) { $query .= "tempat_lahir = ?, "; $params[] = $tempatLahir; }
                if ($tanggalLahir) { $query .= "tanggal_lahir = ?, "; $params[] = $tanggalLahir; }
                if ($jenisKelamin) { $query .= "jenis_kelamin = ?, "; $params[] = $jenisKelamin; }
                if ($hubungan) { $query .= "hubungan = ?, "; $params[] = $hubungan; }
                if ($pekerjaan) { $query .= "pekerjaan = ?, "; $params[] = $pekerjaan; }
                if ($email) { $query .= "email = ?, "; $params[] = $email; }
                if ($nomorTelepon) { $query .= "nomor_telepon = ?, "; $params[] = $nomorTelepon; }
                if ($provinsi) { $query .= "provinsi = ?, "; $params[] = $provinsi; }
                if ($kabupaten) { $query .= "kabupaten = ?, "; $params[] = $kabupaten; }
                if ($kecamatan) { $query .= "kecamatan = ?, "; $params[] = $kecamatan; }
                if ($desa) { $query .= "desa = ?, "; $params[] = $desa; }
                if ($rt) { $query .= "rt = ?, "; $params[] = $rt; }
                if ($rw) { $query .= "rw = ?, "; $params[] = $rw; }
                if ($kodePos) { $query .= "kode_pos = ?, "; $params[] = $kodePos; }
                if ($photo) { $query .= "photo = ?, "; $params[] = $photo; }

                $query = rtrim($query, ', ') . " WHERE nomor_identitas_kependudukan = ?";
                $params[] = $nik;

                // Database Connect
                $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare statement
                $stmt = $conn->prepare($query);
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);

                // Execute
                if (!$stmt->execute()) {
                    die("Error: " . $stmt->error);
                }

                $stmt->close();
                $conn->close();
                header("Location: /admin/master-data/orang-tua-siswa");
            }
        }

        /* @@@ DELETE : ORANG TUA SISWA @@@ */
        public function deleteDataOrangTuaSiswa() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && strtolower($_POST['_method']) === 'delete') {
                $nik = $_POST['nik'];

                // Database Connect
                $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get Image
                $query = "SELECT photo FROM tb_orang_tua_siswa WHERE nomor_identitas_kependudukan = ?";

                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $nik);
                $stmt->execute();
                $result = $stmt->get_result();
                $result = $result->fetch_assoc();
                echo $result['photo'];
                Helper_Delete_Images($result['photo']);

                // Delete Data
                $query = "DELETE FROM tb_orang_tua_siswa WHERE nomor_identitas_kependudukan = ?";

                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $nik);

                if ($stmt->execute()) {
                    header("Location:/admin/master-data/orang-tua-siswa");
                }
            }
        }

    /* ======= End of ORANG TUA SISWA ===== */

    // Kelas
    public function kelas()
    {
        $path = BASE_PATH . "/views/admin/master-data/kelas/index.php";
        require_once $path;
    }

    // Biaya SPP
    public function spp()
    {
        $path = BASE_PATH . "/views/admin/master-data/biaya-spp/index.php";
        require_once $path;
    }

    // Pembayaran
    public function pembayaran()
    {
        $path = BASE_PATH . "/views/admin/master-data/pembayaran/index.php";
        require_once $path;
    }

    // Admin
    public function admin()
    {
        $path = BASE_PATH . "/views/admin/master-data/admin/index.php";
        require_once $path;
    }
}
