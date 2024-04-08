<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();
}

// Jika ada aksi tambah data
if(isset($_POST['tambah'])){
    // Proses tambah data ke database
}

// Jika ada aksi edit data
if(isset($_POST['edit'])){
    // Proses edit data ke database
}

// Jika ada aksi hapus data
if(isset($_POST['hapus'])){
    // Proses hapus data dari database
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Data Pelamar Pekerjaan</h2>
    <table border="1">
        <tr>
            <th>Nama Pelamar</th>
            <th>Lulus Dari</th>
            <th>Jumlah IPK</th>
            <th>Catatan Portfolio</th>
            <th>Aksi</th>
        </tr>
        <!-- Tampilkan data dari database -->
    </table>
    <a href="tambah.php">Tambah Data</a>
    <a href="logout.php">Logout</a>
</body>
</html>
