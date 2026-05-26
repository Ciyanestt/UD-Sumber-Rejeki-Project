<?php
session_start();
// Pastikan file koneksi sudah benar path-nya
include "koneksiDB/koneksi.php";

// 1. PROTEKSI HALAMAN: Hanya admin yang bisa mengakses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST["tambah_admin"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama_lengkap"]);
    $user = mysqli_real_escape_string($conn, $_POST["username"]);
    $pass = $_POST["password"]; 
    // Catatan: Jika sistem login Anda memakai hash, ganti baris di atas menjadi: 
    // $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $cek_user = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$user'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Gagal! Username tersebut sudah terdaftar.');</script>";
    } else {
        // Simpan ke tabel admin
        $query = "INSERT INTO admin (nama_lengkap, username, password) VALUES ('$nama', '$user', '$pass')";
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Sukses! Admin baru berhasil ditambahkan.');
                    window.location.href = 'rekap.php'; 
                  </script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin - UD. SUMBER REJEKI</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-orange: #ff9f1c;
            --dark-orange: #eeb252;
            --navy-dark: #0a1d37;
            --bg-light: #f4f7f6;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-light);
            background-image: radial-gradient(circle at 10% 20%, rgba(10, 29, 55, 0.05) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(255, 159, 28, 0.05) 0%, transparent 20%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- SPLIT CARD DESIGN --- */
        .admin-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        /* Sisi Kiri (Branding) */
        .card-sidebar {
            background: linear-gradient(145deg, var(--navy-dark) 0%, #16325c 100%);
            color: #fff;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .card-sidebar::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: var(--primary-orange);
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
        }

        .sidebar-icon {
            font-size: 3rem;
            color: var(--primary-orange);
            margin-bottom: 20px;
        }

        /* Sisi Kanan (Form) */
        .card-form-area {
            padding: 50px;
        }

        .form-title {
            font-weight: 800;
            color: var(--navy-dark);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .form-subtitle {
            color: #777;
            font-size: 0.95rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Kustomisasi Input */
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-right: none;
            color: var(--navy-dark);
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-left: none;
            padding: 12px 15px;
            font-weight: 500;
            color: var(--navy-dark);
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-orange);
        }

        /* Tombol Toggle Password */
        .password-toggle {
            cursor: pointer;
            background-color: transparent;
            border: 1px solid #e0e0e0;
            border-left: none;
            color: #888;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 0 15px;
            display: flex;
            align-items: center;
        }

        /* Tombol Submit */
        .btn-submit {
            background-color: var(--primary-orange);
            color: var(--navy-dark);
            font-weight: 700;
            padding: 14px;
            border-radius: 12px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(255, 159, 28, 0.2);
        }

        .btn-submit:hover {
            background-color: var(--dark-orange);
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(255, 159, 28, 0.3);
            color: #fff;
        }

        .btn-back {
            color: #6c757d;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: var(--navy-dark);
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .card-sidebar { padding: 40px 30px; text-align: center; }
            .card-form-area { padding: 40px 30px; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            <div class="admin-card">
                <div class="row g-0">
                    <div class="col-md-5 card-sidebar d-none d-md-flex">
                        <div class="relative z-2">
                            <i class="fa-solid fa-user-shield sidebar-icon"></i>
                            <h3 class="fw-bold mb-3">Registrasi<br>Admin Baru</h3>
                            <p style="font-size: 0.95rem; line-height: 1.7; opacity: 0.9;">
                                Tambahkan akun administrator baru untuk mengelola data master, rekap transaksi, dan operasional website <strong>UD. Sumber Rejeki</strong>.
                            </p>
                            <div class="mt-4 pt-3 border-top border-secondary">
                                <small class="text-uppercase" style="letter-spacing: 2px; color: var(--primary-orange);">Secure System Area</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 card-form-area">
                        <div class="text-md-start text-center mb-4 pb-2">
                            <h2 class="form-title">Buat Akun</h2>
                            <p class="form-subtitle">Lengkapi formulir di bawah ini dengan benar.</p>
                        </div>

                        <form method="POST" action="">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted mb-2">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
                                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama asli" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted mb-2">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Tentukan username" required>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label small fw-bold text-muted mb-2">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" id="adminPassword" class="form-control" placeholder="••••••••" required>
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i class="fa-regular fa-eye-slash" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="tambah_admin" class="btn-submit">
                                    <i class="fa-solid fa-user-plus ms-1 me-2"></i> Daftarkan Admin
                                </button>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="rekap.php" class="btn-back">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Rekap
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("adminPassword");
        const toggleIcon = document.getElementById("toggleIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>