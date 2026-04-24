<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Input Produk - UD. Sumber Rejeki</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ffb74d;
            --primary-dark: #f57c00;
            --navy: #001f3f;
            --cream-light: #fff3e0;
            --glass: rgba(255, 255, 255, 0.9);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fdfdfd 0%, var(--cream-light) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--navy);
        }

        header {
            background: var(--navy);
            padding: 60px 20px 120px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: #fdfdfd;
            clip-path: ellipse(60% 50% at 50% 100%);
        }

        header h1 {
            font-weight: 800;
            font-size: 2.5rem;
            letter-spacing: -1px;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        header p { opacity: 0.8; font-weight: 300; }

        .wrapper {
            max-width: 900px;
            margin: -60px auto 60px;
            width: 100%;
            padding: 0 20px;
            z-index: 10;
        }

        .main-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
        }

        .info-sidebar {
            background: var(--primary);
            border-radius: 24px;
            padding: 30px;
            color: var(--navy);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-sidebar h2 { font-weight: 800; font-size: 1.5rem; margin-bottom: 15px; }

        .form-grid { display: flex; flex-direction: column; gap: 20px; }

        .input-box label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--navy);
        }

        .input-box input, .input-box textarea {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #edf2f7;
            background: white;
            outline: none;
        }

        .btn-action {
            background: var(--navy);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-action:hover { background: var(--primary-dark); transform: translateY(-2px); }

        /* --- STYLING FOOTER DARI KODE MITRA --- */
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

    <header>
        <div class="brand-box">
            <span style="font-size: 2.5rem;">🦆</span>
        </div>
        <h1>Input Inventaris</h1>
        <p>Manajemen data produk UD. Sumber Rejeki lebih cepat & akurat.</p>
    </header>

    <div class="wrapper">
        <div class="main-card">
            <div class="info-sidebar">
                <div>
                    <h2>Panduan</h2>
                    <p>Pastikan nama produk sesuai dengan label fisik. Gunakan angka bulat untuk stok produk.</p>
                </div>
                <div style="font-size: 0.8rem; font-weight: 600;">Sistem Internal v2.0</div>
            </div>

            <form action="" method="POST" class="form-grid">
                <div class="input-box">
                    <label>Nama Produk</label>
                    <input type="text" placeholder="Misal: Pupuk Organik Cair">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-box">
                        <label>Ukuran</label>
                        <input type="text" placeholder="Kg/Liter/Pcs">
                    </div>
                    <div class="input-box">
                        <label>Jumlah Stok</label>
                        <input type="number" placeholder="0">
                    </div>
                </div>
                <div class="input-box">
                    <label>Deskripsi Singkat</label>
                    <textarea rows="4" placeholder="Keterangan tambahan..."></textarea>
                </div>
                <button type="submit" class="btn-action">Simpan ke Database →</button>
            </form>
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