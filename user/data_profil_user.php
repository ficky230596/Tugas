<?php
session_start();
// Periksa apakah pengguna telah login dan apakah peran pengguna adalah admin
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'admin') {
    // Jika pengguna bukan admin, alihkan ke halaman lain (misalnya halaman login)
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna</title>
    <link rel="stylesheet" type="text/css" href="../css/tampilan_profil.css">
    <style>
       
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tugasweb";

    // Buat koneksi database baru
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        // Jika koneksi gagal, tampilkan pesan kesalahan
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $user_id = $_GET['user_id'] ?? ""; // Ambil user_id dari parameter URL

    // Query untuk mengambil data profil berdasarkan user_id
    $sql = "SELECT * FROM profil WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika data profil ditemukan, ambil baris data pertama
        $row = $result->fetch_assoc();
    ?>
        <div class="container">
            <h1>Profil Pengguna</h1>
            <div class="profile">
                <div class="profile-img">
                    <?php
                    // Periksa apakah foto profil tersedia
                    if (isset($row['foto'])) {
                        $fotoPath = "../profil/gambar/profil/" . $row['foto'];
                        if (file_exists($fotoPath)) {
                            // Tampilkan foto profil jika tersedia
                            echo '<img src="' . $fotoPath . '" alt="Foto Profil">';
                        } else {
                            // Tampilkan foto profil default jika tidak tersedia
                            echo '<img src="../profil/gambar/profil/default.jpg" alt="Foto Profil Default">';
                        }
                    } else {
                        // Tampilkan foto profil default jika tidak tersedia
                        echo '<img src="../profil/gambar/profil/default.jpg" alt="Foto Profil Default">';
                    }
                    ?>
                </div>
                <div class="profile-details">
                    <h2><?php echo isset($row['nama']) ? $row['nama'] : ''; ?></h2>
                    <p>NIM/NIP: <?php echo isset($row['nim_nip']) ? $row['nim_nip'] : ''; ?></p>
                    <p>Jenis Kelamin: <?php echo isset($row['jenis_kelamin']) ? $row['jenis_kelamin'] : ''; ?></p>
                    <p>Tanggal Lahir: <?php echo isset($row['tanggal_lahir']) ? $row['tanggal_lahir'] : ''; ?></p>
                    <p>No. Telpon: <?php echo isset($row['no_telpon']) ? $row['no_telpon'] : ''; ?></p>
                </div>
            </div>

            <div class="button-container">
                <a href="data_user.php">Kembali</a>
            </div>
        </div>
    <?php
    } else {
        // Jika data tidak ditemukan, tampilkan pesan
        echo "Data tidak ditemukan.";
    }

    // Tutup koneksi database
    $conn->close();
    ?>
</body>
</html>
