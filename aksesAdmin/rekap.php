<?php
session_start();
require_once __DIR__ . "/../koneksiDB/koneksi.php";

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// 2. Ambil data dari tabel pesanan DIJOIN dengan tabel pelanggan
$query = mysqli_query(
    $conn,
    "SELECT pesanan.*, pelanggan.no_hp 
     FROM pesanan
     LEFT JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.id_pelanggan 
     ORDER BY pesanan.id_pesanan DESC",
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penjualan - UD. SUMBER REJEKI</title>
    <link rel="icon" type="image/x-icon" href="../pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            color: #212529;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Header & Brand Accent */
        .main-header {
            background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
            color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 31, 63, 0.2);
        }
        .admin-badge {
            background-color: #ff9f43;
            color: #001f3f;
            padding: 6px 16px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
        }
        /* Card & Table Styling */
        .data-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead {
            background-color: #001f3f;
            color: white;
            position: sticky;
            top: 0;
        }
        .table thead th {
            padding: 15px;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 3px solid #ff9f43 !important;
        }
        .table tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background 0.2s;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa !important;
        }
        .table tbody td {
            padding: 15px;
            font-size: 0.9rem;
        }
        /* Badges */
        .badge-info-custom {
            background-color: #e3f2fd;
            color: #0d47a1;
            border: 1px solid #bbdefb;
            font-size: 0.75rem;
            padding: 4px 8px;
        }
        .status-badge-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 5px;
        }
        .status-badge-diterima {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 5px;
        }
        .status-badge-diantar {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 5px;
        }
        /* Buttons */
        .btn-custom-action {
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 8px;
        }
        /* Modal Customization */
        .modal-header-custom {
            background-color: #001f3f;
            color: white;
            border-bottom: 4px solid #ff9f43;
        }
        .section-divider {
            color: #001f3f;
            font-weight: bold;
            border-bottom: 2px solid #001f3f;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .img-bukti {
            max-height: 250px;
            object-fit: contain;
            border: 2px dashed #001f3f;
            border-radius: 10px;
            padding: 5px;
            background: #fdfdfd;
        }

        /* --- Kustomisasi SweetAlert2 Tema Admin --- */
        .admin-swal-popup {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            border-radius: 16px !important;
            padding: 25px !important;
        }
        .admin-swal-title {
            color: #001f3f !important;
            font-weight: 700 !important;
            font-size: 22px !important;
        }
        .admin-swal-text {
            font-size: 15px !important;
            color: #495057 !important;
            font-weight: 500 !important;
        }
        .admin-swal-btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 10px 24px !important;
            font-size: 14px !important;
        }
    </style>
</head>
<body>

    <div class="container-fluid p-4 p-md-5">
        
        <div class="main-header p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold m-0"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Laporan Rekap Penjualan</h2>
                <p class="m-0 text-white-50 small mt-1">UD. SUMBER REJEKI — Panel Manajemen Utama</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="admin-badge"><i class="fa-solid fa-user-shield me-1"></i> Admin Mode</span>
                <a href="/project itik 2/product.php" class="btn btn-light fw-bold text-dark btn-custom-action px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="card data-card p-4">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Informasi Produk</th>
                            <th>No. HP Pelanggan</th>
                            <th style="width: 80px;">Qty</th>
                            <th>Total Bayar</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 260px;">Aksi Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($query) > 0):
                            while ($data = mysqli_fetch_assoc($query)):

                                $total_bayaran = (int) $data["total_harga"];
                                $modalId = "detailModal" . $data["id_pesanan"];
                                ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-bold text-dark fs-6 mb-1"><?= $data[
                                        "nama_produk"
                                    ] ?></div>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <span class="badge badge-info-custom">Ukuran: <?= $data[
                                            "ukuran"
                                        ] ?></span>
                                        <span class="badge bg-secondary text-white small">ID: #<?= $data[
                                            "id_pesanan"
                                        ] ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if ($data["no_hp"]): ?>
                                        <a href="https://wa.me/<?= $data[
                                            "no_hp"
                                        ] ?>" target="_blank" class="btn btn-sm btn-outline-success fw-bold px-3 py-1">
                                            <i class="fa-brands fa-whatsapp me-1"></i> <?= $data[
                                                "no_hp"
                                            ] ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center fw-bold"><?= $data[
                                    "jumlah"
                                ] ?></td>
                                <td class="fw-bold text-end text-success fs-6">
                                    Rp <?= number_format(
                                        $total_bayaran,
                                        0,
                                        ",",
                                        ".",
                                    ) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($data["status"] == "Pending"): ?>
                                        <span class="status-badge-pending small">Pending</span>
                                    <?php elseif (
                                        $data["status"] == "Diterima"
                                    ): ?>
                                        <span class="status-badge-diterima small">Diterima</span>
                                    <?php else: ?>
                                        <span class="status-badge-diantar small">Diantar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Tombol Detail -->
                                        <button type="button" class="btn btn-custom-action btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </button>

                                        <!-- Alur Tombol Berdasarkan Status -->
                                        <?php if (
                                            $data["status"] == "Pending"
                                        ): ?>
                                            <!-- Jika pending, tombol "Terima" muncul untuk memvalidasi pesanan -->
                                            <a href="konfirmasi_proses.php?id=<?= $data[
                                                "id_pesanan"
                                            ] ?>&status=Diterima" 
                                               class="btn btn-custom-action btn-success shadow-sm btn-action-terima">
                                                 <i class="fa-solid fa-check"></i> Terima
                                            </a>
                                        <?php elseif (
                                            $data["status"] == "Diterima"
                                        ): ?>
                                            <!-- Jika sudah diterima, maka tombol "Diantar" muncul di sebelah tombol detail -->
                                            <a href="konfirmasi_proses.php?id=<?= $data[
                                                "id_pesanan"
                                            ] ?>&status=Diantar" 
                                               class="btn btn-custom-action btn-warning text-dark fw-bold shadow-sm btn-action-diantar">
                                                 <i class="fa-solid fa-truck"></i> Diantar
                                            </a>
                                        <?php endif; ?>

                                        <!-- Tombol Hapus -->
                                        <a href="hapus_pesanan.php?id=<?= $data[
                                            "id_pesanan"
                                        ] ?>" 
                                           class="btn btn-custom-action btn-danger shadow-sm btn-action-hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Detail Rincian Faktur -->
                                    <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                                                <div class="modal-header modal-header-custom">
                                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-receipt me-2"></i>Rincian Faktur #<?= $data[
                                                        "id_pesanan"
                                                    ] ?></h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row g-4">
                                                        
                                                        <div class="col-md-7">
                                                            <div class="section-divider"><i class="fa-solid fa-user-tag me-2"></i>Data Pelanggan & Produk</div>
                                                            <table class="table table-sm table-striped table-bordered mb-4">
                                                                <tr><td class="bg-light fw-bold" style="width: 35%;">Nama Produk</td><td><?= $data[
                                                                    "nama_produk"
                                                                ] ?> (<?= $data[
     "ukuran"
 ] ?>)</td></tr>
                                                                <tr><td class="bg-light fw-bold">Harga Satuan</td><td>Rp <?= number_format(
                                                                    $data[
                                                                        "harga_satuan"
                                                                    ],
                                                                    0,
                                                                    ",",
                                                                    ".",
                                                                ) ?></td></tr>
                                                                <tr><td class="bg-light fw-bold">Jumlah Order</td><td><?= $data[
                                                                    "jumlah"
                                                                ] ?> Pcs</td></tr>
                                                                <tr><td class="bg-light fw-bold">No. Kontak</td><td><?= $data[
                                                                    "no_hp"
                                                                ] ?:
                                                                    "-" ?></td></tr>
                                                                <tr><td class="bg-light fw-bold">Sistem Bayar</td><td><span class="badge bg-dark"><?= $data[
                                                                    "metode_pembayaran"
                                                                ] ?></span></td></tr>
                                                            </table>

                                                            <div class="section-divider"><i class="fa-solid fa-map-location-dot me-2"></i>Informasi Logistik</div>
                                                            <table class="table table-sm table-striped table-bordered">
                                                                <tr><td class="bg-light fw-bold" style="width: 35%;">Kurir/Kirim</td><td><?= $data[
                                                                    "metode_pengiriman"
                                                                ] ?></td></tr>
                                                                <tr><td class="bg-light fw-bold">Provinsi</td><td><?= $data[
                                                                    "provinsi"
                                                                ] ?:
                                                                    "-" ?></td></tr>
                                                                <tr><td class="bg-light fw-bold">Kabupaten</td><td><?= $data[
                                                                    "kabupaten"
                                                                ] ?:
                                                                    "-" ?></td></tr>
                                                                <tr><td class="bg-light fw-bold">Alamat Tujuan</td><td><?= $data[
                                                                    "alamat_lengkap"
                                                                ] ?:
                                                                    "Ambil Sendiri di Toko" ?></td></tr>
                                                                <tr><td class="bg-light fw-bold">Nilai Ongkir</td><td class="fw-bold text-danger">Rp <?= number_format(
                                                                    $data[
                                                                        "biaya_ongkir"
                                                                    ],
                                                                    0,
                                                                    ",",
                                                                    ".",
                                                                ) ?></td></tr>
                                                            </table>
                                                        </div>
                                                        
                                                        <div class="col-md-5 text-center border-start">
                                                            <div class="section-divider text-start"><i class="fa-solid fa-camera me-2"></i>Lampiran Bukti</div>
                                                            <?php if (
                                                                $data[
                                                                    "bukti_pembayaran"
                                                                ]
                                                            ): ?>
                                                                <div class="mb-3">
                                                                    <img src="../uploads/<?= $data[
                                                                        "bukti_pembayaran"
                                                                    ] ?>" class="img-fluid img-bukti shadow-sm" alt="Bukti Transfer">
                                                                </div>
                                                                <a href="../uploads/<?= $data[
                                                                    "bukti_pembayaran"
                                                                ] ?>" target="_blank" class="btn btn-sm btn-dark w-100 py-2">
                                                                    <i class="fa-solid fa-expand me-1"></i> Perbesar Gambar
                                                                </a>
                                                            <?php else: ?>
                                                                <div class="py-5 my-2 text-muted bg-light border rounded">
                                                                    <i class="fa-solid fa-hand-holding-dollar fa-3x mb-2 text-secondary"></i><br>
                                                                    <span class="fw-bold text-uppercase small">Transaksi Tunai / COD</span>
                                                                </div>
                                                            <?php endif; ?>
                                                            
                                                            <div class="mt-4 p-3 bg-dark text-white rounded text-start shadow-inner">
                                                                <small class="text-white-50 d-block mb-1">Tanggal & Waktu Masuk:</small>
                                                                <span class="fw-bold"><i class="fa-regular fa-calendar-check me-2 text-warning"></i><?= $data[
                                                                    "waktu_transaksi"
                                                                ] ?></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">Tutup Jendela</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            endwhile;
                        else:
                             ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted fw-bold">
                                    <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 text-warning"></i><br>
                                    Data transaksi penjualan masih kosong.
                                </td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. POP UP KONFIRMASI TERIMA PESANAN (PENDING -> DITERIMA)
            const terimaButtons = document.querySelectorAll('.btn-action-terima');
            terimaButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Terima Pesanan? 🦆',
                        text: "Pastikan dana pembayaran sudah masuk (jika transfer) dan berkas valid.",
                        icon: 'question',
                        iconColor: '#ff9f43',
                        showCancelButton: true,
                        confirmButtonColor: '#155724',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Terima!',
                        cancelButtonText: 'Batal',
                        background: '#ffffff',
                        backdrop: `rgba(0, 31, 63, 0.3)`,
                        customClass: {
                            popup: 'admin-swal-popup',
                            title: 'admin-swal-title',
                            htmlContainer: 'admin-swal-text',
                            confirmButton: 'admin-swal-btn btn btn-success me-2',
                            cancelButton: 'admin-swal-btn btn btn-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = targetUrl;
                        }
                    });
                });
            });

            // 2. POP UP KONFIRMASI DIANTAR (DITERIMA -> DIANTAR)
            const diantarButtons = document.querySelectorAll('.btn-action-diantar');
            diantarButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Kirim/Antar Pesanan? 🚚',
                        text: "Status pesanan akan diubah menjadi 'Diantar'. Pastikan kurir siap bergerak.",
                        icon: 'info',
                        iconColor: '#ff9f43',
                        showCancelButton: true,
                        confirmButtonColor: '#ff9f43',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Kirim Sekarang!',
                        cancelButtonText: 'Batal',
                        background: '#ffffff',
                        backdrop: `rgba(0, 31, 63, 0.3)`,
                        customClass: {
                            popup: 'admin-swal-popup',
                            title: 'admin-swal-title',
                            htmlContainer: 'admin-swal-text',
                            confirmButton: 'admin-swal-btn btn btn-warning text-dark me-2',
                            cancelButton: 'admin-swal-btn btn btn-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = targetUrl;
                        }
                    });
                });
            });

            // 3. POP UP KONFIRMASI HAPUS PESANAN
            const hapusButtons = document.querySelectorAll('.btn-action-hapus');
            hapusButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Hapus Data Pesanan? ⚠️',
                        text: "Tindakan ini permanen. Data pesanan yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        iconColor: '#dc3545',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        background: '#ffffff',
                        backdrop: `rgba(220, 53, 69, 0.15)`,
                        customClass: {
                            popup: 'admin-swal-popup',
                            title: 'admin-swal-title',
                            htmlContainer: 'admin-swal-text',
                            confirmButton: 'admin-swal-btn btn btn-danger me-2',
                            cancelButton: 'admin-swal-btn btn btn-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = targetUrl;
                        }
                    });
                });
            });

        });
    </script>
</body>
</html>