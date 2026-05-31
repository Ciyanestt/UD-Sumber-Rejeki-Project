<?php
session_start();

// 1. Koneksi ke database (Menggunakan __DIR__ agar absolut dan aman)
require_once __DIR__ . "/../koneksiDB/koneksi.php";

/** @var mysqli $conn */ // Menghilangkan tanda merah variabel $conn di VS Code

// Proteksi halaman: Pastikan hanya pelanggan yang bisa mengakses proses ini
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
    header("Location: ../login.php"); // Mundur ke folder utama
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil ID Pelanggan dari session
    $id_pelanggan = isset($_SESSION["id_pelanggan"]) ? $_SESSION["id_pelanggan"] : null;
    
    // Amankan semua inputan POST dari SQL Injection
    $id_produk          = mysqli_real_escape_string($conn, $_POST["id_produk"]);
    $nama_produk        = mysqli_real_escape_string($conn, $_POST["nama_produk"]);
    $ukuran             = mysqli_real_escape_string($conn, $_POST["ukuran"]);
    $jumlah             = mysqli_real_escape_string($conn, $_POST["jumlah"]);
    $metode_pembayaran  = mysqli_real_escape_string($conn, $_POST["metode_pembayaran"]);
    $pengiriman         = mysqli_real_escape_string($conn, $_POST["pengiriman"]);
    $harga_satuan       = mysqli_real_escape_string($conn, $_POST["harga_satuan"]);
    $provinsi           = mysqli_real_escape_string($conn, $_POST["provinsi"]);
    $kabupaten          = mysqli_real_escape_string($conn, $_POST["kabupaten"]);
    $alamat_lengkap     = mysqli_real_escape_string($conn, $_POST["alamat_lengkap"]);
    $biaya_ongkir       = mysqli_real_escape_string($conn, $_POST["biaya_ongkir"]);
    $total_harga        = mysqli_real_escape_string($conn, $_POST["total_harga"]);
    $nama_file_bukti    = null;

    // 2. Logika Upload Bukti Pembayaran
    if (
        $metode_pembayaran !== "COD" &&
        isset($_FILES["bukti_bayar"]) &&
        $_FILES["bukti_bayar"]["error"] === UPLOAD_ERR_OK
    ) {
        $tmp_name = $_FILES["bukti_bayar"]["tmp_name"];
        $nama_file_asli = $_FILES["bukti_bayar"]["name"];
        $ekstensi = strtolower(pathinfo($nama_file_asli, PATHINFO_EXTENSION));
        $nama_file_bukti = uniqid() . "." . $ekstensi;
        
        // Diarahkan keluar ke folder uploads utama (../uploads/)
        $target_dir = "../uploads/";
        $target_file = $target_dir . $nama_file_bukti;

        if (!move_uploaded_file($tmp_name, $target_file)) {
            echo "<script>alert('Gagal mengupload bukti pembayaran!'); window.history.back();</script>";
            exit();
        }
    }

    // 3. Masukkan pesanan ke tabel pesanan
    $query_pesanan = "INSERT INTO pesanan 
    (id_pelanggan, id_produk, nama_produk, ukuran, harga_satuan, jumlah, total_harga, metode_pembayaran, metode_pengiriman, provinsi, kabupaten, alamat_lengkap, biaya_ongkir, bukti_pembayaran, status) 
    VALUES 
    ('$id_pelanggan', '$id_produk', '$nama_produk', '$ukuran', '$harga_satuan', '$jumlah', '$total_harga', '$metode_pembayaran', '$pengiriman', '$provinsi', '$kabupaten', '$alamat_lengkap', '$biaya_ongkir', '$nama_file_bukti', 'Pending')";

    if (mysqli_query($conn, $query_pesanan)) {
        $id_pesanan_baru = mysqli_insert_id($conn);

        // 4. Catat ke history_pelanggan
        $alamat_gabungan = $alamat_lengkap . ", " . $kabupaten . ", " . $provinsi;
        
        $query_history = "INSERT INTO history_pelanggan 
        (id_pelanggan, id_pesanan, id_produk, kuantitas_pesanan, harga_perproduk, subtotal, metode_pengiriman, alamat_pengiriman, biaya_ongkir) 
        VALUES 
        ('$id_pelanggan', '$id_pesanan_baru', '$id_produk', '$jumlah', '$harga_satuan', '$total_harga', '$pengiriman', '$alamat_gabungan', '$biaya_ongkir')";

        mysqli_query($conn, $query_history);

        // Pengalihan JavaScript diarahkan keluar folder pemesanan (../history.php)
        echo "<script>
                alert('Pesanan berhasil dibuat! Terima kasih.');
                window.location.href = '../aksesPelanggan/history.php';
              </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: ../product.php");
    exit();
}
?>