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
    <title>Mitra Premium - UD. Sumber Rejeki</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-glow: #ff9f1c;
            --primary-dark: #e08500;
            /* Update Warna Latar Konten: Krem Hangat agar tidak sepi */
            --bg-content: #fdfcf5; 
            --navy-deep: #06152b;
            --navy-bright: #0f2b54;
            --navy-gradient: linear-gradient(135deg, #06152b 0%, #12315e 100%);
            /* Update Misi Gradient: Menjadi Oranye dominan */
            --orange-gradient: linear-gradient(135deg, #ff9f1c 0%, #ffbf69 100%);
            /* Update Glass Card: Sedikit tint krem */
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

        /* --- IMMERSIVE BACKDROP ORNAMENTS (Warna diperkuat) --- */
        .ambient-glow-1 {
            position: absolute;
            top: -10%; left: -10%;
            width: 700px; height: 700px;
            /* Update: Opacity dinaikkan biar padat warna */
            background: radial-gradient(circle, rgba(255,159,28,0.22) 0%, transparent 65%);
            z-index: 0; pointer-events: none;
        }
        .ambient-glow-2 {
            position: absolute;
            top: 50%; right: -15%;
            width: 800px; height: 800px;
            /* Update: Navy glow diperkuat */
            background: radial-gradient(circle, rgba(15,43,84,0.15) 0%, transparent 70%);
            z-index: 0; pointer-events: none;
        }
        .watermark-bg {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 25%;
            max-width: 300px;
            opacity: 0.015; /* Sedikit lebih kelihatan */
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
            /* Tambahan border bawah oranye mewah */
            border-bottom: 5px solid var(--primary-glow);
        }
        .hero-luxury-wrapper::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0; right: 0;
            height: 120px;
            /* Update: Menyesuaikan warna background Krem */
            background: var(--bg-content); 
            clip-path: polygon(0 100%, 100% 100%, 100% 0);
        }
        .luxury-badge {
            /* Update: Warna badge background lebih pekat oranye */
            background: linear-gradient(90deg, rgba(255,159,28,0.3) 0%, rgba(255,159,28,0.1) 100%);
            color: #ffffff; /* Teks jadi putih */
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

        /* --- GLASSMORPHIC INTRO CARD (Lebih Berwarna Krem) --- */
        .showcase-card {
            background: var(--glass-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 60px;
            /* Update: Shadow lebih berwarna */
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
            /* Update: Warna teks lebih gelap biar jelas di krem */
            color: #334155; 
            text-align: justify;
        }

        /* --- CHIAROSCURO VISI & MISI LAYOUT --- */
        .asymmetric-holder {
            margin-top: 60px;
        }
        .dark-visi-card {
            /* Update: Background Visi jadi Krem Muda Mewah */
            background: #fffef0; 
            color: var(--navy-deep);
            border-radius: 35px;
            padding: 55px;
            /* Update: Shadow berwarna oranye lembut */
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
            /* UPDATE: Background Misi JADI ORANYE DOMINAN */
            background: var(--orange-gradient);
            /* UPDATE: Teks Misi jadi Gelap agar kontras */
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
            /* Update: Icon tag di Visi lebih orange pekat */
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
            /* Update: Icon tag di Misi (Orange Bg) jadi Navy */
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
            /* Update: Counter di Misi Orange jadi Navy */
            color: var(--navy-deep); 
            opacity: 0.9;
            line-height: 1;
            padding-top: 2px;
        }
        /* Update Warna Teks Misi List */
        .misi-text-list {
            color: #1e293b; /* Abu gelap pekat */
            font-weight: 500;
        }

        /* --- MICRO-MINIMALIST BENEFIT CARDS (Warna Krem) --- */
        .premium-benefit-hub {
            margin-top: 100px;
        }
        .neo-brutal-card {
            /* Update: Background Benefit jadi Krem */
            background: #fffef5; 
            border-radius: 28px;
            padding: 45px 35px;
            /* Border Oranye Halus */
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
        /* Update Title Benefit lebih berwarna navy deep */
        .benefit-title {
            color: var(--navy-deep) !important;
            font-weight: 700;
        }

        /* --- FUTURISTIC CTA BANNER --- */
        .banner-space {
            padding-bottom: 120px;
        }
        .glass-cta-container {
            background: var(--navy-gradient);
            border-radius: 45px;
            padding: 80px 50px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 35px 80px rgba(6, 21, 43, 0.3);
            border-bottom: 5px solid var(--primary-glow);
        }
        .glass-cta-container::before {
            content: '';
            position: absolute;
            top: -30%; right: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,159,28,0.15) 0%, transparent 70%);
        }
        .interactive-contact-anchor {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            color: #ffffff;
            padding: 18px 35px;
            border-radius: 24px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 20px;
            text-decoration: none;
            transition: all 0.4s ease;
            border: 1px solid rgba(255,255,255,0.1);
            margin: 12px;
            width: 100%;
            max-width: 380px;
        }
        .interactive-contact-anchor:hover {
            background: #ffffff;
            color: var(--navy-deep);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(255, 159, 28, 0.25);
            border-color: var(--primary-glow);
        }
        .interactive-contact-anchor img {
            width: 36px; height: 36px;
        }

        @media (max-width: 991.98px) {
            .hero-luxury-wrapper h2 { font-size: 2.8rem; }
            .showcase-card { padding: 35px; }
            .headline-glow { font-size: 1.8rem; }
        }

        /* --- 🌟 EFEK TRANSISI POP UP SAAT DI-SCROLL (Dipertahankan) 🌟 --- */
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
    <div class="hero-luxury-wrapper text-center">
        <div class="container">
            <span class="luxury-badge"><i class="fa-solid fa-bolt-lightning me-2"></i> Ekosistem Peternakan</span>
            <h2>PROFIL MITRA PETERNAK</h2>
        </div>
    </div>

    <div class="container content-shift-layer">
        
        <div class="showcase-card scroll-pop">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h3 class="headline-glow">Membangun Sinergi Emas Bersama Masyarakat Terarah.</h3>
                    <div class="divider-line"></div>
                </div>
                <div class="col-lg-7">
                    <p class="body-p-style mb-4">
                        <strong class="text-dark font-heading">UD. Sumber Rejeki</strong> hadir sebagai jangkar kemitraan peternakan unggas nasional yang fokus penuh pada standarisasi pembinaan, pendampingan berkala, dan eskalasi bisnis peternak mitra. Kami merajut ruang kolaborasi hulu-ke-hilir agar tercipta aktivitas peternakan yang presisi, produktif, serta memiliki jaminan kepastian usaha yang kuat.
                    </p>
                    <p class="body-p-style mb-0">
                        Melalui ekosistem terintegrasi ini, kami mendistribusikan sarana produksi unggulan, panduan teknis biosekuriti, hingga serapan rantai pasok hilir secara masif. Berlandaskan asas transparansi dan mutualisme, kami berdedikasi menemani peternak meraih profitabilitas yang tangguh dan berkelanjutan.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4 asymmetric-holder align-items-stretch">
            <div class="col-lg-5 scroll-pop">
                <div class="dark-visi-card">
                    <div class="card-icon-tag"><i class="fa-solid fa-eye"></i></div>
                    <h4 class="fw-bold mb-4" style="font-size: 1.8rem; color: var(--navy-deep);">Visi Utama</h4>
                    <p class="lh-xl mb-0" style="font-size: 1.2rem; font-style: italic; font-weight: 600; line-height: 1.8; color: #475569;">
                        "Menjadi wadah kemitraan peternakan unggas yang membantu masyarakat memperoleh penghasilan yang stabil melalui sistem beternak yang terarah, profesional, dan berkelanjutan."
                    </p>
                </div>
            </div>
            
            <div class="col-lg-7 scroll-pop">
                <div class="light-misi-card">
                    <div class="card-icon-tag"><i class="fa-solid fa-crosshairs"></i></div>
                    <h4 class="fw-bold mb-4" style="font-size: 1.8rem;">Misi Strategis Perusahaan</h4>
                    
                    <div class="misi-grid-flow">
                        <?php
                        $misi_items = [
                            "Menyediakan sarana produksi ternak unggas yang berkualitas dan terjamin kesehatannya.",
                            "Memberikan pembinaan dan pendampingan teknis kepada peternak mitra secara berkelanjutan.",
                            "Menciptakan sistem kemitraan yang adil, transparan, dan saling menguntungkan.",
                            "Meningkatkan produktivitas ternak melalui manajemen pakan dan kesehatan yang terarah.",
                            "Menjamin penyerapan hasil ternak mitra agar memiliki kepastian pasar.",
                            "Membangun hubungan kerja sama jangka panjang yang dilandasi kepercayaan.",
                        ];
                        foreach ($misi_items as $count => $text): ?>
                        <div class="misi-flex-box">
                            <div class="misi-counter">0<?= $count + 1 ?>.</div>
                            <div class="misi-text-list fw-medium" style="font-size: 1rem; line-height: 1.6; letter-spacing: 0.3px;"><?= $text ?></div>
                        </div>
                        <?php endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="premium-benefit-hub text-center py-5">
            <h3 class="fw-bold text-dark mb-2" style="font-size: 2.4rem;">Keunggulan Kolaborasi</h3>
            <p class="text-muted mx-auto mb-5" style="max-width: 550px;">Mengapa ratusan peternak mempercayakan tata kelola produksinya kepada UD. Sumber Rejeki?</p>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 scroll-pop">
                    <div class="neo-brutal-card">
                        <div class="pill-icon"><i class="fa-solid fa-shield-cat"></i></div>
                        <h5 class="benefit-title mb-3">Akses Sapronak Mutakhir</h5>
                        <p class="text-muted small lh-lg mb-0">Pasokan bibit dan pakan berstandar laboratorium yang siap diutilisasi secara terjadwal tanpa risiko kelangkaan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 scroll-pop">
                    <div class="neo-brutal-card">
                        <div class="pill-icon"><i class="fa-solid fa-user-shield"></i></div>
                        <h5 class="benefit-title mb-3">Supervisi Ahli Lapangan</h5>
                        <p class="text-muted small lh-lg mb-0">Edukasi komprehensif penanganan medis unggas oleh tim teknisi veteriner handal langsung di area peternakan Anda.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 scroll-pop">
                    <div class="neo-brutal-card">
                        <div class="pill-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <h5 class="benefit-title mb-3">Akuntabilitas Finansial</h5>
                        <p class="text-muted small lh-lg mb-0">Sistem pelaporan berkala, transparansi bobot timbang, serta kepastian harga jual kontrak yang mengamankan profit.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container banner-space scroll-pop">
        <div class="glass-cta-container text-center">
            <h3 class="fw-bold mb-3" style="font-size: 2.5rem; text-shadow: 0 2px 5px rgba(0,0,0,0.2);">Mari Akselerasikan Bisnis Anda</h3>
            <p class="opacity-75 mb-5 mx-auto" style="max-width: 600px; font-weight: 400; font-size: 1.1rem; color: #eee;">Segera integrasikan peternakan Anda ke dalam jaringan kemitraan UD. Sumber Rejeki. Slot pembinaan wilayah terbatas.</p>
            
            <div class="d-flex flex-wrap justify-content-center pt-2">
                <a href="https://wa.me/6282271026009" target="_blank" class="interactive-contact-anchor">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
                    <div class="text-start">
                        <small class="d-block opacity-70" style="font-size:0.75rem; font-weight:500;">Respon Cepat via WA</small>
                        <span class="fw-bold" style="font-size: 1.05rem;">+62 822-7102-6009</span>
                    </div>
                </a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=knur52003@gmail.com" target="_blank" class="interactive-contact-anchor">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png" alt="Gmail">
                    <div class="text-start">
                        <small class="d-block opacity-70" style="font-size:0.75rem; font-weight:500;">Korespondensi Email</small>
                        <span class="fw-bold" style="font-size: 1.05rem; word-break: break-all;">knur52003@gmail.com</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

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