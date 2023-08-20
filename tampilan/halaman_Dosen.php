<?php
session_start();
// Periksa apakah pengguna telah login dan apakah peran pengguna adalah admin
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'Dosen') {
    // Jika pengguna bukan admin, alihkan ke halaman lain (misalnya halaman login)
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Dosen</title>
    <link rel="stylesheet" type="text/css" href="..\css\halaman_admin.css">
</head>
<body>

    <div class="container">
        <h1>Halaman Dosen</h1>

        <table class="nav-table" border="1">
            <thead>
                <tr>
                    <td>Halo <b><?php echo $_SESSION['username']; ?></b>. Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <a href="..\profil\tampilan_profil.php">Profil</a>
                        <a href="..\surat\menampilkan_surat.php">Lihat Surat</a>
                        <a href="..\logout.php">Logout</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Perihal</th>
                    <th>Isi Surat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // koneksi ke database
                $koneksi = mysqli_connect("localhost", "root", "", "tugasweb");

                // query untuk menampilkan semua data surat
                $query = mysqli_query($koneksi, "SELECT * FROM surat");

                $no = 1;
                while($data = mysqli_fetch_assoc($query)){
                    echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".substr($data['nomor_surat'], 0, 10)."</td>";
                    echo "<td>".substr($data['hal'], 0, 20)."</td>";
                    echo "<td>".substr($data['isi_surat'], 0, 10)."</td>";
                    echo "</tr>";

                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Redirect ke halaman "index.php" saat tombol back ditekan
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.replace("index.php");
            }
        });
    </script>
</body>
</html>
