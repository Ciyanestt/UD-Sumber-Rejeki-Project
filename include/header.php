<?php
// Cek apakah session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengambil nama file yang sedang aktif secara bersih (misal: login.php)
$current_page = basename($_SERVER["PHP_SELF"]);
$blocked_pages = ["./login.php", "./register.php"];

// Jika pengguna sudah login, hindari mengakses halaman login/register
if (isset($_SESSION["role"]) && in_array($current_page, $blocked_pages, true)) {
    if ($_SESSION["role"] === "admin") {
        header("Location: ./product.php");
        exit();
    } else {
        header("Location: ./index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. SUMBER REJEKI</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
      body {
        font-family: "Segoe UI", Roboto, sans-serif;
        background-color: #f8f9fa;
      }

      /* --- STYLE NAVBAR ANDA --- */
      .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      }
      .navbar .navbar-nav .nav-link {
        font-size: 0.85rem !important; 
        font-weight: 600 !important;
        color: #333 !important;
        text-transform: uppercase;
        transition: all 0.3s ease-in-out;
        display: inline-block;
        padding: 10px 15px !important; 
      }
      .navbar .navbar-nav .nav-link:not(.btn-login):hover {
        color: #000 !important;
        transform: scale(1.1); 
        text-decoration: underline !important;
        text-underline-offset: 6px;
        text-decoration-thickness: 2px;
      }
      .navbar .navbar-nav .nav-link.btn-login {
        background-color: #ced4da !important;
        border-radius: 20px;
        padding: 5px 20px !important;
        font-weight: bold !important;
        transform: none !important; 
      }

      /* --- STYLE FOOTER ASLI ANDA --- */
      footer {
        background-color: #0e2052;
        padding: 40px 0 20px 0;
        color: #ffffff;
        position: relative; 
        z-index: 10; 
      }
      .footer-container {
        width: 90%; max-width: 1100px; margin: 0 auto;
        display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px;
      }
      .footer-brand { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 250px; }
      .footer-brand img { height: 65px; }
      .footer-brand span { font-weight: bold; font-size: 13px; color: #ffffff; }
      .footer-links { flex: 0.5; min-width: 120px; }
      .footer-links h4 { font-size: 14px; margin-bottom: 12px; font-weight: 900; }
      .footer-links ul { list-style: none; padding: 0; }
      .footer-links li { font-size: 11px; margin-bottom: 5px; font-weight: 700; }
      .footer-links a { color: #ffffff; text-decoration: none; }
      .footer-info { flex: 1; min-width: 200px; }
      .footer-info h4 { font-size: 16px; margin-bottom: 12px; font-weight: 900; }
      .footer-social { display: flex; gap: 15px; align-items: center; }
      .footer-social img { height: 45px; cursor: pointer; }
      .footer-bottom {
        width: 90%; max-width: 1100px; margin: 30px auto 0; padding-top: 15px;
        border-top: 1px solid #bbb; text-align: center; font-size: 12px; font-weight: bold;
      }

      /* Watermark Background */
      .watermark-bg {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.03;
        z-index: -1;
        width: 60%;
      }
    </style>
</head>
<body>
    <img src="/project itik 2/pictures/logo.png" class="watermark-bg" alt="Logo Watermark">

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/project itik 2/index.php">
                <img src="/project itik 2/pictures/logo.png" alt="Logo" style="height: 40px; margin-right: 10px;">
                <span class="fw-bold" style="font-size: 0.8rem;">UD. SUMBER REJEKI</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php $role = isset($_SESSION["role"])
                        ? $_SESSION["role"]
                        : ""; ?>
                    
                    <?php if ($role === "admin"): ?>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/product.php">PRODUCT</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/aksesAdmin/admin_ulasan.php">PESAN</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/profil.php">PROFIL SAYA</a></li> 
                        <li class="nav-item">
                            <a href="/project itik 2/aksesAdmin/rekap.php" class="btn btn-danger btn-sm text-white fw-bold px-3 ms-2 rounded-pill" style="font-size: 0.75rem;">REKAP PENJUALAN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-bold" href="/project itik 2/aksesAdmin/tambah_admin.php">
                                <i class="fa-solid fa-user-plus me-1"></i> Tambah Admin
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link text-danger fw-bold" href="/project itik 2/logout.php" style="font-size: 0.75rem;"><i class="bi bi-box-arrow-right"></i> LOGOUT</a>
                        </li>

                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/index.php">HOME</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/aboutus.php">ABOUT US</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/product.php">PRODUCT</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/mitra.php">MITRA</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/PesanKesan.php">PESAN</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project itik 2/contact.php">CONTACT US</a></li>

                        <?php if (isset($_SESSION["id_pelanggan"])): ?>
                            <li class="nav-item"><a class="nav-link" href="/project itik 2/profil.php">PROFIL SAYA</a></li>
                            <li class="nav-item">
                                <a href="/project itik 2/aksesPelanggan/history.php" class="btn btn-warning btn-sm text-dark fw-bold px-3 ms-2 rounded-pill" style="font-size: 0.75rem;">HISTORY</a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="nav-link text-danger fw-bold" href="/project itik 2/logout.php" style="font-size: 0.75rem;"><i class="bi bi-box-arrow-right"></i> LOGOUT</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-2"><a class="nav-link btn-login" href="/project itik 2/login.php">LOGIN</a></li>
                            <li class="nav-item ms-2"><a class="nav-link btn-login" href="/project itik 2/register.php">REGISTER</a></li>
                        <?php endif; ?>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>