<?php
// mengaktifkan session pada php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Ambil ID pengguna yang login
$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];

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

// Ambil data profil berdasarkan ID pengguna
$sql = "SELECT * FROM profil WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <title>Profil Pengguna</title>
      <link rel="stylesheet" type="text/css" href="../css/tampilan_profil.css">
    </head>
    <body>
      <div class="container">
        <h1>Profil Pengguna</h1>
        <div class="profile">
          <div class="profile-img">
            <img src="gambar/profil/<?php echo $row['foto']; ?>" alt="Foto Profil">
          </div>
          <div class="profile-details">
            <h2><?php echo $row['nama']; ?></h2>
            <p><span>NIM/NIP:</span> <?php echo $row['nim_nip']; ?></p>
            <p><span>Jenis Kelamin:</span> <?php echo $row['jenis_kelamin']; ?></p>
            <p><span>Tanggal Lahir:</span> <?php echo $row['tanggal_lahir']; ?></p>
            <p><span>No. Telpon:</span> <?php echo $row['no_telpon']; ?></p>

          </div>
        </div>

        <div class="button-container">
          <?php
          // Tombol kembali sesuai dengan level pengguna
          if ($level == "admin") {
              echo "<a href='../halaman_admin.php'>Kembali</a>";
          } else if ($level == "Dosen") {
              echo "<a href='../tampilan/halaman_Dosen.php'>Kembali</a>";
          } else if ($level == "Mahasiswa") {
              echo "<a href='../tampilan/halaman_mahasiswa.php'>Kembali</a>";
          }
          ?>
          <a href="edit_profil.php">Edit Profil</a>
        </div>
      </div>
    </body>
    </html>

    <?php
} else {
    echo "Profil tidak ditemukan.";
    echo "<br>";
    echo "<a href='profil.php'>Isi Profil</a>"; // Tambahkan tautan ke profil.php
}

$conn->close();
?>
