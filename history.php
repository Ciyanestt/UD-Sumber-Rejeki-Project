<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. SUMBER REJEKI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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
            background: white;
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

        /* --- KONTEN UTAMA --- */
       .main {
            flex: 1;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .date-section { 
            font-size: 1.5rem; 
            margin: 30px 0 15px; 
            font-weight: bold; }

        .card {
            background: #fbd38d;
            border-radius: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            font-family: 'Poppins', sans-serif;
            
        }

        .card-content { 
            padding: 25px; 
            text-align: center; 
            font-size: 1.3rem; 
            font-weight: 500; 
        }

        .card-footer-btn { 
            background: #f6ad55; 
            padding: 12px; 
            text-align: center; 
        }

        .card-footer-btn a { 
            text-decoration: none; 
            color: #333; 
            font-weight: bold; 
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

    <main class="main">
        <h2 class="date-section">12 September 2025</h2>
        <div class="card">
            <div class="card-content">Transaksi Berhasil &nbsp; / &nbsp; 08:00</div>
            <div class="card-footer-btn"><a href="#">Lihat Detail</a></div>
        </div>
        <div class="card">
            <div class="card-content">Transaksi Berhasil &nbsp; / &nbsp; 20:00</div>
            <div class="card-footer-btn"><a href="#">Lihat Detail</a></div>
        </div>
        <h2 class="date-section">15 Desember 2025</h2>
        <div class="card">
            <div class="card-content">Transaksi Berhasil &nbsp; / &nbsp; 17:18</div>
            <div class="card-footer-btn"><a href="#">Lihat Detail</a></div>
        </div>
    </main>

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