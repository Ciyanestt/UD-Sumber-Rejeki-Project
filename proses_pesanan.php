<?php
session_start();
include "koneksiDB/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Pastikan ID Pelanggan tersedia dari Session atau POST
    // Jika pelanggan login, id_pelanggan diambil dari session
    $id_pelanggan = isset($_SESSION["id_pelanggan"]) ? $_SESSION["id_pelanggan"] : null;
    
    $id_produk = $_POST["id_produk"];
    $nama_produk = $_POST["nama_produk"];
    $ukuran = $_POST["ukuran"];
    $jumlah = $_POST["jumlah"];
    $metode_pembayaran = $_POST["metode_pembayaran"];
    $pengiriman = $_POST["pengiriman"];
    $harga_satuan = $_POST["harga_satuan"];
    $provinsi = $_POST["provinsi"];
    $kabupaten = $_POST["kabupaten"];
    $alamat_lengkap = $_POST["alamat_lengkap"];
    $biaya_ongkir = $_POST["biaya_ongkir"];
    $total_harga = $_POST["total_harga"];
    $nama_file_bukti = null;

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
        $target_dir = "uploads/";
        $target_file = $target_dir . $nama_file_bukti;

        if (!move_uploaded_file($tmp_name, $target_file)) {
            echo "<script>alert('Gagal mengupload bukti pembayaran!'); window.history.back();</script>";
            exit();
        }
    }

    // 3. Masukkan pesanan ke tabel pesanan (Ditambahkan kolom id_pelanggan)
    $query_pesanan = "INSERT INTO pesanan 
    (id_pelanggan, id_produk, nama_produk, ukuran, harga_satuan, jumlah, total_harga, metode_pembayaran, metode_pengiriman, provinsi, kabupaten, alamat_lengkap, biaya_ongkir, bukti_pembayaran, status) 
    VALUES 
    ('$id_pelanggan', '$id_produk', '$nama_produk', '$ukuran', '$harga_satuan', '$jumlah', '$total_harga', '$metode_pembayaran', '$pengiriman', '$provinsi', '$kabupaten', '$alamat_lengkap', '$biaya_ongkir', '$nama_file_bukti', 'Pending')";

    if (mysqli_query($conn, $query_pesanan)) {
        $id_pesanan_baru = mysqli_insert_id($conn);

        // 4. Cek Role User untuk pengalihan halaman dan history
        if (isset($_SESSION["role"]) && $_SESSION["role"] === "pelanggan") {
            $alamat_gabungan = $alamat_lengkap . ", " . $kabupaten . ", " . $provinsi;
            
            $query_history = "INSERT INTO history_pelanggan 
            (id_pelanggan, id_pesanan, id_produk, kuantitas_pesanan, harga_perproduk, subtotal, metode_pengiriman, alamat_pengiriman, biaya_ongkir) 
            VALUES 
            ('$id_pelanggan', '$id_pesanan_baru', '$id_produk', '$jumlah', '$harga_satuan', '$total_harga', '$pengiriman', '$alamat_gabungan', '$biaya_ongkir')";

            mysqli_query($conn, $query_history);

            echo "<script>
                    alert('Pesanan berhasil dibuat! Terima kasih.');
                    window.location.href = 'history.php';
                  </script>";
        } else {
            // Jika Admin (atau selain pelanggan)
            echo "<script>
                    alert('Pesanan Admin berhasil ditambahkan!');
                    window.location.href = 'rekap.php';
                  </script>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: product.php");
}
?>