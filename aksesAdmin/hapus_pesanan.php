<?php
session_start();
require_once __DIR__ . "/../koneksiDB/koneksi.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

// Ambil nama file bukti dulu untuk dihapus dari folder uploads (opsional agar hemat storage)
$cek = mysqli_query($conn, "SELECT bukti_pembayaran FROM pesanan WHERE id_pesanan = '$id'");
$d = mysqli_fetch_assoc($cek);
if ($d['bukti_pembayaran']) {
    unlink("../uploads/" . $d['bukti_pembayaran']);
}

// Hapus dari kedua tabel
mysqli_query($conn, "DELETE FROM history_pelanggan WHERE id_pesanan = '$id'");
$hapus = mysqli_query($conn, "DELETE FROM pesanan WHERE id_pesanan = '$id'");

if ($hapus) {
    echo "<script>alert('Pesanan telah dihapus!'); window.location.href='rekap.php';</script>";
} else {
    echo "Gagal hapus: " . mysqli_error($conn);
}
?>