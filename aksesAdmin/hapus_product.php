<?php
session_start();
require_once __DIR__ . "/../koneksiDB/koneksi.php";

// 1. Proteksi Akses Admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// Include SweetAlert2 Core & Style agar selaras dengan tema sistem
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<style>
    .swal2-popup { font-family: 'Montserrat', sans-serif !important; border-radius: 20px !important; }
    .swal2-confirm { background: linear-gradient(135deg, #0a1d37 0%, #16325c 100%) !important; }
</style>";

// 2. Ambil ID dan amankan dari SQL Injection menggunakan mysqli_real_escape_string
$id = isset($_GET["id"]) ? mysqli_real_escape_string($conn, $_GET["id"]) : "";

if (empty($id)) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'ID Tidak Valid!',
                text: 'Mengarahkan kembali ke halaman produk...',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => { window.location='../product.php'; });
        });
    </script>";
    exit();
}

// 3. Tarik data untuk mengambil nama file foto produk
$query_foto = mysqli_query($conn, "SELECT foto_produk FROM produk WHERE id_produk = '$id'");
$data_foto = mysqli_fetch_assoc($query_foto);

if ($data_foto) {
    $foto_lama = $data_foto["foto_produk"]; // Berisi: "pictures/nama_foto.jpg"

    // PERBAIKAN UTAMA: Tambahkan "../" saja di depan path database agar jalurnya pas menjadi "../pictures/nama_foto.jpg"
    $path_fisik_foto = "../" . $foto_lama;

    // Pastikan file fisik ada di folder, bukan string kosong, dan bukan gambar default bawaan sistem
    if (file_exists($path_fisik_foto) && !empty($foto_lama) && $foto_lama != "pictures/default.png") {
        unlink($path_fisik_foto); // Menghapus file fisik foto dengan bersih
    }

    // 4. Jalankan Query Hapus Data dari Database
    $query_hapus = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = '$id'");

    if ($query_hapus) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil Dihapus!',
                    text: 'Komoditas produk telah dikeluarkan dari sistem.',
                    icon: 'success',
                    confirmButtonText: 'Selesai'
                }).then(() => { window.location.href='../product.php'; });
            });
        </script>";
    } else {
        $error_msg = addslashes(mysqli_error($conn));
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal Menghapus!',
                    text: 'Error Sistem: $error_msg',
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                }).then(() => { window.location.href='../product.php'; });
            });
        </script>";
    }
} else {
    // Jika ID produk tidak ditemukan di database
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Produk Tidak Ditemukan!',
                text: 'Data mungkin sudah dihapus sebelumnya.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => { window.location.href='../product.php'; });
        });
    </script>";
}
?>