<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tugasweb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$nama = $_POST['nama'] ?? "";
$nim_nip = $_POST['nim_nip'] ?? "";
$jenis_kelamin = $_POST['jenis_kelamin'] ?? "";
$tanggal_lahir = $_POST['tanggal_lahir'] ?? "";
$no_telpon = $_POST['no_telpon'] ?? "";
$foto = $_FILES['foto']['name'] ?? "";
$tujuan_folder = 'gambar/profil/';

// Cek apakah folder sudah ada atau belum
if (!is_dir($tujuan_folder)) {
    // Buat folder jika belum ada
    mkdir($tujuan_folder, 0755, true);
}

$user_id = $_POST['user_id'] ?? ""; // Ambil data user_id

// Pindahkan file foto ke folder tujuan
$tujuan_file = $tujuan_folder . basename($_FILES['foto']['name']);
move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan_file);

// Simpan data ke database
$sql = "INSERT INTO profil (user_id, nama, nim_nip, jenis_kelamin, tanggal_lahir, no_telpon, foto)
        VALUES ('$user_id', '$nama', '$nim_nip', '$jenis_kelamin', '$tanggal_lahir', '$no_telpon', '$foto')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan, kembali ke profil 5 detik lagi.";
    // Redirect ke halaman tampilan_profil.php setelah data berhasil disimpan dan meninjau beberapa detik
    header("Refresh: 5; URL=tampilan_profil.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
