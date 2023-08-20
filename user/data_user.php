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
    <title>Data User</title>
    <style>

		body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(45deg, #c3e8bd, #ffd3b6, #ffb6b9, #c8bfff, #b6dcff, #c3e8bd);
            background-size: 600% 600%;
            animation: gradientBackground 15s ease infinite;
        }

        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .link-container {
            margin-bottom: 10px;
        }

        .link-container a {
            display: inline-block;
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
        }

        .link-container a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f5f5f5;
        }

        table tbody tr:hover {
            background-color: #ebebeb;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .action-buttons a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Data User</h1>
    <div class="container">
        <div class="link-container">
            <a href="..\halaman_admin.php">Kembali</a>
            <a href="tambah_user.php">Tambah User</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // koneksi ke database
                $koneksi = mysqli_connect("localhost", "root", "", "tugasweb");

                // query untuk menampilkan semua data user
                $query = mysqli_query($koneksi, "SELECT * FROM user");

                $no = 1;
                while($data = mysqli_fetch_assoc($query)){
                    echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$data['id']."</td>";
                    echo "<td>".$data['nama']."</td>";
                    echo "<td>".$data['username']."</td>";
                    echo "<td>".$data['password']."</td>";
                    echo "<td>".$data['level']."</td>";
                    echo "<td class='action-buttons'>
                            <a href='edit_user.php?id=".$data['id']."'>Edit</a>
                            <a href='hapus_user.php?id=".$data['id']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                            <a href='data_profil_user.php?user_id=".$data['id']."'>Lihat Profil</a>
                        </td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
