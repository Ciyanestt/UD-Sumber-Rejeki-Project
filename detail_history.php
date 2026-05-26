<?php
session_start();
include "koneksiDB/koneksi.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
    header("Location: login.php");
    exit();
}

$id_pesanan = $_GET['id'];
$id_pelanggan = $_SESSION["id_pelanggan"];

// Query mengambil data UTAMA dari history_pelanggan
// JOIN ke produk hanya untuk mendapatkan nama produk terbaru jika masih ada
$query = mysqli_query($conn, "SELECT hp.*, p.nama_produk as nama_produk_asli 
    FROM history_pelanggan hp
    LEFT JOIN produk p ON hp.id_produk = p.id_produk
    WHERE hp.id_pesanan = '$id_pesanan' AND hp.id_pelanggan = '$id_pelanggan'");

$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='history.php';</script>";
    exit();
}

// Logika Warna Status (Menyesuaikan Tema Fresh)
$status = $data['status_pesanan'] ?? "Menunggu"; 
$badge_class = "badge-menunggu";
$icon_class = "bi-clock-history";

if (stripos($status, 'diterima') !== false || stripos($status, 'selesai') !== false) {
    $badge_class = "badge-diterima";
    $icon_class = "bi-check-circle-fill";
} elseif (stripos($status, 'tolak') !== false || stripos($status, 'batal') !== false) {
    $badge_class = "badge-ditolak";
    $icon_class = "bi-x-circle-fill";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #<?= $data['id_pesanan'] ?> - UD. SUMBER REJEKI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* --- GLOBAL RESET & FRESH THEME --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        
        body { 
            background-color: #fdfbf6; /* Krem hangat cerah */
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            color: #444;
        }

        /* --- STYLING KARTU NOTA DIGITAL --- */
        .receipt-card {
            background: #ffffff;
            border-radius: 1.5rem;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }
        
        /* Garis Aksen Atas Kartu (Oranye ke Teal) */
        .receipt-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #ff9f1c, #20b2aa); 
            z-index: 1;
        }

        /* --- LABEL STATUS --- */
        .status-badge {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-diterima { background-color: #e6fffa; color: #008080; border: 1px solid rgba(0,128,128,0.2); }
        .badge-menunggu { background-color: #fff3e0; color: #e67e22; border: 1px solid rgba(230,126,34,0.2); }
        .badge-ditolak  { background-color: #fff5f5; color: #c0392b; border: 1px solid rgba(192,57,43,0.2); }

        /* --- TIPOGRAFI & PEMISAH --- */
        .section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #20b2aa; /* Teal accent */
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .dashed-divider {
            border-bottom: 2px dashed #e9ecef;
            margin: 20px 0;
        }

        .label-custom { color: #888; font-size: 0.85rem; font-weight: 500; margin-bottom: 2px; }
        .value-custom { color: #222; font-size: 1rem; font-weight: 600; }

        /* --- BOX TOTAL PEMBAYARAN --- */
        .total-box {
            background: linear-gradient(135deg, #f8f9fa, #f1f3f5);
            border-radius: 1rem;
            padding: 20px;
            border: 1px solid #e9ecef;
        }
        .grand-total-text {
            color: #ff9f1c; /* Oranye Fresh */
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* --- TOMBOL --- */
        .btn-back {
            background: #fff;
            color: #444;
            font-weight: 600;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: #f8f9fa;
            border-color: #20b2aa;
            color: #20b2aa;
            transform: translateX(-5px);
        }

        /* --- 🌟 ANIMASI SMOOTH (STAGGERED) 🌟 --- */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        /* Delay berurutan untuk tiap elemen */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.25s; }
        .delay-3 { animation-delay: 0.4s; }
        .delay-4 { animation-delay: 0.55s; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php include "include/header.php"; ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                
                <div class="receipt-card p-4 p-md-5 fade-in-up">
                    
                    <div class="text-center mb-4 pb-3 border-bottom delay-1 fade-in-up">
                        <p class="label-custom text-uppercase tracking-widest mb-1">Nomor Pesanan</p>
                        <h2 class="fw-bold text-dark mb-3">#<?= htmlspecialchars($data['id_pesanan']) ?></h2>
                        <span class="status-badge <?= $badge_class ?>">
                            <i class="<?= $icon_class ?>"></i> <?= htmlspecialchars($status) ?>
                        </span>
                    </div>

                    <div class="row text-center mb-2 delay-2 fade-in-up">
                        <div class="col-12">
                            <p class="label-custom"><i class="bi bi-calendar-check me-1"></i> Tanggal & Waktu Transaksi</p>
                            <p class="value-custom fs-5"><?= date("d M Y • H:i", strtotime($data["waktu_transaksi"])) ?> WIB</p>
                        </div>
                    </div>

                    <div class="dashed-divider delay-2 fade-in-up"></div>

                    <div class="delay-3 fade-in-up">
                        <h6 class="section-title"><i class="bi bi-box-seam"></i> Produk yang Dipesan</h6>
                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mt-3">
                            <div>
                                <p class="mb-1 fw-bold text-dark fs-5"><?= htmlspecialchars($data['nama_produk_asli']) ?></p>
                                <p class="label-custom mb-0"><?= $data['kuantitas_pesanan'] ?> Item x Rp <?= number_format($data['harga_perproduk'], 0, ',', '.') ?></p>
                            </div>
                            <div class="text-end">
                                <p class="fw-bold text-dark mb-0 fs-5">Rp <?= number_format($data['kuantitas_pesanan'] * $data['harga_perproduk'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="dashed-divider delay-3 fade-in-up"></div>

                    <div class="delay-4 fade-in-up">
                        <h6 class="section-title"><i class="bi bi-truck"></i> Informasi Pengiriman</h6>
                        <div class="row mt-3 g-3">
                            <div class="col-sm-6">
                                <div class="p-3 border rounded-3 h-100">
                                    <p class="label-custom">Metode</p>
                                    <p class="value-custom mb-0"><?= htmlspecialchars($data['metode_pengiriman']) ?></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 border rounded-3 h-100">
                                    <p class="label-custom">Alamat Tujuan</p>
                                    <p class="value-custom mb-0" style="line-height: 1.4;">
                                        <?= htmlspecialchars($data['alamat_pengiriman'] ?: 'Ambil di Toko') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashed-divider delay-4 fade-in-up"></div>

                    <div class="delay-4 fade-in-up">
                        <h6 class="section-title mb-3"><i class="bi bi-wallet2"></i> Ringkasan Pembayaran</h6>
                        <div class="total-box shadow-sm">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted fw-medium">Subtotal Produk</span>
                                <span class="fw-semibold">Rp <?= number_format($data['kuantitas_pesanan'] * $data['harga_perproduk'], 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <span class="text-muted fw-medium">Biaya Ongkos Kirim</span>
                                <span class="fw-semibold">Rp <?= number_format($data['biaya_ongkir'], 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Total Pembayaran</span>
                                <span class="grand-total-text">Rp <?= number_format($data['subtotal'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center delay-4 fade-in-up">
                        <a href="history.php" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Riwayat
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div style="width: 100%; height: 5px; background: linear-gradient(90deg, #ff9f1c, #20b2aa); margin-top: auto;"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>