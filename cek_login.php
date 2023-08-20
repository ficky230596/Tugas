<?php
session_start();

// Memasukkan file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Cek apakah pengguna sudah login sebelumnya
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect ke halaman sesuai level pengguna
    if ($_SESSION['level'] == "admin") {
        header("location: halaman_admin.php");
    } else if ($_SESSION['level'] == "Dosen") {
        header("location: tampilan/halaman_Dosen.php");
    } else if ($_SESSION['level'] == "Mahasiswa") {
        header("location: tampilan/halaman_mahasiswa.php");
    }
}

// Cek apakah metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Melakukan query untuk mencocokkan data pengguna di database
    $login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($login);

    if ($cek > 0) {
        // Jika data pengguna ditemukan
        $data = mysqli_fetch_assoc($login);
        $user_id = $data['id'];
        $_SESSION['user_id'] = $user_id;

        // Memeriksa level pengguna dan menyimpan informasi sesi
        if ($data['level'] == "admin") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "admin";
            $_SESSION['logged_in'] = true;
            header("location: halaman_admin.php");
        } else if ($data['level'] == "Dosen") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "Dosen";
            $_SESSION['logged_in'] = true;
            header("location: tampilan/halaman_Dosen.php");
        } else if ($data['level'] == "Mahasiswa") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "Mahasiswa";
            $_SESSION['logged_in'] = true;
            header("location: tampilan/halaman_mahasiswa.php");
        } else {
            // Jika level pengguna tidak valid, arahkan ke halaman login dengan pesan gagal
            header("location: index.php?pesan=gagal");
        }
    } else {
        // Jika data pengguna tidak ditemukan, arahkan ke halaman login dengan pesan gagal
        header("location: index.php?pesan=gagal");
    }
}
?>
