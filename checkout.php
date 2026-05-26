<?php
session_start();
include "koneksiDB/koneksi.php";

// Pastikan user login
if (!isset($_SESSION["id_pelanggan"])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: product.php");
    exit();
}

// 1. Tangkap data (HANYA UNTUK DITAMPILKAN & DIOPER, TIDAK DISIMPAN DULU)
$id_produk = $_POST["id_produk"];
$nama_produk = $_POST["nama_produk"];
$ukuran = $_POST["ukuran"];
$jumlah = (int) $_POST["jumlah"];
$metode_pembayaran = $_POST["metode_pembayaran"];
$pengiriman = $_POST["pengiriman"];
$provinsi = isset($_POST["provinsi"]) ? $_POST["provinsi"] : "";
$kabupaten = isset($_POST["kabupaten"]) ? $_POST["kabupaten"] : "";
$alamat_lengkap = isset($_POST["alamat_lengkap"]) ? $_POST["alamat_lengkap"] : "";
$biaya_ongkir = isset($_POST["biaya_ongkir"]) ? (int) $_POST["biaya_ongkir"] : 0;
$harga_satuan = isset($_POST["harga_satuan"]) ? (int) $_POST["harga_satuan"] : 0;
$total_harga = $_POST["total_harga"];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - UD. SUMBER REJEKI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .receipt-card {
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        /* Aksen garis atas pada kartu (opsional) */
        .receipt-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #ffc107, #ff9800);
        }

        .border-dashed {
            border-bottom: 2px dashed #dee2e6;
        }

        .btn-checkout {
            background: linear-gradient(45deg, #ffc107, #ff9800);
            border: none;
            transition: all 0.3s ease;
            color: #000;
        }
        .btn-checkout:hover {
            background: linear-gradient(45deg, #ff9800, #ffc107);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.4);
            color: #fff;
        }
        
        .file-upload-box {
            border: 2px dashed #ced4da;
            transition: all 0.3s ease;
        }
        .file-upload-box:hover, .file-upload-box:focus-within {
            border-color: #ff9800;
            background-color: #fffaf0;
        }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="receipt-card p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-25 rounded-circle mb-3" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-receipt fs-2 text-warning"></i>
                        </div>
                        <h2 class="fw-bold mb-1">Selesaikan Pembayaran</h2>
                        <p class="text-muted small">Harap periksa kembali pesanan Anda sebelum melanjutkan.</p>
                    </div>

                    <div class="bg-light p-4 rounded-4 mb-4 delay-1 fade-in-up">
                        <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing: 1px;"><i class="fa-solid fa-cart-shopping me-2"></i>Rincian Pesanan</h6>
                        
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Produk</span>
                            <span class="fw-bold text-end"><?= htmlspecialchars($nama_produk) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Ukuran/Berat</span>
                            <span class="fw-semibold"><?= htmlspecialchars($ukuran) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Harga Satuan</span>
                            <span class="fw-semibold">Rp <?= number_format($harga_satuan, 0, ",", ".") ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Jumlah</span>
                            <span class="fw-semibold"><?= htmlspecialchars($jumlah) ?> Item</span>
                        </div>
                        <div class="d-flex justify-content-between pb-3 mb-3 border-dashed small">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span class="fw-semibold">Rp <?= number_format($biaya_ongkir, 0, ",", ".") ?></span>
                        </div>
                        
                        <div class="p-3 bg-dark text-white rounded-3 shadow-sm text-center" style="background: linear-gradient(135deg, #212529, #343a40) !important;">
                            <span class="d-block text-white-50 small mb-1">Total yang harus dibayar</span>
                            <h3 class="fw-bold text-warning mb-0">Rp <?= number_format($total_harga, 0, ",", ".") ?></h3>
                        </div>
                    </div>

                    <div class="mb-4 delay-2 fade-in-up">
                        <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="letter-spacing: 1px;"><i class="fa-solid fa-wallet me-2"></i>Instruksi Pembayaran</h6>
                        
                        <?php if ($metode_pembayaran === "QRIS"): ?>
                            <div class="border rounded-4 p-4 text-center bg-white shadow-sm">
                                <h6 class="mb-3 text-dark fw-bold">Scan QRIS Berikut:</h6>
                                <img src="pictures/qris.jpg" alt="QRIS" class="img-fluid rounded border p-2" style="max-width: 200px;">
                                <p class="text-muted small mt-3 mb-0">Buka aplikasi m-banking atau e-wallet Anda, lalu scan kode QR di atas.</p>
                            </div>
                            
                        <?php elseif ($metode_pembayaran === "Transfer Bank"): ?>
                            <div class="bg-primary bg-opacity-10 border border-primary border-opacity-25 p-4 rounded-4 shadow-sm text-center">
                                <h6 class="mb-2 text-dark">Transfer ke Rekening:</h6>
                                <div class="bg-white p-3 rounded-3 d-inline-block shadow-sm my-2">
                                    <h3 class="fw-bold text-primary mb-1 tracking-wider" style="letter-spacing: 2px;">1234 5678 90</h3>
                                    <p class="mb-0 fw-semibold text-secondary">Bank BCA a/n UD SUMBER REJEKI</p>
                                </div>
                                <p class="text-muted small mt-2 mb-0">Pastikan nominal transfer sesuai hingga 3 digit terakhir.</p>
                            </div>
                            
                        <?php elseif ($metode_pembayaran === "COD"): ?>
                            <div class="bg-success bg-opacity-10 border border-success border-opacity-25 p-4 rounded-4 text-center shadow-sm">
                                <i class="fa-solid fa-hand-holding-dollar fs-1 text-success mb-2"></i>
                                <h5 class="fw-bold text-success mb-1">Bayar di Tempat (COD)</h5>
                                <p class="text-dark small mb-0 mt-2">Siapkan uang tunai sejumlah <strong>Rp <?= number_format($total_harga, 0, ",", ".") ?></strong> saat pesanan Anda tiba atau saat mengambil di toko.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form action="proses_pesanan.php" method="POST" id="form-pesan" enctype="multipart/form-data" class="delay-2 fade-in-up">
                        <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
                        <input type="hidden" name="harga_satuan" value="<?= $harga_satuan ?>">
                        <input type="hidden" name="total_harga" value="<?= $total_harga ?>">
                        <input type="hidden" name="nama_produk" value="<?= $nama_produk ?>">
                        <input type="hidden" name="ukuran" value="<?= $ukuran ?>">
                        <input type="hidden" name="jumlah" value="<?= $jumlah ?>">
                        <input type="hidden" name="metode_pembayaran" value="<?= $metode_pembayaran ?>">
                        <input type="hidden" name="pengiriman" value="<?= $pengiriman ?>">
                        <input type="hidden" name="provinsi" value="<?= $provinsi ?>">
                        <input type="hidden" name="kabupaten" value="<?= $kabupaten ?>">
                        <input type="hidden" name="alamat_lengkap" value="<?= $alamat_lengkap ?>">
                        <input type="hidden" name="biaya_ongkir" value="<?= $biaya_ongkir ?>">
                        
                        <?php if ($metode_pembayaran !== "COD"): ?>
                            <div class="mb-4 bg-white p-3 rounded-4 file-upload-box text-center">
                                <label for="bukti_bayar" class="form-label fw-bold text-dark d-block mb-2">
                                    <i class="fa-solid fa-cloud-arrow-up fs-4 d-block mb-2 text-primary"></i>
                                    Upload Bukti Pembayaran
                                </label>
                                <input class="form-control form-control-sm mx-auto" type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*" required style="max-width: 300px;">
                                <div class="form-text small mt-2"><i class="fa-solid fa-circle-info me-1"></i>Format: JPG, JPEG, PNG. Maks: 2MB.</div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex flex-column gap-2 mt-4">
                            <button type="submit" class="btn btn-checkout w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm">
                                <i class="fa-solid fa-check-circle me-2"></i> KONFIRMASI PESANAN
                            </button>
                            
                            <button type="button" class="btn btn-light w-100 py-2 rounded-pill fw-bold text-secondary border shadow-sm" onclick="window.history.back();">
                                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>