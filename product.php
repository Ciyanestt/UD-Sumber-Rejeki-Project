<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. Sumber Rejeki - Produk Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff; margin: 0; }

        /* --- NAVBAR --- */
          .navbar {
            background-color : #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .nav-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: #333 !important;
            text-transform: uppercase;
        }
        .btn-login {
            background-color: #ced4da;
            border-radius: 20px;
            padding: 5px 20px;
            font-weight: bold;
        }

                /* --- EFEK HOVER & ACTIVE (MEMBESAR & GARIS BAWAH) KECUALI TOMBOL LOGIN --- */
        .navbar-nav .nav-link {
            transition: all 0.3s ease-in-out;
            display: inline-block; 
        }

        /* Menu akan membesar, berubah oranye, dan memiliki garis bawah saat aktif/di-hover */
        .navbar-nav .nav-link:not(.btn-login).active,
        .navbar-nav .nav-link:not(.btn-login):hover {
            color: #333 !important; 
            transform: scale(1.25); /* Teks tetap membesar */
            text-decoration: underline; /* Menambahkan garis bawah */
            text-underline-offset: 6px; /* Mengatur jarak antara teks dan garis bawah */
            text-decoration-thickness: 2px; /* Mengatur ketebalan garis bawah */
        }
        /* --- HERO SECTION --- */
        .hero-section {
            background-color: #ffb74d; /* Oranye sesuai gambar */
            padding: 60px 20px;
            text-align: center;
        }
        .hero-section h1 { font-weight: 900; font-size: 2rem; margin: 0; color: #000; }
        .hero-section p { font-weight: 500; font-size: 0.95rem; margin-top: 10px; color: #222; }

        /* --- PRODUCT GRID & WATERMARK --- */
        .main-content {
            position: relative;
            padding: 60px 0;
            background-color: #fff;
            overflow: hidden;
        }
        
        /* Watermark Background */
        .main-content::before {
            content: "";
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 800px;
            background: url('logo.jpg') no-repeat center;
            background-size: contain;
            opacity: 0.05; /* Transparansi sangat tipis */
            z-index: 0;
            pointer-events: none;
        }

        .container { position: relative; z-index: 1; }

        /* Product Cards */
        .product-card {
            background: #fef1cd; /* Kuning pucat sesuai gambar */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            width: 340px; /* Ukuran diperlebar */
            margin: 0 auto;
            transition: transform 0.3s;
        }
        .product-card:hover { transform: translateY(-5px); }
        
        .product-img { width: 100%; height: 200px; object-fit: cover; }
        
        .product-info { padding: 20px; text-align: left; }
        .product-info h3 { font-size: 1rem; font-weight: 800; margin-bottom: 5px; color: #000; }
        .product-info p { 
            font-size: 0.75rem; 
            color: #222; 
            line-height: 1.5; 
            margin-bottom: 15px; 
            min-height: 55px; 
            font-weight: 500;
        }
        
        .btn-pesan {
            background-color: #ffc107;
            border: none;
            width: 100%;
            padding: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 4px;
            color: #000;
        }

        /* --- TOMBOL REKAP --- */
        .rekap-container { text-align: center; margin-top: 60px; margin-bottom: 20px; }
        .btn-rekap {
            background-color: #ffc107;
            color: white;
            font-weight: 900;
            font-size: 1.5rem;
            padding: 12px 50px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            text-transform: uppercase;
        }

        /* --- FOOTER --- */
        .footer-orange-divider {
            height: 150px;
            background: #f6ad55;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
            width: 100%;
            margin-top: 50px;
        }

        footer {
            background-color: #0e2052; /* Blue 900 */
            padding: 40px 0 20px 0;
            color: #ffffff;
        }

        .footer-container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Bagian Brand Footer */
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 250px;
        }
        .footer-brand img { height: 65px; }
        .footer-brand span { font-weight: bold; font-size: 13px; color: #ffffff; }

        /* Bagian Quick Links */
        .footer-links {
            flex: 0.5;
            min-width: 120px;
        }
        .footer-links h4 { font-size: 14px; margin-bottom: 12px; font-weight: 900; }
        .footer-links ul { list-style: none; }
        .footer-links li { font-size: 11px; margin-bottom: 5px; font-weight: 700; color: #ffffff; }

        /* Bagian Informasi */
        .footer-info {
            flex: 1;
            min-width: 200px;
        }
        .footer-info h4 { font-size: 16px; margin-bottom: 12px; font-weight: 900; }
        .footer-info p { font-size: 13px; margin-bottom: 15px; font-weight: 500; }

        /* Icon Sosial */
        .footer-social {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .footer-social img { height: 45px; cursor: pointer; }

        /* Copyright Line */
        .footer-bottom {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto 0;
            padding-top: 15px;
            border-top: 1px solid #bbb;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="itikk.png" alt="Logo" class="me-2" style="width: 40px; height: auto;"> 
                <small class="fw-bold" style="font-size: 0.7rem;">UD. SUMBER REJEKI</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about us.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="mitra.php">Mitra</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pesan</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="history.php">History</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-login nav-link px-4" href="#">LOGIN</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <h1>PRODUK KAMI</h1>
        <p>Produk bebek segar dan alami dari peternakan kami langsung ke meja Anda.</p>
    </div>

    <div class="main-content">
        <div class="container">
            
            <div class="row g-5 justify-content-center mb-5">
                <?php
                $produk_atas = [
                    [
                        "judul" => "Daging Bebek Segar",
                        "desc" => "Daging bebek segar dan bersih. Kualitas terbaik, daging tebal, dan siap olah. Cocok untuk rumah tangga dan usaha kuliner.",
                        "img" => "bebeksegar.jpg" 
                    ],
                    [
                        "judul" => "Jeroan Bebek",
                        "desc" => "Jeroan bebek segar dan bersih siap masak. Kualitas premium untuk cita rasa masakan yang maksimal.",
                        "img" => "https://images.unsplash.com/photo-1602491673980-73aa38de027a?q=80&w=500"
                    ]
                ];

                foreach ($produk_atas as $p) : ?>
                <div class="col-auto">
                    <div class="product-card">
                        <img src="<?= $p['img'] ?>" class="product-img" alt="<?= $p['judul'] ?>">
                        <div class="product-info">
                            <h3><?= $p['judul'] ?></h3>
                            <p><?= $p['desc'] ?></p>
                            <button class="btn-pesan">Pesan Disini</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="product-card">
                        <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=500" class="product-img" alt="Usus Bebek">
                        <div class="product-info">
                            <h3>Usus Bebek</h3>
                            <p>Usus bebek pilihan dengan tekstur kenyal dan gurih. Sangat cocok untuk dijadikan sate usus atau keripik usus yang garing.</p>
                            <button class="btn-pesan">Pesan Disini</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rekap-container">
                <button class="btn-rekap">REKAP PEMBELIAN</button>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <img src="itikk.png" alt="Logo Footer">
                <span>UD. SUMBER REJEKI</span>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#" class="text-decoration-none text-white">HOME</a></li>
                    <li><a href="#" class="text-decoration-none text-white">ABOUT US</a></li>
                    <li><a href="#" class="text-decoration-none text-white">PRODUCT</a></li>
                    <li><a href="#" class="text-decoration-none text-white">MITRA</a></li>
                    <li><a href="#" class="text-decoration-none text-white">PESAN</a></li>
                    <li><a href="#" class="text-decoration-none text-white">CONTACT US</a></li>
                    <li><a href="#" class="text-decoration-none text-white">HISTORY</a></li>
                </ul>
            </div>

            <div class="footer-info">
                <h4>Informasi Lebih Lanjut</h4>
                <p>Silahkan ikuti media sosial kami</p>
                <div class="footer-social">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Youtube_logo.png" style="height:35px;" alt="YT"> 
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" style="height:40px;" alt="WA">
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; 2026 UD. SUMBER REJEKI. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>