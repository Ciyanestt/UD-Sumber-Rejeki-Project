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
    <title>Contact Us - UD. Sumber Rejeki</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
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
    position: fixed; /* Menggunakan fixed agar selalu di tengah layar saat di-scroll */
    top: 50%;        /* Diubah dari 95% menjadi 50% untuk posisi vertikal */
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50%;
    max-width: 500px;
    opacity: 0.1;
    z-index: -1;
    pointer-events: none;
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

     /* --- CONTACT CARDS (Lebar & Panjang) --- */
.contact-cards {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;   
    justify-content: center;
    align-items: stretch; 
    gap: 25px; /* Jarak antar kotak */
    padding: 0 20px;
    margin-top: -80px;
    position: relative;
    z-index: 10;
    width: 100%;
}

.contact-cards .card {
    background-color: #0b1d3a !important; /* Biru Marun */
    color: white !important;
    padding: 40px 30px; /* Padding lebih besar agar kotak terasa lebih lega */
    border-radius: 15px;
    
    /* PENGATURAN DIMENSI */
    flex: 0 1 450px;    /* Lebar dasar kotak (lebih lebar dari sebelumnya) */
    min-height: 300px;  /* Membuat kotak lebih panjang ke bawah */
    
    border: none !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
}

.contact-cards .icon-circle {
    background-color: #fbbd5a !important;
    width: 65px;  /* Ikon sedikit lebih besar */
    height: 65px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 25px;
}

.contact-cards .card h3 {
    color: #fbbd5a !important;
    font-size: 20px; /* Ukuran teks judul diperbesar */
    font-weight: 700;
    margin-bottom: 15px;
}

.contact-cards .card p {
    font-size: 15px; /* Ukuran teks deskripsi diperbesar */
    color: #d1d5db !important;
    line-height: 1.7;
    margin: 0;
}

/* Responsif: Tetap aman untuk layar kecil */
@media (max-width: 1100px) {
    .contact-cards {
        flex-wrap: wrap;
        justify-content: center;
    }
    .contact-cards .card {
        flex: 1 1 300px;
        max-width: 500px;
    }
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

    <img src="pictures/logo.png" class="watermark-bg" alt="Watermark">

<?php include "include/header.php"; ?>

    <section class="hero-section">
        <h1>HUBUNGI KAMI</h1>
    </section>

    <section class="contact-cards">
        <div class="card">
            <div class="icon-circle">
                <img src="https://api.iconify.design/ic:baseline-phone.svg" alt="Ikon Telepon" width="40" height="40" style="color: #000000;">
            </div>
            <h3>(+62) 822-7102-6009</h3>
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
            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d10485.491253393051!2d114.32081227286776!3d-8.517561742051704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zOMKwMzAnNTkuMyJTIDExNMKwMTknMTYuMCJF!5e0!3m2!1sid!2sid!4v1779988690781!5m2!1sid!2sid" 
            width="100%" 
            height="100%" 
            style="border: 2px solid #ccc;" 
            allowfullscreen="" 
            loading="lazy"  
            referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <div class="footer-orange-divider"></div>
   <?php include "include/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>