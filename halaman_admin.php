<?php
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    // Redirect pengguna ke halaman login jika belum login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
    <link rel="stylesheet" type="text/css" href="css/halaman_admin.css">
    <style>
        /* CSS untuk tombol-tombol navigasi */
        nav {
            float: left;
            margin-right: 20px;
        }

        /* CSS untuk tombol-tombol action */
        .nav {
            text-align: center;
        }

        .nav a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: #060000;
            background-color: #ffffff96;
            border-radius: 4px;
        }

        .nav a:hover {
            background-color: #ff00f764;
        }
        
        /* CSS untuk tabel */
        table {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }
        
        /* CSS untuk lebar kolom */
        table td:first-child {
            width: 70px;
        }

        table td:nth-child(3) {
            width: 250px;
        }
    </style>
    <script>
        // Mencegah tombol "Back" pada browser
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        // Mengarahkan pengguna ke halaman_admin.php saat menekan tombol "Back"
        function goBack() {
            window.location.href = "halaman_admin.php";
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>Halaman Admin</h1>
        <div class="center">
            <table>
                <thead>
                    <tr>
                        <td class="greeting">Halo <b><?php echo $_SESSION['username']; ?></b>. Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="nav">
        <a href="profil/tampilan_profil.php"><i class="fas fa-user"></i> Profil</a>
        <a href="surat/tambah_surat.php"><i class="fas fa-plus"></i> Tambah Surat</a>
        <a href="surat/menampilkan_surat.php"><i class="fas fa-envelope"></i> Lihat Surat</a>
        <a href="user/data_user.php"><i class="fas fa-database"></i> Data User</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <table>
        <thead>
            <tr align="center">
                <th style="width: 70px;">No </th>
                <th>Nomor Surat</th>
                <th style="width: 250px;">Perihal</th>
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
    
    <script>
        // Menambahkan event listener pada tombol "Back" pada halaman ini
        document.addEventListener("DOMContentLoaded", function() {
            var backButton = document.querySelector(".header");
            backButton.addEventListener("click", goBack);
        });
    </script>
</body>
</html>
