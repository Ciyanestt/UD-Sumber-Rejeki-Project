<?php 
session_start();
include "koneksiDB/koneksi.php"; 

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. Sumber Rejeki - Produk Kami</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Integrasi Bootstrap Icons dan Google Fonts Premium -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-orange: #ff9f43;
            --dark-navy: #2c3e50;
            --soft-bg: #f8f9fa;
            --muted-gray: #6c757d;
        }

        body { 
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif; 
            background-color: #f4f6f9; 
            color: var(--dark-navy);
        }

        .watermark-bg {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 45%;
            max-width: 450px;
            opacity: 0.04; 
            z-index: 0;   
            pointer-events: none;
        }

        /* Hero Section Professional & Estetis */
        .hero-section {
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            color: white;
            padding: 70px 20px;
            text-align: center;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .hero-section h1 {
            font-weight: 800;
            font-size: 2.8rem;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .hero-section h1 span {
            color: var(--primary-orange);
        }

        .hero-section p {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.75);
            max-width: 600px;
            margin: 0 auto;
        }

        .main-content {
            position: relative;
            padding: 50px 0;
            background-color: transparent; 
            z-index: 2;
        }

        /* Kontainer Tombol Admin di Tengah (Statis / Tidak Ikut Scroll) */
        .admin-middle-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 40px; /* Jarak aman sebelum list produk */
        }

        /* Desain Kartu Produk Layaknya Marketplace Professional */
        .product-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(44, 62, 80, 0.04);
            border: none;
            width: 100%; 
            max-width: 350px;
            margin: 0 auto;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover { 
            transform: translateY(-10px);
            box-shadow: 0 20px 35px rgba(44, 62, 80, 0.1);
        }

        /* Wrapper Gambar Proporsional dengan Efek Zoom */
        .product-img-container {
            position: relative;
            width: 100%;
            padding-top: 80%; 
            overflow: hidden;
            background-color: #f8f9fa;
        }
        
        .product-img { 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .product-card:hover .product-img {
            transform: scale(1.06);
        }

        /* Badge Stok Habis Modern */
        .stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .stock-overlay .badge {
            font-size: 0.85rem;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        /* Area Informasi Konten */
        .product-info { 
            padding: 24px; 
            text-align: left; 
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-info h3 { 
            font-size: 1.2rem; 
            font-weight: 700; 
            margin-bottom: 8px; 
            color: var(--dark-navy); 
            line-height: 1.4;
        }
        
        .product-info p { 
            font-size: 0.85rem; 
            color: var(--muted-gray); 
            line-height: 1.6; 
            margin-bottom: 20px; 
            min-height: 60px; 
            font-weight: 400;
        }

        /* Tombol Aksi */
        .btn-pesan {
            background-color: var(--primary-orange);
            color: white !important;
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 159, 67, 0.2);
            text-transform: none;
            margin-top: auto; 
        }

        .btn-pesan:hover {
            background-color: #f38f31;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 159, 67, 0.35);
        }

        .btn-disabled-custom {
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            background-color: #e2e8f0 !important;
            color: #94a3b8 !important;
            border: none;
            margin-top: auto;
        }

        /* Desain Tombol Admin Dalam Kartu */
        .admin-box {
            border-top: 1px dashed #e2e8f0;
            margin-top: 15px;
            padding-top: 15px;
        }

        .btn-admin-edit {
            border: 1.5px solid #3498db;
            color: #3498db;
            background: transparent;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-admin-edit:hover {
            background: #3498db;
            color: white;
        }

        .btn-admin-delete {
            border: 1.5px solid #e74c3c;
            color: #e74c3c;
            background: transparent;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-admin-delete:hover {
            background: #e74c3c;
            color: white;
        }

        /* Tombol Tambah Daftar Produk */
        .btn-rekap {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white !important;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 15px 35px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 10px 25px rgba(46, 204, 113, 0.25);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-rekap:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(46, 204, 113, 0.35);
        }
    </style>
</head>
<body>
    <img src="pictures/logo.png" class="watermark-bg" />
    
    <?php include "include/header.php"; ?>
    
    <div class="hero-section">
        <h1>PRODUK <span>KAMI</span></h1>
        <p>Produk bebek segar dan alami dari peternakan unggas kami langsung ke meja Anda.</p>
    </div>

    <div class="main-content">
        <div class="container">
            
            <!-- TOMBOL TAMBAH PRODUK ADMIN: Tepat berada di atas list produk & statis di tengah -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <div class="admin-middle-container">
                    <a href="aksesAdmin/input_produk.php" class="text-decoration-none">
                        <button class="btn-rekap">
                            <i class="bi bi-plus-circle-fill fs-5"></i> Tambah Produk
                        </button>
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Grid System List Produk -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center mb-5">
                <?php
                $query = "SELECT * FROM produk ORDER BY id_produk DESC";
                $result = mysqli_query($conn, $query);

                while ($p = mysqli_fetch_assoc($result)): ?>
                <div class="col d-flex justify-content-center">
                    <div class="product-card">
                        
                        <div class="product-img-container">
                            <img src="<?= htmlspecialchars($p["foto_produk"]) ?>" class="product-img" alt="<?= htmlspecialchars($p["nama_produk"]) ?>">
                            
                            <!-- LOGIKA STOK HABIS -->
                            <?php if ($p["stok_tersedia"] == "habis"): ?>
                                <div class="stock-overlay">
                                    <span class="badge bg-danger"><i class="bi bi-exclamation-circle-fill me-1"></i> STOK HABIS</span>
                                </div>
                            <?php endif; ?>
                        </div>  
                        
                        <div class="product-info">
                            <h3><?= htmlspecialchars($p["nama_produk"]) ?></h3>
                            <p><?= htmlspecialchars($p["deskripsi"]) ?></p>
                            
                            <!-- LOGIKA STOK HABIS & HAK AKSES PESAN -->
                            <?php if ($p["stok_tersedia"] == "tersedia"): ?>
                                
                                <?php if (isset($_SESSION["role"])): ?>
                                    <a href="pemesanan/produk_pesanan.php?id=<?= $p["id_produk"] ?>" class="btn-pesan text-decoration-none d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-cart-plus-fill"></i> Pesan Disini
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn-pesan text-decoration-none d-flex align-items-center justify-content-center gap-2" onclick="alert('Silakan login terlebih dahulu untuk melakukan pemesanan!');">
                                        <i class="bi bi-cart-plus-fill"></i> Pesan Disini
                                    </a>
                                <?php endif; ?>

                            <?php else: ?>
                                <button class="btn-disabled-custom w-100 d-flex align-items-center justify-content-center gap-2" disabled>
                                    <i class="bi bi-x-circle-fill"></i> Stok Habis
                                </button>
                            <?php endif; ?>

                            <!-- HAK AKSES TOMBOL EDIT & HAPUS (KHUSUS ADMIN) -->
                            <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
                            <div class="admin-box row gx-2">
                                <div class="col-6">
                                    <a href="aksesAdmin/edit_product.php?id=<?= $p["id_produk"] ?>" class="btn btn-sm btn-admin-edit w-100 text-decoration-none d-flex align-items-center justify-content-center gap-1 py-2">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="aksesAdmin/hapus_product.php?id=<?= $p["id_produk"] ?>" class="btn btn-sm btn-admin-delete w-100 text-decoration-none d-flex align-items-center justify-content-center gap-1 py-2" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
              
        </div>
    </div>

    <?php include "include/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>