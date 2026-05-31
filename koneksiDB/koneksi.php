<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "itik_project";

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Pengecekan apakah koneksi berhasil atau gagal
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>