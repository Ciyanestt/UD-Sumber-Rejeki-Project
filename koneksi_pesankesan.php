<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sumber_rejeki"; // 👈 Nama databasemu ditaruh di sini ya!

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal woy: " . $conn->connect_error);
}

echo "HORE! Koneksi berhasil woy!";
?>