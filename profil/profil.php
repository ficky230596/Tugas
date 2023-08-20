<?php
// Fungsi untuk memeriksa koneksi ke database
function checkDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tugasweb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}

// Fungsi untuk menyimpan data biodata ke database
function simpanDataBiodata($conn, $nama, $nim_nip, $jenis_kelamin, $tanggal_lahir, $no_telpon, $foto, $user_id) {
    // Tentukan direktori tujuan untuk menyimpan file foto
    $upload_dir = "surat/profil/gambar/profil/";

    // Generate nama unik untuk file foto
    $file_name = uniqid() . "_" . $foto['name'];

    // Pindahkan file foto ke direktori tujuan
    move_uploaded_file($foto['tmp_name'], $upload_dir . $file_name);

    $sql = "INSERT INTO profil (nama, nim_nip, jenis_kelamin, tanggal_lahir, no_telpon, foto, user_id)
            VALUES ('$nama', '$nim_nip', '$jenis_kelamin', '$tanggal_lahir', '$no_telpon', '$file_name', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

$conn = checkDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nim_nip = $_POST['nim_nip'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $no_telpon = $_POST['no_telpon'];
    $foto = $_FILES['foto'];
    $user_id = $_POST['user_id'];

    $result = simpanDataBiodata($conn, $nama, $nim_nip, $jenis_kelamin, $tanggal_lahir, $no_telpon, $foto, $user_id);

    if ($result) {
        header("Location: tampilan_profil.php");
        exit;
    } else {
        echo "Error: Gagal menyimpan data.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Form Biodata Diri</title>
</head>
<title>Form Biodata Diri</title>
  <link rel="stylesheet" type="text/css" href="../css/profil.css">
<body>
  <form action="tampilan_profil.php" method="POST" enctype="multipart/form-data">
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" required>

    <label for="nim_nip">NIM/NIP:</label>
    <input type="text" name="nim_nip" id="nim_nip" required>

    <label for="jenis_kelamin">Jenis Kelamin:</label>
    <select name="jenis_kelamin" id="jenis_kelamin" required>
      <option value="Laki-laki">Laki-laki</option>
      <option value="Perempuan">Perempuan</option>
    </select>

    <label for="tanggal_lahir">Tanggal Lahir:</label>
    <input type="date" name="tanggal_lahir" id="tanggal_lahir" required>

    <label for="no_telpon">Nomor Telepon:</label>
    <input type="text" name="no_telpon" id="no_telpon" required>

    <label for="foto">Foto:</label>
    <input type="file" name="foto" id="foto" required>

    <?php
      session_start();
      // Periksa apakah user_id ada dalam sesi sebelum mengaksesnya
      $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
      if ($user_id) {
        echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
      } else {
        echo 'User tidak terautentikasi.'; // Tampilkan pesan kesalahan jika user tidak terautentikasi
      }
    ?>

    <input type="submit" value="Simpan">
  </form>
</body>
</html>
