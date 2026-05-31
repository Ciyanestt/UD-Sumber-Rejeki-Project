<?php
session_start();
include "koneksiDB/koneksi.php";
// Jika yang mengakses index.php adalah admin yang sudah login, alihkan langsung ke product.php
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: product.php");
    exit();
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UD. Sumber Rejeki - Home Premium</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* --- GLOBAL STYLES --- */
        :root {
            --primary-orange: #ff9f1c;
            --dark-orange: #eeb252;
            --navy-dark: #0a1d37;
            --cream-light: #fdf3d1;
            --bg-clean: #fafafa;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-clean);
            color: #333;
            overflow-x: hidden;
            position: relative;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 900;
            color: var(--navy-dark);
            letter-spacing: -1px;
        }

        /* Teks dekoratif vertikal di pinggir halaman */
        .side-text-deco {
            position: fixed;
            top: 50%;
            right: -60px;
            transform: translateY(-50%) rotate(90deg);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: rgba(10, 29, 55, 0.1);
            z-index: 10;
            pointer-events: none;
        }

        /* --- WATERMARK (Low Opacity) --- */
        .watermark-bg {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 35%;
            max-width: 350px;
            opacity: 0.03; 
            z-index: -1;
            pointer-events: none;
        }

        /* --- UTILITIES --- */
        .rounded-premium { border-radius: 50px; }
        .shadow-premium { box-shadow: 0 20px 60px rgba(10, 29, 55, 0.08); }
        .text-orange { color: var(--primary-orange); }
        .text-navy { color: var(--navy-dark); }

        /* --- HERO SECTION (Creative Split Asymmetrical) --- */
        .hero-section {
            background-color: var(--bg-clean);
            position: relative;
            padding: 0; 
            overflow: hidden;
            display: flex;
            align-items: center;
            min-height: 100vh; /* Memastikan hero setinggi layar */
        }

        /* Elemen oranye dekoratif di belakang */
        .hero-shape-deco {
            position: absolute;
            top: 0;
            right: 0;
            width: 45%;
            height: 100%;
            background-color: var(--dark-orange);
            border-bottom-left-radius: 200px;
            z-index: 1;
        }

        .hero-text-big {
            font-size: 4.2rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .hero-lead {
            font-size: 1.3rem;
            font-weight: 500;
            color: rgba(10, 29, 55, 0.8);
            max-width: 550px;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        .hero-image-wrapper {
            position: absolute; 
            top: 0;
            right: 0;
            width: 45%; 
            height: 100%;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end; 
            padding: 0; 
        }
        
        .hero-main-image {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            border-radius: 0; 
            border-bottom-left-radius: 200px;
            border: none;
            box-shadow: -10px 25px 55px rgba(0, 0, 0, 0.1); 
            transform: none; 
        }

        /* Kontainer teks hero perlu disesuaikan paddingnya karena hero-section padding 0 */
        .hero-section .container {
            padding-top: 120px;
            padding-bottom: 120px;
        }

        /* --- BUTTONS (Rounded & Bouncy) --- */
        .btn-premium {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 16px 36px;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 0.85rem;
            border: none;
        }

        .btn-premium-dark {
            background-color: var(--navy-dark);
            color: var(--cream-light);
            box-shadow: 0 10px 30px rgba(10, 29, 55, 0.2);
        }

        .btn-premium-dark:hover {
            background-color: #1a3a63;
            color: #fff;
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 15px 40px rgba(10, 29, 55, 0.3);
        }

        .btn-premium-orange {
            background-color: var(--primary-orange);
            color: var(--navy-dark);
            box-shadow: 0 10px 30px rgba(255, 159, 28, 0.25);
        }

        .btn-premium-orange:hover {
            background-color: var(--dark-orange);
            color: #fff;
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 15px 40px rgba(255, 159, 28, 0.4);
        }

        /* --- SECTION TITLES (Creative Alignment) --- */
        .section-title-wrapper {
            margin-bottom: 4rem;
            position: relative;
        }

        .section-title-main {
            font-size: 3rem;
            text-transform: uppercase;
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 10px;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #777;
            font-weight: 500;
            max-width: 600px;
        }
        
        /* Garis aksen oranye vertikal di judul section */
        .title-accent-line {
            width: 8px;
            height: 60px;
            background-color: var(--primary-orange);
            position: absolute;
            left: -25px;
            top: 5px;
            border-radius: 4px;
        }

        /* --- CORE VALUES --- */
        .value-card {
            background-color: #fff;
            padding: 40px;
            border-radius: 40px;
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .value-card:hover {
            background-color: var(--navy-dark);
            transform: translateY(-10px);
        }
        .value-card:hover .value-icon,
        .value-card:hover h4,
        .value-card:hover p {
            color: #fff;
        }
        .value-icon {
            font-size: 3rem;
            color: var(--primary-orange);
            margin-bottom: 20px;
            transition: 0.3s;
        }

        /* --- PRODUCT SHOWCASE (Asymmetrical Grid) --- */
        .product-section {
            background-color: var(--cream-light);
            padding: 100px 0;
            border-radius: 80px;
            position: relative;
            z-index: 2;
        }

        /* UPDATE PERBAIKAN: Ditambahkan Flexbox agar tinggi kotak sama persis */
        .product-card-premium {
            background-color: #fff;
            border-radius: 50px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            border: none;
            display: flex;
            flex-direction: column;
        }

        .product-card-premium:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 30px 70px rgba(238, 178, 82, 0.2);
        }

        .product-card-offset {
            margin-top: 60px;
        }

        .product-img-wrapper {
            height: 300px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0; /* Mencegah gambar menyusut/terdistorsi */
        }
        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .product-card-premium:hover .product-img-wrapper img {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 25px;
            right: 25px;
            background-color: var(--primary-orange);
            color: var(--navy-dark);
            font-weight: 800;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.8rem;
            text-transform: uppercase;
            z-index: 3;
        }

        /* UPDATE PERBAIKAN: Ditambahkan flex-grow agar otomatis mengisi ruang kosong */
        .product-body-premium {
            padding: 35px 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* --- CONTACT SECTION --- */
        .contact-section {
            background-color: var(--bg-clean);
            position: relative;
            padding: 100px 0 150px 0;
            margin-top: -60px;
            z-index: 1;
        }

        .contact-grid-wrapper {
            background-color: var(--navy-dark);
            border-radius: 60px;
            padding: 80px 60px;
            position: relative;
            overflow: hidden;
        }
        
        .contact-glow-deco {
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: var(--primary-orange);
            border-radius: 50%;
            filter: blur(150px);
            opacity: 0.2;
            z-index: 0;
        }

        .contact-card-premium {
            background-color: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 40px;
            padding: 40px;
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .contact-card-premium:hover {
            background-color: rgba(255,255,255,0.08);
            transform: translateY(-10px) scale(1.02);
            border-color: var(--primary-orange);
        }

        .contact-icon-wrapper {
            width: 80px;
            height: 80px;
            background-color: rgba(255, 159, 28, 0.1);
            color: var(--primary-orange);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 30px;
            transition: 0.3s;
        }
        .contact-card-premium:hover .contact-icon-wrapper {
            background-color: var(--primary-orange);
            color: var(--navy-dark);
            transform: scale(1.1);
        }

        .contact-title-card {
            color: var(--primary-orange);
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 15px;
        }

        .contact-text-card {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #b0bec5;
            font-weight: 400;
        }

        /* --- MITRA SECTION --- */
        .mitra-section {
            background-color: var(--primary-orange);
            background-image: linear-gradient(160deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            padding: 120px 0;
            margin-top: -100px;
            position: relative;
            z-index: 2;
            border-top-left-radius: 50% 20%;
            border-top-right-radius: 50% 20%;
            box-shadow: 0 -20px 50px rgba(0,0,0,0.05);
        }

        /* --- RESPONSIVE FIXES --- */
        @media (max-width: 991px) {
            .hero-section { min-height: auto; padding-top: 100px; } 
            .hero-section .container { padding-top: 60px; padding-bottom: 60px; }
            .hero-text-big { font-size: 3rem; }
            .hero-shape-deco { width: 100%; border-radius: 0; opacity: 0.1; }
            
            .hero-image-wrapper { 
                position: relative; 
                width: 100%; 
                height: auto; 
                margin-top: 50px; 
                justify-content: center;
                padding: 0 15px; 
            }
            .hero-main-image { 
                width: 100%; 
                max-width: 480px; 
                height: auto; 
                border-radius: 40px; 
                border: 16px solid var(--primary-orange);
                object-fit: contain;
            } 
            
            .product-card-offset { margin-top: 0; }
            .section-title-main { font-size: 2.2rem; }
            .contact-grid-wrapper { padding: 50px 30px; }
        }
        @media (max-width: 768px) {
            .hero-text-big { font-size: 2.5rem; }
            .side-text-deco { display: none; }
            .btn-premium { padding: 12px 28px; font-size: 0.8rem; }
            .product-section, .mitra-section, .contact-section { border-radius: 40px; padding: 60px 0; }
            .mitra-section { border-top-left-radius: 40px; border-top-right-radius: 40px; }
            .hero-main-image { border-width: 10px; border-radius: 30px; } 
        }
    </style>
</head>
<body>

    <div class="side-text-deco">UD. Sumber Rejeki ★ Premium Quality ★ EST. 2023</div>

    <img src="pictures/logo.png" class="watermark-bg" alt="Watermark Logo" />
    
    <?php include "include/header.php"; ?>

    <header class="hero-section">
        <div class="hero-shape-deco"></div> 
        <div class="container relative z-2">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 col-md-12 text-lg-start text-center" data-aos="fade-right" data-aos-duration="1000">
                    <span class="text-orange fw-bold text-uppercase letter-spacing-2 mb-2 d-block">Premium Duck Distributor</span>
                    <h1 class="hero-text-big text-navy">
                        Kualitas <span class="text-orange">Unggul</span>, Rejeki <span class="text-orange">Lancar</span>.
                    </h1>
                    <p class="hero-lead">
                        Penyedia utama produk bebek segar, higienis, dan alami langsung dari peternakan terbaik untuk kebutuhan meja makan dan bisnis kuliner Anda.
                    </p>
                    
                    <div class="d-flex justify-content-lg-start justify-content-center gap-3 flex-wrap mt-5">
                        <a href="product.php" class="btn-premium btn-premium-dark shadow-premium" style="text-decoration: none;">
                            Eksplor Produk <i class="bi bi-bag ms-2"></i>
                        </a>
                        <a href="mitra.php" class="btn-premium btn-premium-orange shadow-premium" style="text-decoration: none;">
                            Gabung Mitra <i class="bi bi-handshake ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 d-lg-block d-none"></div>
            </div>
        </div>
        <div class="hero-image-wrapper d-lg-flex d-none" data-aos="zoom-in-left" data-aos-duration="1200" data-aos-delay="200">
            <img src="pictures/view itik2.png" class="hero-main-image" alt="Peternakan Bebek Sumber Rejeki" />
        </div>
        <div class="container d-lg-none d-block">
            <div class="row">
                <div class="col-md-12 hero-image-wrapper" data-aos="zoom-in-up" data-aos-duration="1200" data-aos-delay="200">
                     <img src="pictures/view itik2.png" class="hero-main-image" alt="Peternakan Bebek Sumber Rejeki" />
                </div>
            </div>
        </div>
    </header>

    <section class="container py-5 my-5">
        <div class="section-title-wrapper text-center" data-aos="fade-up">
            <h2 class="section-title-main">Mengapa Memilih Kami?</h2>
            <p class="section-subtitle mx-auto">Komitmen kami pada kualitas dan layanan terbaik.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card shadow-premium">
                    <div class="value-icon"><i class="fa-solid fa-certificate"></i></div>
                    <h4>Kualitas Premium</h4>
                    <p class="text-secondary">Hanya bebek terbaik yang diproses dengan standar kontrol kualitas yang ketat.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="250">
                <div class="value-card shadow-premium">
                    <div class="value-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <h4>Alami & Higienis</h4>
                    <p class="text-secondary">Dibudidayakan secara alami, diproses secara higienis, bebas bahan pengawet berbahaya.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card shadow-premium">
                    <div class="value-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h4>Pengiriman Cepat</h4>
                    <p class="text-secondary">Layanan pengiriman yang handal untuk memastikan produk sampai dalam keadaan segar.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5 my-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 col-md-12 position-relative text-center showcase-img-wrapper" data-aos="fade-right">
                <div class="position-absolute w-100 h-100 rounded-premium" style="background: var(--cream-light); top: 30px; left: -30px; z-index: -1;"></div>
                <img src="pictures/view itik2.png" class="img-fluid w-100 rounded-premium shadow-lg" alt="Proses Pengolahan Bebek" style="border: 12px solid #fff;" />
            </div>
            <div class="col-lg-6 col-md-12 ps-lg-5" data-aos="fade-left" data-aos-delay="200">
                <div class="section-title-wrapper mb-4">
                    <div class="title-accent-line"></div>
                    <h2 class="section-title-main">Tentang UD. Sumber Rejeki</h2>
                </div>
                <p class="text-secondary mb-4" style="font-size: 1.15rem; line-height: 1.9; font-weight: 500;">
                    Kami adalah unit usaha terpercaya yang bergerak di bidang pemotongan dan penyediaan daging unggas berkualitas. UD. Sumber Rejeki didirikan dengan visi memenuhi kebutuhan pasar akan daging bebek yang segar, higienis, dan layak konsumsi, sekaligus mendukung penyerapan hasil ternak dari mitra peternak lokal.
                </p>
                <a href="aboutus.php" class="btn-premium btn-premium-orange mt-3 shadow-premium" style="text-decoration: none;">
                    Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="product-section mt-5">
    <div class="container py-5">
        <div class="section-title-wrapper text-center mb-5" data-aos="fade-up">
            <h2 class="section-title-main text-navy">Produk Utama Kami</h2>
            <div style="width: 80px; height: 5px; background-color: var(--primary-orange); margin: 15px auto 20px auto; border-radius: 3px;"></div>
            <p class="section-subtitle mx-auto text-navy">Keunggulan rasa dan kesegaran dalam setiap produk kami.</p>
        </div>

        <!-- UPDATE PERBAIKAN: Ditambahkan class align-items-stretch agar tinggi col merata -->
        <div class="row g-5 justify-content-center align-items-stretch">
            <?php
            // Mengambil 2 produk terbaru dari database seperti pada file product.php
            $query_unggulan =
                "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 2";
            $result_unggulan = mysqli_query($conn, $query_unggulan);

            if (mysqli_num_rows($result_unggulan) > 0):
                // Variabel bantuan khusus untuk efek delay AOS animasi kartu kedua
                $delay = 150;

                while ($p_unggulan = mysqli_fetch_assoc($result_unggulan)): ?>
                    
                    <div class="col-lg-5 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                        <!-- UPDATE PERBAIKAN: Menggunakan custom class h-100 tanpa menumpuk class .card default -->
                        <div class="product-card-premium h-100 w-100 shadow-premium">
                            
                            <div class="product-img-wrapper overflow-hidden" style="position: relative;">
                                <!-- Mengambil path foto_produk dari database secara dinamis -->
                                <img src="<?= htmlspecialchars(
                                    $p_unggulan["foto_produk"],
                                ) ?>" class="card-img-top" alt="<?= htmlspecialchars(
    $p_unggulan["nama_produk"],
) ?>" />
                                
                                <!-- Logika jika stok habis -->
                                <?php if (
                                    $p_unggulan["stok_tersedia"] == "habis"
                                ): ?>
                                    <div class="stock-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center;">
                                        <span class="badge bg-danger">STOK HABIS</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-body-premium">
                                <!-- Mengambil nama_produk dari database -->
                                <h4 class="card-title text-navy"><?= htmlspecialchars(
                                    $p_unggulan["nama_produk"],
                                ) ?></h4>
                                <!-- Mengambil deskripsi dari database -->
                                <p class="card-text text-secondary mt-3" style="font-weight: 500; line-height: 1.7;">
                                    <?= htmlspecialchars(
                                        $p_unggulan["deskripsi"],
                                    ) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php $delay += 150;endwhile; // Menambah delay animasi untuk kartu berikutnya
            else:
                 ?>
                <div class="col-12 text-center text-muted">
                    <p>Belum ada data produk unggulan yang tersedia.</p>
                </div>
            <?php
            endif;
            ?>
        </div>
        
        <div class="text-center mt-5 pt-4" data-aos="zoom-in">
            <a href="product.php" class="btn-premium btn-premium-dark shadow-premium" style="text-decoration: none;">
                Lihat Koleksi Lengkap <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

    <section class="contact-section mt-5">
        <div class="container py-5">
            <div class="contact-grid-wrapper shadow-premium">
                <div class="contact-glow-deco"></div> 
                <div class="section-title-wrapper text-center mb-5 pb-3" data-aos="fade-up">
                    <h2 class="section-title-main text-orange">Hubungi Kami</h2>
                    <p class="section-subtitle mx-auto" style="color: #b0bec5;">Ada pertanyaan mengenai pemesanan, harga, atau kemitraan? Jangan ragu untuk menghubungi tim kami.</p>
                </div>
                
                <div class="row g-4 justify-content-center relative z-1">
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="contact-card-premium">
                            <div class="contact-icon-wrapper">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <h5 class="contact-title-card">(+62) 822 7102 6009</h5>
                            <p class="contact-text-card">
                                Layanan telepon dan WhatsApp kami siap membantu Anda dengan informasi cepat soal ketersediaan produk and harga.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="250">
                        <div class="contact-card-premium">
                            <div class="contact-icon-wrapper">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <h5 class="contact-title-card">Banyuwangi, Jawa Timur</h5>
                            <p class="contact-text-card">
                                Pusat operasional dan peternakan kami berlokasi di Banyuwangi. Kami melayani pengiriman ke berbagai wilayah rute.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="contact-card-premium">
                            <div class="contact-icon-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <h5 class="contact-title-card" style="word-break: break-all;">knur52003@gmail.com</h5>
                            <p class="contact-text-card">
                                Kirimkan penawaran kerjasama, pertanyaan mendetail, atau permintaan brosur lengkap via email resmi kami.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5 pt-3 relative z-1" data-aos="fade-up">
                    <a href="contact.php" class="btn-premium btn-premium-orange shadow-premium" style="text-decoration: none;">
                        Kunjungi Halaman Kontak
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="mitra-section text-center text-white mt-5">
        <div class="container py-4" data-aos="zoom-in-up" data-aos-duration="1000">
            <h2 class="fw-bold mb-4" style="color: var(--navy-dark); font-size: 3rem; letter-spacing: -1.5px;">AYO BERGABUNG MENJADI MITRA!</h2>
            <p class="mb-5 mx-auto" style="font-size: 1.2rem; font-weight: 600; color: var(--navy-dark); opacity: 0.9; max-width: 650px; line-height: 1.7;">
                Mari jalin kolaborasi yang saling menguntungkan. Kepercayaan Anda adalah prioritas utama kami. Bersama, kita majukan industri peternakan unggas lokal.
            </p>
            <a href="mitra.php" class="btn-premium btn-premium-dark px-5 py-3 shadow-lg" style="font-size: 1rem;text-decoration: none;">
                Pelajari Program Kemitraan Selengkapnya <i class="bi bi-chevron-right ms-2"></i>
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out-cubic'
        });
    </script>

    <?php include "include/footer.php"; ?>
</body>
</html>