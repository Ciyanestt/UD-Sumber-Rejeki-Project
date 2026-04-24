<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. SUMBER REJEKI - Riwayat Transaksi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* --- WATERMARK --- */
        .watermark-bg {
            position: Absolute;
            top: 95%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 1000px;
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

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

                /* Hero Section */
        .hero-section {
            padding: 60px 20px;
            text-align: center;
            background: url('path_to_your_logo_watermark.png') no-repeat center; /* Tambahkan logo transparan di sini */
            background-size: contain;
        }
        .section-title {
            font-weight: 800;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .content-text {
            max-width: 800px;
            margin: 0 auto 30px;
            font-size: 20px;
            line-height: 1.8; 
        }

                /* Visi Misi */
        .visi-misi h4 {
            font-weight: 700;
            margin-bottom: 15px;
        }
        .visi-misi ul {
            font-size: 20px;
            list-style: none;
            padding: 0;
            display: inline-block;
            text-align: left;
        }

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

    <img src="logo.jpg" class="watermark-bg" alt="Watermark">

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

    <div class="container hero-section">
        <h2 class="section-title">TENTANG KAMI</h2>
        
        <p class="content-text">
            Unit usaha pengolahan karkas <strong>UD. Sumber Rejeki</strong> bergerak di bidang pemotongan dan penyediaan daging unggas layak konsumsi. 
            Usaha ini didirikan untuk mendukung penyerapan hasil ternak mitra sekaligus memenuhi kebutuhan pasar akan daging unggas yang segar, higienis, dan berkualitas.
        </p>

        <p class="content-text">
            Produk didistribusikan kepada pedagang/pemasok, warung makan, serta restoran atau rumah makan. 
            Proses penyembelihan dilakukan oleh tenaga yang telah memiliki sertifikat <strong>Juru Sembelih Halal (JULEHA)</strong>
            dengan memperhatikan kaidah kesejahteraan hewan dan ketentuan syariat.
        </p>

        <p class="content-text">
            UD. Sumber Rejeki telah memiliki Nomor Induk Berusaha (NIB) dan Sertifikat Halal, 
            serta sedang dalam tahap pembinaan dan proses pemenuhan persyaratan menuju Sertifikat Nomor Kontrol Veteriner (NKV). 
            Perusahaan juga menerapkan penanganan pasca potong dan distribusi yang terkontrol guna menjaga keamanan dan mutu produk sampai ke konsumen.
        </p>
        <div class="visi-misi my-5">
            <h4>Visi</h4>
            <p class="content-text">
              Menjadi penyedia daging unggas yang higienis, berkualitas, dan terpercaya bagi masyarakat serta pelaku usaha kuliner.</p>

            <h4 class="mt-4">Misi</h4>
            <ul class="text-center" style="max-width: 1000px; padding-left: 20px;">
                <li>Menyediakan daging unggas yang segar, bersih, dan layak konsumsi.</li>
                <li>Melaksanakan proses penyembelihan sesuai standar halal dan higienitas pangan.</li>
                <li>Menjaga kualitas produk melalui penanganan pasca potong dan distribusi yang tepat.</li>
                <li>Mendukung penyerapan hasil ternak mitra secara berkelanjutan.</li>
                <li>Membangun kerja sama jangka panjang dengan pedagang, warung makan, dan restoran.</li>
            </ul>
        </div>
        </main>
</div>

    <div class="footer-orange-divider"></div>

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