<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="../css/edit_user.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();

        // Periksa level pengguna saat mengakses halaman
        if ($_SESSION['level'] === "Mahasiswa" || $_SESSION['level'] === "Dosen") {
            header("Location:..\index.php"); // Redirect ke halaman lain jika level bukan admin
            exit();
        }

        //koneksi ke database
        $koneksi = mysqli_connect("localhost", "root", "", "tugasweb");

        //ambil data dari parameter GET
        $id = $_GET['id'];

        //query untuk mengambil data user berdasarkan ID
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$id'");

        //menampilkan data user dalam bentuk form
        if(mysqli_num_rows($query) == 1){
            $data = mysqli_fetch_assoc($query);
            ?>
            <h1>Edit User</h1>
            <form method="post">
                <table>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><input type="text" name="username" value="<?php echo $data['username']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input type="password" name="password" value="<?php echo $data['password']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>:</td>
                        <td>
                            <select name="level">
                                <option value="">-- Pilih Level --</option>
                                <option value="admin" <?php if($data['level'] == "admin"){ echo "selected"; } ?>>Admin</option>
                                <option value="Dosen" <?php if($data['level'] == "dosen"){ echo "selected"; } ?>>Dosen</option>
                                <option value="Mahasiswa" <?php if($data['level'] == "mahasiswa"){ echo "selected"; } ?>>Mahasiswa</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="submit" name="simpan" value="Simpan"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><a href="data_user.php">Kembali</a></td>
                    </tr>
                </table>
            </form>
            <?php
        }

        //aksi update data user
        if(isset($_POST['simpan'])){
            //ambil data dari form
            $username = $_POST['username'];
            $password = $_POST['password'];
            $level = $_POST['level'];

            //query untuk update data user
            $query = mysqli_query($koneksi, "UPDATE user SET username='$username', password='$password', level='$level' WHERE id='$id'");

            //cek apakah query berhasil
            if($query){
                echo "<script>alert('Data berhasil diupdate');</script>";
                echo "<script>window.location.href='data_user.php';</script>";
            } else{
                echo "<script>alert('Data gagal diupdate');</script>";
                echo "<script>window.location.href='data_user.php';</script>";
            }
        }
        ?>
    </div>
</body>
</html>
