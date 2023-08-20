<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Ambil ID pengguna yang login
$user_id = $_SESSION['user_id'];

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

    // Tangkap data yang diubah melalui form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = $_POST['nama'];
        $nim_nip = $_POST['nim_nip'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $no_telpon = $_POST['no_telpon'];

        // Tangkap file foto yang diunggah
        $foto = $_FILES['foto'];

        // Cek apakah file foto diunggah
        if ($foto['name'] !== '') {
            // Tentukan direktori tujuan untuk menyimpan file foto
            $upload_dir = "../surat/profil/gambar/profil/";

            // Generate nama unik untuk file foto
            $file_name = uniqid() . "_" . $foto['name'];

            // Pindahkan file foto ke direktori tujuan
            move_uploaded_file($foto['tmp_name'], $upload_dir . $file_name);

            // Hapus file foto lama jika ada
            if ($row['foto'] !== '') {
                unlink($upload_dir . $row['foto']);
            }

            // Update nama file foto di database
            $update_foto_sql = "UPDATE profil SET foto = '$file_name' WHERE user_id = '$user_id'";
            $conn->query($update_foto_sql);
        }

        // Lakukan validasi data yang diubah (contoh: pastikan tidak ada data yang kosong, validasi tipe data, dll.)

        // Jika data valid, lakukan pembaruan di database
        $update_sql = "UPDATE profil SET nama = '$nama', nim_nip = '$nim_nip', jenis_kelamin = '$jenis_kelamin', tanggal_lahir = '$tanggal_lahir', no_telpon = '$no_telpon' WHERE user_id = '$user_id'";
        if ($conn->query($update_sql) === TRUE) {
            // Pembaruan berhasil, arahkan pengguna kembali ke halaman profil
            header("Location: tampilan_profil.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Profil</title>
  <link rel="stylesheet" type="text/css" href="../css/edit_profil.css">
</head>
<body>
  <div class="container">
    <h1>Edit Profil</h1>
    <form method="post" action="edit_profil.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="foto">Foto Profil:</label>
        <input type="file" id="foto" name="foto">
      </div>
      <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
      </div>
      <div class="form-group">
        <label for="nim_nip">NIM/NIP:</label>
        <input type="text" id="nim_nip" name="nim_nip" value="<?php echo $row['nim_nip']; ?>" required>
      </div>
      <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
          <option value="Laki-laki" <?php if ($row['jenis_kelamin'] === 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
          <option value="Perempuan" <?php if ($row['jenis_kelamin'] === 'Perempuan') echo 'selected'; ?>>Perempuan</option>
        </select>
      </div>
      <div class="form-group">
        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $row['tanggal_lahir']; ?>" required>
      </div>
      <div class="form-group">
        <label for="no_telpon">No. Telpon:</label>
        <input type="text" id="no_telpon" name="no_telpon" value="<?php echo $row['no_telpon']; ?>" required>
      </div>
      <div class="button-container">
        <input type="submit" value="Simpan">
        <a href="tampilan_profil.php">Batal</a>
      </div>
    </form>
  </div>
</body>
</html>

<?php
} else {
    echo "Profil tidak ditemukan.";
    echo "<br>";
    echo "<a href='tampilan_profil.php'>Kembali ke Profil</a>";
}

$conn->close();
?>
