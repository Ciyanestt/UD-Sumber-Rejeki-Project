<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra - UD. Sumber Rejeki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

                /* --- WATERMARK --- */
        .watermark-bg {
            position: Absolute;
            top: 107%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 1000px;
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

        /* Navbar Styling */
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

        /* Contact Section (Orange Area) */
        .contact-curve {
            background-color: #ffb347;
            border-top-left-radius: 50% 20%;
            border-top-right-radius: 50% 20%;
            padding: 60px 0;
            margin-top: 50px;
            color: #000;
        }
        .contact-info {
            font-weight: bold;
            font-size
            margin: 15px 0;
        }
        .contact-info i {
            font-size: 2rem;
            margin-right: 10px;
            vertical-align: middle;
        }

                footer {
            background-color: #0e2052; /* Blue 900 sesuai kode kamu */
            padding: 40px 0 20px 0;
            color: #ffffff;
            margin-top: auto;
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

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 250px;
        }
        .footer-brand img { height: 65px; }
        .footer-brand span { font-weight: bold; font-size: 13px; color: #ffffff; }

        .footer-links { flex: 0.5; min-width: 120px; }
        .footer-links h4 { font-size: 14px; margin-bottom: 12px; font-weight: 900; }
        .footer-links ul { list-style: none; padding: 0; }
        .footer-links li { font-size: 11px; margin-bottom: 5px; font-weight: 700; }
        .footer-links a { color: #ffffff; text-decoration: none; }

        .footer-info { flex: 1; min-width: 200px; }
        .footer-info h4 { font-size: 16px; margin-bottom: 12px; font-weight: 900; }
        .footer-info p { font-size: 13px; margin-bottom: 15px; font-weight: 500; }

        .footer-social { display: flex; gap: 15px; align-items: center; }
        .footer-social img { height: 45px; cursor: pointer; }

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

        @media (max-width: 768px) {
            .main-card { grid-template-columns: 1fr; }
        }

    </style>
</head>
<body>
    
    <img src="itikk.png" class="watermark-bg" alt="Watermark">

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
        <h2 class="section-title">PROFIL MITRA PETERNAK</h2>
        
        <p class="content-text">
            UD. Sumber Rejeki merupakan usaha yang bergerak di bidang kemitraan peternakan unggas yang berfokus pada pembinaan, pendampingan, dan pengembangan peternak mitra. Perusahaan hadir sebagai wadah kerja sama antara pengelola dan masyarakat dengan tujuan menciptakan kegiatan beternak yang terarah, produktif, serta memiliki kepastian usaha.
        </p>

        <p class="content-text">
            Melalui sistem kemitraan, UD. Sumber Rejeki menyediakan sarana produksi ternak, bimbingan teknis pemeliharaan, serta membantu pemasaran hasil ternak mitra. Dengan mengedepankan prinsip kepercayaan, transparansi, dan saling menguntungkan, perusahaan berkomitmen membantu masyarakat memperoleh penghasilan yang lebih stabil dan berkelanjutan sebagai peternak unggas.
        </p>

        <div class="visi-misi my-5">
            <h4>Visi</h4>
            <p class="content-text italic">"Menjadi wadah kemitraan peternakan unggas yang membantu masyarakat memperoleh penghasilan yang stabil melalui sistem beternak yang terarah, profesional, dan berkelanjutan."</p>

            <h4 class="mt-4">Misi</h4>
            <ul class="text-center" style="max-width: 1000px; padding-left: 20px;">
                <li>Menyediakan sarana produksi ternak unggas yang berkualitas dan terjamin kesehatannya.</li>
                <li>Memberikan pembinaan dan pendampingan teknis kepada peternak mitra secara berkelanjutan.</li>
                <li>Menciptakan sistem kemitraan yang adil, transparan, dan saling menguntungkan.</li>
                <li>Meningkatkan produktivitas ternak melalui manajemen pakan dan kesehatan yang terarah.</li>
                <li>Menjamin penyerapan hasil ternak mitra agar memiliki kepastian pasar.</li>
                <li>Membangun hubungan kerja sama jangka panjang yang dilandasi kepercayaan.</li>
            </ul>
        </div>

        <div class="benefit-section my-5">
            <h5 class="fw-bold mb-3">Kenapa Harus Bermitra dengan Kami?</h5>
            <div class="d-flex flex-column align-items-center">
                <div class="mb-2"><i class="bi bi-check-lg"></i> Sarana Produksi Terjamin</div>
                <div class="mb-2"><i class="bi bi-check-lg"></i> Bimbingan Teknis & Pendampingan</div>
                <div class="mb-2"><i class="bi bi-check-lg"></i> Transparansi & Kepercayaan</div>
            </div>
        </div>
    </div>

    <div class="contact-curve text-center">
        <div class="container">
            <h4 class="fw-bold">Tertarik Menjadi Mitra Kami?</h4>
            <h5 class="fw-bold mb-4">Yuk Hubungi Nomor / Email Dibawah Ini!</h5>
            
            <div class="contact-info">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" style="height:40px;" alt="WA">
                <i class="bi"></i> +62 82271026009
            </div>
            <div class="contact-info">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png" style="height:40px;" alt="Gmail">
                <i class="bi "></i> miftakhulanwar010598@gmail.com
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
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">ABOUT US</a></li>
                    <li><a href="#">PRODUCT</a></li>
                    <li><a href="#">MITRA</a></li>
                    <li><a href="#">PESAN</a></li>
                    <li><a href="#">CONTACT US</a></li>
                    <li><a href="#">HISTORY</a></li>
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
</body>
</html>