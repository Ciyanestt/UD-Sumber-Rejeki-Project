<?php
session_start();
include "koneksiDB/koneksi.php";

// 1. Cek apakah user sudah login
if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];

// 2. Ambil data detail dari database berdasarkan role dan tabel masing-masing
if ($role === 'admin') {
    $id_admin = $_SESSION["id_admin"];
    $query = mysqli_query($conn, "SELECT nama_lengkap, username, password FROM admin WHERE id_admin = '$id_admin'");
} else {
    $id_pelanggan = $_SESSION["id_pelanggan"];
    $query = mysqli_query($conn, "SELECT nama_lengkap, username, password, no_hp, email, alamat_lengkap, role FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");
}

$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan di database
if (!$data) {
    echo "Data profil tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - UD. SUMBER REJEKI</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-navy: #0a1d37;
            --navy-gradient: linear-gradient(135deg, #0a1d37 0%, #16325c 100%);
            --accent-orange: #ff9f1c;
            --bg-light: #f4f7f6;
            --text-main: #212529;
            --text-muted: #626e7c;
            --border-light: #e2e8f0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
            margin: 0;
        }

        /* --- BACKGROUND WATERMARK UTAMA --- */
        .bg-watermark {
            position: fixed;
            bottom: -50px;
            right: -50px;
            font-size: 40vw;
            color: rgba(0,0,0,0.02);
            z-index: -1;
            pointer-events: none;
        }

        /* --- KARTU PROFIL --- */
        .profile-card {
            background: #ffffff;
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 40px rgba(10, 29, 55, 0.08);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        /* Watermark Bebek Subtle di dalam Kartu */
        .profile-card::before {
            content: '\f520'; /* FontAwesome Crow/Bird icon as abstract duck */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 20%;
            right: -10%;
            font-size: 15rem;
            color: rgba(255, 159, 28, 0.03);
            transform: rotate(-15deg);
            z-index: 0;
            pointer-events: none;
        }

        /* --- HEADER KARTU --- */
        .profile-header {
            background: var(--navy-gradient);
            padding: 40px 30px 60px;
            text-align: center;
            position: relative;
            border-bottom: 4px solid var(--accent-orange);
        }

        .role-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        /* --- AVATAR PROFESIONAL --- */
        .avatar-wrapper {
            position: relative;
            margin: -50px auto 20px;
            width: 100px;
            height: 100px;
            z-index: 2;
        }

        .avatar-circle {
            width: 100%;
            height: 100%;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary-navy);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 4px solid #ffffff;
        }

        /* Unsur Bebek Subtle: Lencana Kecil */
        .duck-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--accent-orange);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 10px rgba(255, 159, 28, 0.3);
        }

        /* --- INFORMASI PENGGUNA --- */
        .profile-name {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-main);
            margin-bottom: 5px;
            text-align: center;
        }

        .profile-greeting {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 30px;
        }

        .info-section {
            position: relative;
            z-index: 2;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-light);
            transition: all 0.3s;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #f8fafc;
            color: var(--primary-navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-right: 15px;
        }

        .info-details {
            flex-grow: 1;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            display: block;
        }

        .info-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-main);
            margin: 0;
            word-break: break-word;
        }

        .btn-action {
            font-weight: 700;
            font-size: 0.9rem;
            padding: 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
            border: none;
        }

        .btn-primary-custom {
            background-color: var(--primary-navy);
            color: #ffffff;
        }

        .btn-primary-custom:hover {
            background-color: #16325c;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(10, 29, 55, 0.2);
        }

        .btn-danger-custom {
            background-color: #fff1f2;
            color: #e11d48;
            border: 1px solid #ffe4e6;
        }

        .btn-danger-custom:hover {
            background-color: #e11d48;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(225, 29, 72, 0.2);
        }

        /* Animasi masuk yang elegan (bukan mantul) */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<i class="fa-solid fa-feather bg-watermark"></i>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            
            <div class="profile-card fade-in-up">
                <div class="profile-header">
                    <div class="role-badge">
                        <i class="fa-solid fa-id-badge me-1"></i> Akun <?= ucfirst($role) ?>
                    </div>
                </div>

                <div class="px-4 pb-4 position-relative">
                    
                    <div class="avatar-wrapper">
                        <div class="avatar-circle">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="duck-badge" title="DuckFarm Member">
                            🦆
                        </div>
                    </div>

                    <h3 class="profile-name"><?= htmlspecialchars($data['nama_lengkap']) ?></h3>
                    <p class="profile-greeting">Selamat datang di Panel UD. Sumber Rejeki</p>

                    <div class="info-section mb-4">
                        <div class="info-row">
                            <div class="info-icon"><i class="fa-solid fa-at"></i></div>
                            <div class="info-details">
                                <span class="info-label">Username / ID</span>
                                <p class="info-value"><?= htmlspecialchars($data['username']) ?></p>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon"><i class="fa-solid fa-lock"></i></div>
                            <div class="info-details d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="info-label">Kata Sandi</span>
                                    <p class="info-value text-muted" style="letter-spacing: 3px; font-size: 1.2rem; line-height: 1;">••••••••</p>
                                </div>
                            </div>
                        </div>

                        <?php if ($role === 'pelanggan'): ?>
                            <div class="info-row">
                                <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                                <div class="info-details">
                                    <span class="info-label">Nomor WhatsApp</span>
                                    <p class="info-value"><?= htmlspecialchars($data['no_hp']) ?></p>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                                <div class="info-details">
                                    <span class="info-label">Alamat Email</span>
                                    <p class="info-value"><?= htmlspecialchars($data['email']) ?></p>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                                <div class="info-details">
                                    <span class="info-label">Alamat Lengkap</span>
                                    <p class="info-value" style="font-size: 0.85rem; line-height: 1.4;">
                                        <?= htmlspecialchars($data['alamat_lengkap']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row g-3 mt-2">
                            <div class="col-12">
                                <a href="edit_profil.php" class="btn-action btn-warning text-dark fw-bold w-100" style="background-color: var(--accent-orange); border-radius: 12px;">
                                    <i class="fa-solid fa-user-pen me-1"></i> Edit Informasi Profil
                                </a>
                            </div>
                            <div class="col-sm-7">
                                <a href="index.php" class="btn-action btn-primary-custom w-100">
                                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                                </a>
                            </div>
                            <div class="col-sm-5">
                                <a href="logout.php" class="btn-action btn-danger-custom w-100">
                                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                                </a>
                            </div>
                        </div>

                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>