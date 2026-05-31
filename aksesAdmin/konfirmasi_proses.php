<?php
session_start();
require_once __DIR__ . "/../koneksiDB/koneksi.php";

// 1. Proteksi Halaman Admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// 2. Validasi Parameter ID dan Status dari URL
if (isset($_GET["id"]) && isset($_GET["status"])) {
    // Ambil data dan amankan dari SQL Injection dasar
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $status = mysqli_real_escape_string($conn, $_GET["status"]);

    // Validasi nilai status agar hanya menerima yang sesuai dengan ENUM database
    $status_valid = ['Diterima', 'Diantar'];
    
    if (in_array($status, $status_valid)) {
        
        // 3. Eksekusi Query Update Status secara Dinamis
        $query = mysqli_query(
            $conn,
            "UPDATE pesanan SET status = '$status' WHERE id_pesanan = '$id'"
        );

        if ($query) {
            // Tentukan pesan notifikasi berdasarkan status yang dikirim
            $pesan = ($status === 'Diterima') ? 'Pesanan Berhasil Diterima!' : 'Pesanan Berhasil Diantar!';
            
            echo "<script>
                alert('$pesan'); 
                window.location.href='rekap.php'; 
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Gagal memperbarui status pesanan.'); 
                window.location.href='rekap.php'; 
            </script>";
            exit();
        }
        
    } else {
        // Jika status yang dikirim di URL tidak valid (misal diubah manual)
        echo "<script>
            alert('Status tidak valid!'); 
            window.location.href='rekap.php'; 
        </script>";
        exit();
    }
} else {
    // Jika ID atau Status tidak ditemukan di URL
    header("Location: rekap.php");
    exit();
}
?>