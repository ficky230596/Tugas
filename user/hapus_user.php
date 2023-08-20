<?php
// koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "tugasweb");

// cek apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // hapus data user dari tabel user
    $hapus_user = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");

    // hapus data profil dari tabel profil berdasarkan user_id
    $hapus_profil = mysqli_query($koneksi, "DELETE FROM profil WHERE user_id = '$id'");

    if ($hapus_user && $hapus_profil) {
        // penghapusan berhasil
        echo "<script>alert('User beserta profil berhasil dihapus.');</script>";
    } else {
        // penghapusan gagal
        echo "<script>alert('Gagal menghapus user beserta profil.');</script>";
    }
}

// redirect ke halaman data_user.php setelah penghapusan
echo "<script>window.location.href = 'data_user.php';</script>";
?>
