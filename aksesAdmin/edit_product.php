<?php
session_start();
require_once __DIR__ . "/../koneksiDB/koneksi.php";

// Proteksi Halaman Admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// 1. Ambil ID dari URL
$id_produk = isset($_GET["id"]) ? mysqli_real_escape_string($conn, $_GET["id"]) : "";

// 2. Tarik data lama dari database
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
$data = mysqli_fetch_assoc($query);

// Include SweetAlert2 untuk notifikasi yang modern
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<style>
    .swal2-popup { font-family: 'Montserrat', sans-serif !important; border-radius: 20px !important; }
    .swal2-confirm { background: linear-gradient(135deg, #0a1d37 0%, #16325c 100%) !important; }
</style>";

if (!$data) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Data Tidak Ditemukan!',
                text: 'Mengarahkan kembali ke halaman produk...',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => { window.location='../product.php'; });
        });
    </script>";
    exit();
}

// 3. Proses Update Data saat Tombol Di-klik
if (isset($_POST["update"])) {
    $nama_produk = mysqli_real_escape_string($conn, $_POST["nama_produk"]);
    $deskripsi = mysqli_real_escape_string($conn, $_POST["deskripsi"]);
    $stok_tersedia = mysqli_real_escape_string($conn, $_POST["stok_tersedia"]);
    $foto_lama = $_POST["foto_lama"]; // Berisi path bersih dari database (ex: pictures/nama.jpg)

    // Logika penggabungan variasi berat dan harga
    $list_berat = $_POST['berat_input'];
    $list_harga = $_POST['harga_input'];
    $variasi_final = [];

    for ($i = 0; $i < count($list_berat); $i++) {
        if (!empty($list_berat[$i]) && !empty($list_harga[$i])) {
            $variasi_final[] = mysqli_real_escape_string($conn, $list_berat[$i]) . "(" . mysqli_real_escape_string($conn, $list_harga[$i]) . ")";
        }
    }
    $berat_produk_string = implode(", ", $variasi_final);

    // --- PERBAIKAN LOGIKA UPLOAD FOTO BARU ---
    if ($_FILES["foto_produk"]["name"] != "") {
        $ekstensi = strtolower(pathinfo($_FILES["foto_produk"]["name"], PATHINFO_EXTENSION));
        $nama_file_baru = time() . "_" . uniqid() . "." . $ekstensi;
        
        $target_dir = "../pictures/"; // Path fisik untuk upload keluar folder aksesAdmin
        $target_file = $target_dir . $nama_file_baru;
        
        // PATH BERSIH INI YANG DISIMPAN KE DATABASE (Agar bisa diakses langsung dari product.php di root)
        $foto_final = "pictures/" . $nama_file_baru;

        if (move_uploaded_file($_FILES["foto_produk"]["tmp_name"], $target_file)) {
            
            // Perbaikan Logika Unlink: Tambahkan "../" di depan $foto_lama agar sistem bisa melacak file fisik dari dalam aksesAdmin
            $path_fisik_foto_lama = "../" . $foto_lama;
            
            if (file_exists($path_fisik_foto_lama) && !empty($foto_lama) && $foto_lama != "pictures/default.png") {
                unlink($path_fisik_foto_lama);
            }
        } else {
            // Jika gagal upload file fisik, kembalikan ke foto lama agar data tidak kosong
            $foto_final = $foto_lama;
        }
    } else {
        $foto_final = $foto_lama;
    }

    // Query Update ke Database
    $update = mysqli_query($conn, "UPDATE produk SET 
        nama_produk = '$nama_produk',
        deskripsi = '$deskripsi',
        berat_produk = '$berat_produk_string',
        stok_tersedia = '$stok_tersedia', 
        foto_produk = '$foto_final'
        WHERE id_produk = '$id_produk'");

    if ($update) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil Diperbarui!',
                    text: 'Data komoditas produk telah disimpan.',
                    icon: 'success',
                    confirmButtonText: 'Mantap'
                }).then(() => { window.location='../product.php'; });
            });
        </script>";
        exit();
    } else {
        $error_msg = addslashes(mysqli_error($conn));
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal Update!',
                    text: 'Error: $error_msg',
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - UD. Sumber Rejeki</title>
    <link rel="icon" type="image/x-icon" href="../pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-glow: #ff9f1c;
            --navy-deep: #0a1d37;
            --navy-gradient: linear-gradient(135deg, #0a1d37 0%, #16325c 100%);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .main-header-panel {
            background: var(--navy-gradient);
            color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(10, 29, 55, 0.1);
            border-bottom: 4px solid var(--primary-glow);
        }
        
        .admin-badge {
            background-color: #fdf6e2;
            color: var(--navy-deep);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .data-card {
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(10, 29, 55, 0.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.03);
        }

        .section-divider {
            color: var(--navy-deep);
            font-weight: 800;
            font-size: 1.1rem;
            border-bottom: 2.5px solid var(--navy-deep);
            padding-bottom: 8px;
            margin-bottom: 25px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            color: var(--navy-deep);
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 18px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-glow);
            box-shadow: 0 0 0 4px rgba(255, 159, 28, 0.15);
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--navy-deep);
            font-weight: 700;
        }

        .variasi-item .form-control {
            border-radius: 12px;
        }

        .variasi-item .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .img-preview {
            max-height: 120px;
            width: auto;
            object-fit: contain;
            border: 2px dashed var(--navy-deep);
            border-radius: 14px;
            padding: 6px;
            background: #fff;
        }

        .btn-custom {
            border-radius: 12px;
            font-weight: 700;
            padding: 12px 28px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-tambah {
            color: var(--navy-deep);
            border: 2px solid var(--navy-deep);
            background: transparent;
            font-weight: 700;
            border-radius: 10px;
        }
        .btn-tambah:hover { 
            background: var(--navy-deep); 
            color: white; 
        }

        .btn-hapus-variasi {
            background-color: #fee2e2;
            color: #ef4444;
            border: none;
            border-radius: 10px;
            padding: 10px;
            transition: all 0.2s;
        }
        .btn-hapus-variasi:hover { 
            background-color: #ef4444; 
            color: white; 
        }

        .btn-batal {
            background-color: #e2e8f0;
            color: #475569;
        }
        .btn-batal:hover { 
            background-color: #cbd5e1; 
        }

        .btn-update {
            background: linear-gradient(135deg, var(--primary-glow) 0%, #ff8c00 100%);
            color: var(--navy-deep);
            border: none;
            box-shadow: 0 5px 15px rgba(255, 159, 28, 0.3);
        }
        .btn-update:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(255, 159, 28, 0.45);
            color: var(--navy-deep);
        }
    </style>
</head>
<body>

   <?php include "../include/header.php"; ?>

    <div class="container p-4 p-md-5 my-4">
        
        <div class="main-header-panel p-4 mb-5 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 shadow-sm">
            <div>
                <h3 class="fw-bold m-0"><i class="fa-solid fa-pen-to-square me-2"></i>Modifikasi Inventaris Produk</h3>
                <p class="m-0 text-white-50 small mt-1">UD. SUMBER REJEKI — Halaman Manajemen Konten</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="admin-badge"><i class="fa-solid fa-user-tie me-1"></i> Otoritas Admin</span>
                <a href="../product.php" class="btn btn-light fw-bold text-dark btn-sm rounded-3 px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-11">
                <div class="card data-card p-4 p-md-5">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($data["foto_produk"]) ?>">

                        <div class="section-divider"><i class="fa-solid fa-tag"></i> Identitas Utama Produk</div>
                        
                        <div class="mb-4">
                            <label class="form-label">Nama Komoditas Produk</label>
                            <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($data["nama_produk"]) ?>" required placeholder="Contoh: Bebek Karkas Super">
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Deskripsi & Keunggulan Produk</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Jelaskan detail produk, kualitas potongan, higienitas..."><?= htmlspecialchars($data["deskripsi"]) ?></textarea>
                        </div>

                        <div class="section-divider"><i class="fa-solid fa-boxes-stacked"></i> Variasi, Harga & Manajemen Stok</div>

                        <div class="mb-4">
                            <label class="form-label d-block">Daftar Variasi Ukuran / Berat & Harga</label>
                            <div id="container-variasi">
                                <?php 
                                $variasi_raw = explode(", ", $data["berat_produk"]);
                                foreach ($variasi_raw as $v): 
                                    preg_match('/(.*)\((.*)\)/', $v, $match);
                                    $berat_val = isset($match[1]) ? $match[1] : "";
                                    $harga_val = isset($match[2]) ? $match[2] : "";
                                if(empty($berat_val) && empty($harga_val)) continue;
                                ?>
                                <div class="row g-2 mb-2 variasi-item align-items-center">
                                    <div class="col-5">
                                        <input type="text" name="berat_input[]" class="form-control form-control-sm" placeholder="Berat (ex: 1kg atau 1 Ekor)" value="<?= htmlspecialchars($berat_val) ?>" required>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="harga_input[]" class="form-control" placeholder="Harga tanpa titik (ex: 85000)" value="<?= htmlspecialchars($harga_val) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <button type="button" class="btn-hapus-variasi" title="Hapus Baris Variasi"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="btn-tambah-variasi" class="btn btn-tambah btn-sm mt-2">
                                <i class="fa-solid fa-plus-circle me-1"></i> Tambah Variasi Baru
                            </button>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Status Ketersediaan Sistem</label>
                                <select name="stok_tersedia" class="form-select" required>
                                    <option value="tersedia" <?= $data["stok_tersedia"] == "tersedia" ? "selected" : "" ?>>Tersedia (Ready Stock)</option>
                                    <option value="habis" <?= $data["stok_tersedia"] == "habis" ? "selected" : "" ?>>Habis (Sedang Kosong)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Visual Gambar Saat Ini</label>
                                <div class="d-flex align-items-center gap-3 p-3 border rounded-4 bg-light">
                                    <img src="../<?= htmlspecialchars($data["foto_produk"]) ?>" class="img-preview shadow-sm" alt="Foto Aktif">
                                    <small class="text-muted" style="font-size: 0.8rem; line-height: 1.4;"><i class="fa-solid fa-arrow-left me-1"></i> File banner aktif yang tampil pada katalog pembeli.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Perbarui Gambar Komoditas</label>
                            <input type="file" name="foto_produk" class="form-control" accept="image/*">
                            <small class="text-danger d-block mt-2 fw-semibold" style="font-size: 0.8rem;">* Biarkan kosong jika Anda tidak berencana mengganti gambar utama saat ini.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <a href="/project%20itik%202/product.php" class="btn btn-custom btn-batal text-decoration-none d-flex align-items-center">Batalkan</a>
                            <button type="submit" name="update" class="btn btn-custom btn-update"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("container-variasi");
            const btnTambah = document.getElementById("btn-tambah-variasi");

            btnTambah.addEventListener("click", function() {
                const itemBaru = document.createElement("div");
                itemBaru.className = "row g-2 mb-2 variasi-item align-items-center";
                itemBaru.innerHTML = `
                    <div class="col-5">
                        <input type="text" name="berat_input[]" class="form-control form-control-sm" placeholder="Berat (ex: 1kg)" required>
                    </div>
                    <div class="col-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_input[]" class="form-control" placeholder="Harga (ex: 80000)" required>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn-hapus-variasi" title="Hapus Baris Variasi"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                `;
                container.appendChild(itemBaru);
            });

            container.addEventListener("click", function(e) {
                if (e.target.closest(".btn-hapus-variasi")) {
                    const baris = e.target.closest(".variasi-item");
                    if (container.querySelectorAll(".variasi-item").length > 1) {
                        baris.remove();
                    } else {
                        alert("Minimal harus menetapkan 1 jenis variasi produk!");
                    }
                }
            });
        });
    </script>
</body>
</html>