<?php
include "koneksiDB/koneksi.php";

$id = $_GET['id'];

// Opsi: Ambil nama file foto dulu untuk dihapus dari folder uploads
$query_foto = mysqli_query($conn, "SELECT foto_produk FROM produk WHERE id_produk = '$id'");
$data_foto = mysqli_fetch_assoc($query_foto);
if ($data_foto['foto_produk'] != "") {
    unlink("pictures/" . $data_foto['foto_produk']); // Menghapus file fisik foto
}

$query_hapus = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = '$id'");

if ($query_hapus) {
    echo "<script>alert('Produk berhasil dihapus!'); window.location.href='product.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk!'); window.location.href='product.php';</script>";
}
?>