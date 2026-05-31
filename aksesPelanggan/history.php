<?php
session_start();

// 1. Koneksi ke database dengan path absolut aman
require_once __DIR__ . "/../koneksiDB/koneksi.php";

/** @var mysqli $conn */ // Menghilangkan tanda merah $conn di VS Code

// Proteksi: Jika bukan pelanggan, kembalikan ke halaman login
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
    header("Location: ../login.php");
    exit();
}

$id_pelanggan = $_SESSION["id_pelanggan"];

// Query menghubungkan tabel history_pelanggan dengan pesanan
$query = mysqli_query(
    $conn,
    "SELECT p.* FROM history_pelanggan hp 
     JOIN pesanan p ON hp.id_pesanan = p.id_pesanan 
     WHERE hp.id_pelanggan = '$id_pelanggan' 
     ORDER BY p.waktu_transaksi DESC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - UD. SUMBER REJEKI</title>
    <link rel="icon" type="image/x-icon" href="../pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #fff; min-height: 100vh; display: flex; flex-direction: column; }

        .watermark-bg {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            max-width: 500px;
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

        .main { flex: 1; padding: 20px; max-width: 800px; margin: 0 auto; width: 100%; }
        .date-section { font-size: 1.5rem; margin: 30px 0 15px; font-weight: bold; color: #2c3e50; }

        .card {
            background: #fbd38d;
            border-radius: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border: none;
        }

        .card-content { padding: 25px; text-align: center; font-size: 1.1rem; font-weight: 500; }
        .card-footer-btn { background: #f6ad55; padding: 12px; text-align: center; }
        .card-footer-btn a { text-decoration: none; color: #333; font-weight: bold; }
        
        .empty-state { text-align: center; margin-top: 50px; color: #718096; }
    </style>
</head>
<body>
    <?php include "../include/header.php"; ?>

    <img src="../pictures/logo.png" class="watermark-bg" alt="Watermark">
    
    <main class="main">
        <h1 class="text-center mb-4" style="font-weight: 700; color: #2c3e50;">Riwayat Pesanan</h1>
        <hr>

        <?php
        $current_date = "";
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)):

                $date_db = date("d F Y", strtotime($row["waktu_transaksi"]));
                $time_db = date("H:i", strtotime($row["waktu_transaksi"]));

                if ($current_date != $date_db) {
                    echo "<h2 class='date-section'>$date_db</h2>";
                    $current_date = $date_db;
                }
                ?>
                <div class="card">
                    <div class="card-content">
                        <?php if ($row["status"] == "Pending"): ?>
                            <span class="text-secondary"><i class="bi bi-clock-history"></i> Menunggu Konfirmasi Pembayaran</span>
                        
                        <?php elseif ($row["status"] == "Diterima"): ?>
                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> Pesanan diterima oleh admin</span>
                        
                        <?php elseif ($row["status"] == "Diantar"): ?>
                            <span class="text-primary fw-bold"><i class="bi bi-truck"></i> Produk anda dalam pengantaran</span>
                        
                        <?php else: ?>
                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> Pesanan Selesai</span>
                        <?php endif; ?>

                        &nbsp; | &nbsp; <span class="badge bg-light text-dark"><?= $time_db ?> WIB</span>
                    </div>
                    <a href="detail_history.php?id=<?= $row["id_pesanan"] ?>" class="text-dark" style="text-decoration: none;">
                        <div class="card-footer-btn">
                            <strong>Lihat Detail Pesanan</strong>
                        </div>
                    </a>
                </div>
                <?php
            endwhile;
        } else {
            echo "<div class='empty-state'>
                    <i class='bi bi-cart-x' style='font-size: 3rem;'></i>
                    <p class='mt-2'>Belum ada riwayat transaksi.</p>
                    <a href='../product.php' class='btn btn-warning btn-sm fw-bold px-4 rounded-pill text-dark'>Mulai Belanja</a>
                  </div>";
        }
        ?>
    </main>

    <?php include "../include/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>