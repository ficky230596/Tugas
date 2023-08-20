<?php 
// Membuat koneksi ke database MySQL
$koneksi = mysqli_connect("localhost", "root", "", "tugasweb");
 
// Memeriksa koneksi ke database
if (mysqli_connect_errno()) {
    // Jika koneksi gagal, tampilkan pesan kesalahan
    echo "Koneksi database gagal: " . mysqli_connect_error();
}
?>
