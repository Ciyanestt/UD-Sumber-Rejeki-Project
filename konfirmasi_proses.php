<?php
session_start();
include "koneksiDB/koneksi.php";
$id = $_GET['id'];

$query = mysqli_query($conn, "UPDATE pesanan SET status = 'Diterima' WHERE id_pesanan = '$id'");

if ($query) {
    echo "<script>alert('Pembayaran Berhasil Dikonfirmasi!'); window.location.href='rekap.php';</script>";
}
?>