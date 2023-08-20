<!DOCTYPE html>
<html>
<head>
	<title>Tambah User</title>
	<link rel="stylesheet" type="text/css" href="..\css\admin.css">
</head>
<body>
<?php
session_start();


// Periksa level pengguna saat mengakses halaman
if ($_SESSION['level'] === "Mahasiswa" || $_SESSION['level'] === "Dosen") {
    header("Location: ..\index.php"); // Redirect ke halaman lain jika level bukan admin
    exit();
}


// Cek apakah user sudah login atau belum
if (!isset($_SESSION['level'])) {
    header("location: index.php"); //redirect ke halaman login jika belum login
}

	//koneksi ke database
	$koneksi = mysqli_connect("localhost", "root", "", "tugasweb");

	//cek apakah tombol simpan sudah diklik atau belum
	if(isset($_POST['simpan'])){
		//ambil data dari form
		$id = $_POST['id'];
		$nama = $_POST['nama'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$level = $_POST['level'];

		//query untuk menyimpan data ke database
		$query = mysqli_query($koneksi, "INSERT INTO user VALUES ('$id', '$nama', '$username', '$password', '$level')");

		//cek apakah query berhasil
		if($query){
			echo "<script>alert('Data berhasil disimpan');</script>";
		} else{
			echo "<script>alert('Data gagal disimpan');</script>";
            
		}
        header("Location: data_user.php");
        exit();
	}
	?>
	<h1>Tambah User</h1>
	<form method="post">
		<table>
			<tr>
				<td>ID</td>
				<td>:</td>
				<td><input type="text" name="id"></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td><input type="text" name="nama"></td>
			</tr>
			<tr>
				<td>Username</td>
				<td>:</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td>:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td>Level</td>
				<td>:</td>
				<td>
					<select name="level">
						<option value="">-- Pilih Level --</option>
						<option value="admin">Admin</option>
						<option value="Dosen">Dosen</option>
                        <option value="Mahasiswa">Mahasiswa</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><input type="submit" name="simpan" value="Simpan"></td>
			</tr>
		</table>
	</form>
	<a href="data_user.php">Kembali</a>
</body>
</html>
