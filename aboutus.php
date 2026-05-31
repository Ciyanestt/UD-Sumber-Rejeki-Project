<?php
session_start();
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: product.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. SUMBER REJEKI - Tentang Kami</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-glow: #ff9f1c;
            --primary-dark: #e08500;
            --bg-content: #fdfcf5; 
            --navy-deep: #06152b;
            --navy-bright: #0f2b54;
            --navy-gradient: linear-gradient(135deg, #06152b 0%, #12315e 100%);
            --orange-gradient: linear-gradient(135deg, #ff9f1c 0%, #ffbf69 100%);
            --glass-card: rgba(255, 253, 240, 0.85);
            --glass-border: rgba(255, 159, 28, 0.3);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-content);
            color: #1e293b;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-heading {
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.5px;
        }

        /* --- IMMERSIVE BACKDROP ORNAMENTS --- */
        .ambient-glow-1 {
            position: absolute;
            top: -10%; left: -10%;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(255,159,28,0.22) 0%, transparent 65%);
            z-index: 0; pointer-events: none;
        }
        .ambient-glow-2 {
            position: absolute;
            top: 50%; right: -15%;
            width: 800px; height: 800px;
            background: radial-gradient(circle, rgba(15,43,84,0.15) 0%, transparent 70%);
            z-index: 0; pointer-events: none;
        }
        .watermark-bg {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 25%;
            max-width: 300px;
            opacity: 0.015; 
            z-index: 0;
            pointer-events: none;
        }

        /* --- HERO DECONSTRUCTION --- */
        .hero-luxury-wrapper {
            background: var(--navy-gradient);
            position: relative;
            padding: 140px 0 200px 0;
            overflow: hidden;
            z-index: 1;
            border-bottom: 5px solid var(--primary-glow);
        }
        .hero-luxury-wrapper::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0; right: 0;
            height: 120px;
            background: var(--bg-content); 
            clip-path: polygon(0 100%, 100% 100%, 100% 0);
        }
        .luxury-badge {
            background: linear-gradient(90deg, rgba(255,159,28,0.3) 0%, rgba(255,159,28,0.1) 100%);
            color: #ffffff; 
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            display: inline-block;
            border-left: 4px solid var(--primary-glow);
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(255,159,28,0.2);
        }
        .hero-luxury-wrapper h2 {
            font-weight: 700;
            font-size: 3.8rem;
            color: #ffffff;
            line-height: 1.1;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        /* --- MAIN WRAPPER SHIFT --- */
        .content-shift-layer {
            margin-top: -130px;
            position: relative;
            z-index: 2;
            padding-bottom: 80px;
        }

        /* --- GLASSMORPHIC INTRO CARD --- */
        .showcase-card {
            background: var(--glass-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 60px;
            box-shadow: 0 40px 100px rgba(255, 159, 28, 0.08); 
            position: relative;
        }
        .showcase-card::before {
            content: '';
            position: absolute;
            top: 0; left: 100px; right: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary-glow), transparent);
        }
        .headline-glow {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--navy-deep);
            line-height: 1.3;
        }
        .divider-line {
            width: 60px; height: 5px;
            background: var(--primary-glow);
            border-radius: 10px;
            margin: 25px 0;
        }
        .body-p-style {
            font-size: 1.1rem;
            line-height: 2;
            color: #334155; 
            text-align: justify;
        }

        /* --- CHIAROSCURO VISI & MISI LAYOUT --- */
        .asymmetric-holder {
            margin-top: 60px;
        }
        .dark-visi-card {
            background: #fffef0; 
            color: var(--navy-deep);
            border-radius: 35px;
            padding: 55px;
            box-shadow: 0 20px 60px rgba(255, 159, 28, 0.05);
            height: 100%;
            position: relative;
            border: 1px solid rgba(255, 159, 28, 0.1);
            transition: 0.3s;
        }
        .dark-visi-card:hover {
            border-color: rgba(255, 159, 28, 0.5);
            box-shadow: 0 30px 70px rgba(255, 159, 28, 0.1);
        }
        .light-misi-card {
            background: var(--orange-gradient);
            color: var(--navy-deep); 
            border-radius: 35px;
            padding: 55px;
            box-shadow: 0 30px 70px rgba(255, 159, 28, 0.2);
            height: 100%;
            position: relative;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .card-icon-tag {
            width: 50px; height: 50px;
            background: rgba(255, 159, 28, 0.2);
            color: var(--primary-dark);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 159, 28, 0.2);
        }
        .light-misi-card .card-icon-tag {
            background: var(--navy-deep);
            color: var(--primary-glow);
        }

        /* Misi Grid Item Mechanics */
        .misi-grid-flow {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }
        .misi-flex-box {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        .misi-counter {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy-deep); 
            opacity: 0.9;
            line-height: 1;
            padding-top: 2px;
        }
        .misi-text-list {
            color: #1e293b; 
            font-weight: 500;
        }

        /* --- MICRO-MINIMALIST BENEFIT CARDS (Sertifikasi & Legalitas) --- */
        .premium-benefit-hub {
            margin-top: 100px;
        }
        .neo-brutal-card {
            background: #fffef5; 
            border-radius: 28px;
            padding: 45px 35px;
            border: 1px solid rgba(255, 159, 28, 0.1);
            box-shadow: 0 15px 40px rgba(255, 159, 28, 0.03);
            transition: all 0.4s cubic-bezier(0.215, 0.61, 0.355, 1);
            height: 100%;
        }
        .neo-brutal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 40px 80px rgba(255, 159, 28, 0.14);
            border-color: rgba(255, 159, 28, 0.3);
        }
        .pill-icon {
            width: 60px; height: 60px;
            border-radius: 18px;
            background: #fff8f0;
            color: var(--primary-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 30px;
            box-shadow: inset 0 0 20px rgba(255,159,28,0.05);
            transition: 0.3s;
            border: 1px solid rgba(255, 159, 28, 0.1);
        }
        .neo-brutal-card:hover .pill-icon {
            background: var(--navy-deep);
            color: #ffffff;
            transform: scale(1.1) rotate(-5deg);
        }
        .benefit-title {
            color: var(--navy-deep) !important;
            font-weight: 700;
        }

        /* Semitransparent Separator Bottom Area */
        .banner-space {
            padding-bottom: 60px;
        }

        @media (max-width: 991.98px) {
            .hero-luxury-wrapper h2 { font-size: 2.8rem; }
            .showcase-card { padding: 35px; }
            .headline-glow { font-size: 1.8rem; }
        }

        /* --- 🌟 EFEK TRANSISI POP UP SAAT DI-SCROLL 🌟 --- */
        .scroll-pop {
            opacity: 0;
            transform: translateY(50px) scale(0.93);
            transition: opacity 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.15), 
                        transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.15);
        }
        .scroll-pop.muncul {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
</head>
<body>
    
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>
    <img src="pictures/logo.png" class="watermark-bg" alt="Watermark">

    <?php include "include/header.php"; ?>

    <!-- HERO SECTION -->
    <div class="hero-luxury-wrapper text-center">
        <div class="container">
            <span class="luxury-badge"><i class="fa-solid fa-award me-2"></i> Profil Perusahaan</span>
            <h2>TENTANG KAMI</h2>
        </div>
    </div>

    <!-- MAIN INTERACTIVE HUB -->
    <div class="container content-shift-layer">
        
        <!-- MAIN PROFILE CARD (GLASSMORPHISM EFFECT) -->
        <div class="showcase-card scroll-pop">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h3 class="headline-glow">Menyediakan Daging Unggas Berkualitas, Aman, dan Higienis.</h3>
                    <div class="divider-line"></div>
                </div>
                <div class="col-lg-7">
                    <p class="body-p-style mb-4">
                        Unit usaha pengolahan karkas <strong class="text-dark font-heading">UD. Sumber Rejeki</strong> bergerak di bidang pemotongan dan penyediaan daging unggas layak konsumsi. Usaha ini didirikan untuk mendukung penyerapan hasil ternak mitra sekaligus memenuhi kebutuhan pasar akan daging unggas yang segar, higienis, dan berkualitas. Produk didistribusikan kepada pedagang/pemasok, warung makan, serta restoran atau rumah makan.
                    </p>
                    <p class="body-p-style mb-0">
                        Proses penyembelihan dilakukan oleh tenaga yang telah memiliki sertifikat <strong>Juru Sembelih Halal (JULEHA)</strong> dengan memperhatikan kaidah kesejahteraan hewan dan ketentuan syariat. Kami menerapkan penanganan pasca potong dan distribusi yang terkontrol guna menjaga keamanan dan mutu produk sampai ke konsumen.
                    </p>
                </div>
            </div>
        </div>

        <!-- CHIAROSCURO VISI & MISI LAYOUT -->
        <div class="row g-4 asymmetric-holder align-items-stretch">
            <!-- VISI CARD (LIGHT KREM LUXURY) -->
            <div class="col-lg-5 scroll-pop">
                <div class="dark-visi-card">
                    <div class="card-icon-tag"><i class="fa-solid fa-eye"></i></div>
                    <h4 class="fw-bold mb-4" style="font-size: 1.8rem; color: var(--navy-deep);">Visi Kami</h4>
                    <p class="lh-xl mb-0" style="font-size: 1.2rem; font-style: italic; font-weight: 600; line-height: 1.8; color: #475569;">
                        "Menjadi penyedia daging unggas yang higienis, berkualitas, dan terpercaya bagi masyarakat serta pelaku usaha kuliner."
                    </p>
                </div>
            </div>
            
            <!-- MISI CARD (ORANGE GRADIENT EXTENSION) -->
            <div class="col-lg-7 scroll-pop">
                <div class="light-misi-card">
                    <div class="card-icon-tag"><i class="fa-solid fa-crosshairs"></i></div>
                    <h4 class="fw-bold mb-4" style="font-size: 1.8rem;">Misi Strategis</h4>
                    
                    <div class="misi-grid-flow">
                        <?php
                        $misi_items = [
                            "Menyediakan daging unggas yang segar, bersih, dan layak konsumsi.",
                            "Melaksanakan proses penyembelihan sesuai standar halal dan higienitas pangan.",
                            "Menjaga kualitas produk melalui penanganan pasca potong dan distribusi yang tepat.",
                            "Mendukung penyerapan hasil ternak mitra secara berkelanjutan.",
                            "Membangun kerja sama jangka panjang dengan pedagang, warung makan, dan restoran."
                        ];
                        foreach ($misi_items as $count => $text): ?>
                        <div class="misi-flex-box">
                            <div class="misi-counter">0<?= $count + 1 ?>.</div>
                            <div class="misi-text-list fw-medium" style="font-size: 1rem; line-height: 1.6; letter-spacing: 0.3px;"><?= $text ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- MICRO-MINIMALIST LEGALITY CARDS -->
        <div class="premium-benefit-hub text-center py-5">
            <h3 class="fw-bold text-dark mb-2" style="font-size: 2.4rem;">Standar Mutu & Legalitas</h3>
            <p class="text-muted mx-auto mb-5" style="max-width: 550px;">Komitmen penuh UD. Sumber Rejeki dalam menjaga regulasi keamanan pangan karkas secara konsisten.</p>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 scroll-pop">
                    <div class="neo-brutal-card">
                        <div class="pill-icon"><i class="fa-solid fa-certificate"></i></div>
                        <h5 class="benefit-title mb-3">Sertifikasi Halal</h5>
                        <p class="text-muted small lh-lg mb-0">Diproses mutlak oleh Juru Sembelih Halal (JULEHA) yang sah dan sesuai ketentuan syariat Islam Islam.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 scroll-pop">
                    <div class="neo-brutal-card">
                        <div class="pill-icon"><i class="fa-solid fa-passport"></i></div>
                        <h5 class="benefit-title mb-3">Berizin Resmi (NIB)</h5>
                        <p class="text-muted small lh-lg mb-0">Memiliki legalitas Nomor Induk Berusaha yang valid sebagai entitas penyedia komoditas hewani terdaftar.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 scroll-pop">
                    <div class="neo-brutal-card">
                        <div class="pill-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h5 class="benefit-title mb-3">Proses Standardisasi NKV</h5>
                        <p class="text-muted small lh-lg mb-0">Dalam tahap pembinaan intensif menuju perolehan Nomor Kontrol Veteriner guna jaminan higienitas tertinggi.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container banner-space"></div>
    <?php include "include/footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const elemenPopUp = document.querySelectorAll('.scroll-pop');

            const opsiObserver = {
                root: null,
                threshold: 0.12,
                rootMargin: "0px 0px -40px 0px"
            };

            const observer = new IntersectionObserver(function (entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('muncul');
                        observer.unobserve(entry.target);
                    }
                });
            }, opsiObserver);

            elemenPopUp.forEach(elemen => {
                observer.observe(elemen);
            });
        });
    </script>
</body>
</html>