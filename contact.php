<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - UD. Sumber Rejeki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* --- RESET & VARIABEL DASAR --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-orange: #fbbd5a; /* Warna orange dominan */
            --dark-blue: #0b1d3a;    /* Warna biru gelap untuk teks & card */
            --text-gray: #666;
            --bg-gray: #e6e6e6;
        }

        body {
            background-color: #ffffff;
            color: var(--dark-blue);
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }

       /* --- WATERMARK --- */
        .watermark-bg {
            position: Absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            max-width: 600px;
            opacity: 0.05;
            z-index: -1;
            pointer-events: none;
        }

        /* --- NAVBAR --- */
        .navbar {
            background-color : #fbbd5a;
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
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 14px;
        }

        /* --- HERO SECTION (Bagian Atas Melengkung) --- */
        .hero-section {
            background-color: var(--primary-orange);
            text-align: center;
            padding: 60px 20px 120px 20px; /* Padding bawah ekstra untuk efek lengkung */
            border-radius: 0 0 50% 50% / 60px; /* Trik CSS untuk membuat lengkungan */
            margin-bottom: 40px;
        }

        .hero-section h1 {
            font-size: 48px;
            font-weight: 800;
            color: var(--dark-blue);
            letter-spacing: 2px;
        }

        /* --- CONTACT CARDS --- */
        .contact-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 0 5%;
            margin-top: -80px; /* Menarik card ke atas lengkungan */
            position: relative;
            z-index: 10;
            
        }

        .card {
            background-color: var(--dark-blue);
            color: white;
            padding: 30px 20px;
            border-radius: 15px;
            width: 500px;
            text-align: left;
            box-shadow: 0 50px 20px rgba(0,0,0,0.1);
        
        }

        .icon-circle {
            background-color: var(--primary-orange);
            color: var(--dark-blue);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .card h3 {
            color: var(--primary-orange);
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .card p {
            font-size: 20px;
            line-height: 1.6;
            color: #d1d5db;
        }

        /* --- DETAILS SECTION (Jam Operasional & Map) --- */
        .details-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 10%;
            gap: 60px;
            position: relative;
        }

        /* Left Side: Jam Operasional */
        .operating-hours {
            flex: 1;
            max-width: 600px;
        }

        .time-box {
            background-color: var(--primary-orange);
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: 700;
            font-size: 25px;
        }

        .time-box.large {
            padding: 20px;            
            font-size: 25px;

        }

        .time-box p.note {
            font-weight: 400;
            font-size: 20px;
            margin-top: 5px;
            line-height: 1.4;
        }

        /* Pembatas Garis Biru */
        .divider {
            width: 5px;
            height: 200px;
            background-color: var(--dark-blue);
            border-radius: 5px;
        }

        /* Right Side: Map */
        .map-container {
            flex: 1;
            max-width: 500px;
        }

        .map-container h3 {
            margin-bottom: 15px;
            font-weight: 800;
        }

        .map-placeholder {
            width: 100%;
            height: 250px;
            background-color: #f0f0f0;
            border-radius: 15px;
            background-image: url('https://via.placeholder.com/600x300/E8F5E9/81C784?text=Google+Maps+Placeholder'); /* Placeholder gambar peta */
            background-size: cover;
            background-position: center;
        }

        /* --- FOOTER SESUAI GAMBAR --- */
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

        /* --- FOOTER --- */
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
        /* --- RESPONSIVE DESIGN --- */
        @media (max-width: 992px) {
            .contact-cards { flex-wrap: wrap; }
            .details-section { flex-direction: column; text-align: center; }
            .divider { width: 80%; height: 5px; }
            nav ul { display: none; /* Hide menu on mobile for simplicity */ }
        }

        @media (max-width: 768px) {
            .hero-section h1 { font-size: 36px; }
            .footer-content { flex-direction: column; gap: 30px; }
        }
    </style>
</head>
<body>

    <img src="picture/logo.png" class="watermark-bg" alt="Watermark">

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="picture/logo.png" alt="Logo" class="me-2" style="width: 40px; height: auto;"> 
                <small class="fw-bold" style="font-size: 0.7rem;">UD. SUMBER REJEKI</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Mitra</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pesan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">History</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-login nav-link px-4" href="#">LOGIN</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <h1>HUBUNGI KAMI</h1>
    </section>

    <section class="contact-cards">
        <div class="card">
            <div class="icon-circle">
                <img src="https://api.iconify.design/ic:baseline-phone.svg" alt="Ikon Telepon" width="40" height="40" style="color: #000000;">
            </div>
            <h3>(+62) 85236840255</h3>
            <p>Hubungi kami untuk informasi produk, pemesanan, dan konsultasi seputar peternakan itik.</p>
        </div>
        <div class="card">
            <div class="icon-circle">
                <img src="https://api.iconify.design/ic:baseline-location-on.svg" alt="Ikon Lokasi" width="40" height="40" style="color: #000000;">
            </div>
            <h3>Banyuwangi, Jawa Timur</h3>
            <p>Lokasi peternakan kami berada di Banyuwangi dan melayani pengiriman ke berbagai wilayah.</p>
        </div>
        <div class="card">
            <div class="icon-circle">
                <img src="https://api.iconify.design/mdi:email.svg" alt="Ikon Email" width="40" height="40" style="color: #000000;">
            </div>
            <h3>knur52003@gmail.com</h3>
            <p>Jika tidak dapat menghubungi kami melalui telepon, silakan kirim pesan melalui email sebagai alternatif.</p>
        </div>
    </section>

    <section class="details-section">
        <div class="operating-hours">
            <div class="time-box">Jam Operasional</div>
            <div class="time-box">08.00 - 21.00 WIB</div>
            <div class="time-box large">
                Senin - Minggu
                <p class="note">Note : Hari minggu kami tidak melayani pengantaran</p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="map-container">
            <h3>Find Our Location In Here!</h3>
        <div class="map-placeholder" style="padding: 0; overflow: hidden; border-radius: 15px; height: 300px;">
            <iframe 
            /* Perhatikan bagian q=-8.513520, 114.324230 di bawah ini */
            src="https://maps.google.com/maps?q=-8.513520, 114.324230 &hl=id&z=17&output=embed" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <div class="footer-orange-divider"></div>
    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <img src="picture/logo.png" alt="Logo Footer">
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