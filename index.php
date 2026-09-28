<?php
session_start();

// ============================================================
//  TUGAS JURNAL PRAKTIKUM - PEMROGRAMAN WEB
//  Sistem Pendaftaran Calon Asisten Praktikum Laboratorium
// ============================================================
//  Nama  : Syaddad Raihan Putra
//  NIM   : 102042500079
//  Kelas : JS1SI-25-REG-05
// ============================================================

// Daftar mata kuliah praktikum
$daftar_matkul = [
    "Algoritma dan Pemrograman",
    "Analisis dan Perancangan Sistem Informasi",
    "Arsitektur Enterprise",
    "Data Warehouse dan Business Intelligence",
    "Komputasi Awan",
    "Pemodelan Proses Bisnis",
    "Pengantar Sistem Informasi",
    "Pengembangan Aplikasi Bergerak",
    "Pengembangan Aplikasi Website",
    "Pengembangan UI Lanjut",
    "Proyek Perangkat Lunak",
    "Sistem Enterprise",
    "Sistem Informasi Akuntansi",
    "Sistem Operasi"
];

// **********************  1  **************************  
// Inisialisasi variabel untuk menyimpan nilai input dan error
// Buat variabel: $nama, $whatsapp, $email, $matkul, $motivasi
// Buat variabel error: $namaErr, $waErr, $emailErr, $matkulErr, $motivasiErr
// Beri nilai awal string kosong ""
// silakan taruh kode kalian di bawah
$nama = "";
$whatsapp = "";
$email = "";
$matkul = "";
$motivasi = "";
$namaErr = "";
$waErr = "";
$emailErr = "";
$matkulErr = "";
$motivasiErr = "";

// Mode tampilan default adalah form
$mode = "form";

// Cek apakah tombol "Lihat Data Pendaftar" diklik
if (isset($_GET['page']) && $_GET['page'] === 'id_card') {
    if (!empty($_SESSION['data_pendaftar'])) {
        $nama = $_SESSION['data_pendaftar']['nama'];
        $whatsapp = $_SESSION['data_pendaftar']['whatsapp'];
        $email = $_SESSION['data_pendaftar']['email'];
        $matkul = $_SESSION['data_pendaftar']['matkul'];
        $motivasi = $_SESSION['data_pendaftar']['motivasi'];
        $mode = "id_card";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // **********************  2  **************************  
    // - Tangkap nilai dari form (Lihat atribut name="nama_lengkap" pada form di Task 7)
    // - Validasi agar nama tidak boleh kosong
    // - Validasi agar nama hanya berupa huruf (Hint : gunakan fungsi preg_match)
    // silakan taruh kode kalian di bawah
    $nama = trim($_POST["nama_lengkap"]);
    if (empty($nama)) {
        $namaErr = "Nama tidak boleh kosong";
    } else {
        if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
            $namaErr = "Nama hanya boleh berisi huruf dan spasi";
        }
    }

    // **********************  3  **************************  
    // - Tangkap nilai dari form (Lihat atribut name="no_whatsapp" pada form di Task 7)
    // - Validasi agar nomor whatsapp tidak boleh kosong
    // - Validasi agar nomor whatsapp diawali '0' atau '62' (Hint : gunakan fungsi substr)
    // silakan taruh kode kalian di bawah
    $whatsapp = trim($_POST["no_whatsapp"]);
    if (empty($whatsapp)) {
        $waErr = "Nomor WhatsApp tidak boleh kosong";
    } else {
        if (substr($whatsapp, 0, 2) !== '08' && substr($whatsapp, 0, 2) !== '62') {
            $waErr = "Nomor WhatsApp harus diawali dengan '08' atau '62'";
        }
    }

    // **********************  4  **************************  
    // - Tangkap nilai dari form (Lihat atribut name="email_institusi" pada form di Task 7)
    // - Memeriksa apakah email kosong
    // - Memeriksa apakah format email valid (Hint : gunakan fungsi filter_var)
    // silakan taruh kode kalian di bawah
    $email = trim($_POST["email_institusi"]);
    if (empty($email)) {
        $emailErr = "Email tidak boleh kosong";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }

    // **********************  5  **************************  
    // - Tangkap nilai dari form (Lihat atribut name="pilihan_matkul" pada form di Task 7)
    // - Validasi agar pilihan mata kuliah tidak boleh kosong
    // silakan taruh kode kalian di bawah
    $matkul = trim($_POST["pilihan_matkul"]);
    if (empty($matkul)) {
        $matkulErr = "Pilihan mata kuliah tidak boleh kosong";
    }


    // **********************  6  **************************  
    // - Tangkap nilai dari form (Lihat atribut name="motivasi" pada form di Task 7)
    // - Validasi agar motivasi tidak boleh kosong
    // silakan taruh kode kalian di bawah
    $motivasi = trim($_POST["motivasi"]);
    if (empty($motivasi)) {
        $motivasiErr = "Motivasi tidak boleh kosong";
    }

    // **********************  8  **************************  
    // Cek jika seluruh error kosong (pendaftaran berhasil):
    // - Simpan data pendaftar ke dalam $_SESSION['data_pendaftar']
    // - Ubah $mode menjadi "id_card" agar form berganti ke tampilan Kartu Registrasi
    // silakan taruh kode kalian di bawah
    if (empty($namaErr) && empty($waErr) && empty($emailErr) && empty($matkulErr) && empty($motivasiErr)) {
        $_SESSION['data_pendaftar'] = [
            'nama' => $nama,
            'whatsapp' => $whatsapp,
            'email' => $email,
            'matkul' => $matkul,
            'motivasi' => $motivasi
        ];
        $mode = "id_card";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Calon Asisten Praktikum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php if ($mode === "id_card") { ?>

        <!-- ==================== MODE ID CARD ==================== -->
        <div class="id-card">
            <img src="logo.png" alt="Logo" class="logo">
            <div class="id-card-header">
                <h2>Kartu Registrasi</h2>
                <p>Calon Asisten Praktikum Laboratorium</p>
            </div>

            <div class="alert alert-success">
                <strong>Berhasil!</strong> Data pendaftaran telah diterima.
            </div>

            <div class="id-card-body">
                <!-- **********************  9  ************************** -->
                <!-- Tampilkan data pendaftar ke dalam baris-baris ID Card di bawah ini -->
                <div class="id-card-row">
                    <span class="id-card-label">Nama Lengkap</span>
                    <span class="id-card-value"><?php echo htmlspecialchars($nama); ?></span>
                </div>

                <div class="id-card-row">
                    <span class="id-card-label">No. WhatsApp</span>
                    <span class="id-card-value"><?php echo htmlspecialchars($whatsapp); ?></span>
                </div>

                <hr class="id-card-divider">

                <div class="id-card-row">
                    <span class="id-card-label">Email Institusi</span>
                    <span class="id-card-value"><?php echo htmlspecialchars($email); ?></span>
                </div>

                <div class="id-card-row">
                    <span class="id-card-label">Mata Kuliah</span>
                    <span class="id-card-value"><?php echo htmlspecialchars($matkul); ?></span>
                </div>

                <hr class="id-card-divider">

                <div class="id-card-row">
                    <span class="id-card-label">Motivasi</span>
                    <span class="id-card-value"><?php echo nl2br(htmlspecialchars($motivasi)); ?></span>
                </div>

                <div style="text-align: center; margin-top: 18px;">
                    <span class="id-card-badge">Pendaftaran Berhasil</span>
                </div>
            </div>

            <a href="?page=form" class="btn-kembali">Kembali ke Form</a>

            <div class="id-card-footer">
                Nomor Registrasi: REG-<?php echo strtoupper(substr(md5(time()), 0, 8)); ?> &bull; Dicetak otomatis oleh
                sistem
            </div>
        </div>

    <?php } else { ?>

        <!-- ==================== MODE FORM ==================== -->
        <div class="container">
            <img src="logo.png" alt="Logo" class="logo">
            <h2>Pendaftaran Asisten Praktikum</h2>
            <p class="subtitle">Laboratorium Enterprise Application Development</p>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && (!empty($namaErr) || !empty($waErr) || !empty($emailErr) || !empty($matkulErr) || !empty($motivasiErr))) { ?>
                <div class="alert alert-danger">
                    <strong>Pendaftaran gagal!</strong> Harap perbaiki data yang salah.
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <!-- **********************  7  ************************** -->
                <!-- Tambahkan value di tiap input untuk menampilkan kembali data setelah submit (retaining input) -->
                <!-- Hint : value pada input form harus berisi variabel yang menyimpan data input -->

                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso" value="<?php echo $nama; ?>">
                    <span class="error"><?php echo $namaErr ? "* $namaErr" : ""; ?></span>
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp <span class="required">*</span></label>
                    <input type="number" name="no_whatsapp" placeholder="Contoh: 081234567890">
                    <span class="error"><?php echo $waErr ? "* $waErr" : ""; ?></span>
                </div>

                <div class="form-group">
                    <label>Email Institusi <span class="required">*</span></label>
                    <input type="email" name="email_institusi" placeholder="Contoh: budi@university.ac.id">
                    <span class="error"><?php echo $emailErr ? "* $emailErr" : ""; ?></span>
                </div>

                <div class="form-group">
                    <label>Pilihan Mata Kuliah Praktikum <span class="required">*</span></label>
                    <select name="pilihan_matkul">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php foreach ($daftar_matkul as $mk) { ?>
                            <option value="<?php echo $mk; ?>" <?php echo ($matkul == $mk) ? 'selected' : ''; ?>>
                                <?php echo $mk; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <span class="error"><?php echo $matkulErr ? "* $matkulErr" : ""; ?></span>
                </div>

                <div class="form-group">
                    <label>Motivasi Mendaftar <span class="required">*</span></label>
                    <textarea name="motivasi"
                        placeholder="Tuliskan alasan kamu ingin menjadi asisten praktikum..."><?php echo $motivasi; ?></textarea>
                    <span class="error"><?php echo $motivasiErr ? "* $motivasiErr" : ""; ?></span>
                </div>

                <div class="button-container">
                    <button type="submit">Daftar Sekarang</button>
                    <?php if (!empty($_SESSION['data_pendaftar'])) { ?>
                        <a href="?page=id_card" class="btn-lihat-data">Lihat Data Pendaftar</a>
                    <?php } ?>
                </div>
            </form>
        </div>

    <?php } ?>

</body>

</html>