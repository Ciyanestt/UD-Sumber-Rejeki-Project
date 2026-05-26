<?php
session_start();
include "koneksiDB/koneksi.php";

// Proteksi: Cek apakah user sudah login
if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

$alert_script = ""; // Variabel untuk menampung script SweetAlert

if (isset($_POST["update_password"])) {
    $password_baru = $_POST["password_baru"];
    $konfirmasi = $_POST["konfirmasi_password"];
    $role = $_SESSION["role"];

    if ($password_baru !== $konfirmasi) {
        // Pop-up jika password tidak cocok
        $alert_script = "
            Swal.fire({
                title: 'Gagal!',
                text: 'Konfirmasi password tidak cocok. Silakan coba lagi.',
                icon: 'error',
                confirmButtonColor: '#e11d48',
                confirmButtonText: '<i class=\"fa-solid fa-rotate-right me-1\"></i> Coba Lagi',
                customClass: { 
                    popup: 'custom-swal-popup',
                    confirmButton: 'custom-swal-button'
                }
            });
        ";
    } else {
        // Enkripsi password
        $pass_final = password_hash($password_baru, PASSWORD_DEFAULT);

        if ($role === 'admin') {
            $id = $_SESSION["id_admin"];
            $query = "UPDATE admin SET password = '$pass_final' WHERE id_admin = '$id'";
        } else {
            $id = $_SESSION["id_pelanggan"];
            $query = "UPDATE pelanggan SET password = '$pass_final' WHERE id_pelanggan = '$id'";
        }

        if (mysqli_query($conn, $query)) {
            // Pop-up jika sukses, lalu redirect
            $alert_script = "
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Password Anda berhasil diperbarui dengan aman.',
                    icon: 'success',
                    confirmButtonColor: '#0a1d37',
                    confirmButtonText: '<i class=\"fa-solid fa-check me-1\"></i> Lanjutkan',
                    customClass: { 
                        popup: 'custom-swal-popup',
                        confirmButton: 'custom-swal-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'profil.php';
                    }
                });
            ";
        } else {
            $error_db = mysqli_error($conn);
            $alert_script = "
                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mengubah password: $error_db',
                    icon: 'error',
                    confirmButtonColor: '#e11d48',
                    customClass: { 
                        popup: 'custom-swal-popup',
                        confirmButton: 'custom-swal-button'
                    }
                });
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - UD. SUMBER REJEKI</title>
    
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
            position: relative;
            overflow-x: hidden;
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

        /* --- KARTU ELEGAN --- */
        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 40px rgba(10, 29, 55, 0.08);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        /* Watermark Bebek Subtle di dalam Kartu */
        .auth-card::before {
            content: '\f520'; /* FontAwesome Crow/Bird icon */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 10%;
            left: -10%;
            font-size: 12rem;
            color: rgba(255, 159, 28, 0.03);
            transform: rotate(15deg);
            z-index: 0;
            pointer-events: none;
        }

        .card-header-custom {
            background: var(--navy-gradient);
            padding: 40px 30px;
            text-align: center;
            border-bottom: 4px solid var(--accent-orange);
            position: relative;
        }

        .header-icon-wrapper {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255,255,255,0.2);
            color: var(--accent-orange);
            font-size: 2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .header-title {
            color: #ffffff;
            font-weight: 800;
            margin: 0;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        /* --- FORM STYLING --- */
        .form-section {
            position: relative;
            z-index: 2;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid var(--border-light);
            background-color: #f8fafc;
            font-weight: 500;
            transition: all 0.3s;
            color: var(--text-main);
        }

        .form-control:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 4px rgba(255, 159, 28, 0.15);
            background-color: #ffffff;
            outline: none;
        }

        /* --- BUTTONS --- */
        .btn-custom {
            font-weight: 700;
            padding: 12px 20px;
            border-radius: 12px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .btn-light-custom {
            background-color: #ffffff;
            color: var(--text-muted);
            border: 2px solid var(--border-light);
            text-decoration: none;
        }

        .btn-light-custom:hover {
            background-color: var(--bg-light);
            color: var(--text-main);
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        /* --- SWEETALERT CUSTOM STYLING --- */
        .custom-swal-popup {
            font-family: 'Montserrat', sans-serif !important;
            border-radius: 20px !important;
            padding-bottom: 25px !important;
        }
        .custom-swal-button {
            border-radius: 10px !important;
            font-weight: 700 !important;
            padding: 10px 24px !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
        }

        /* Animasi masuk */
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
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
        <div class="col-lg-5 col-md-7 col-sm-9">
            
            <div class="auth-card fade-in-up">
                
                <div class="card-header-custom">
                    <div class="header-icon-wrapper">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="header-title">Ubah Password</h4>
                </div>

                <div class="card-body p-4 p-md-5 form-section">
                    <p class="text-center text-muted mb-4" style="font-size: 0.9rem; font-weight: 500;">
                        Silakan masukkan password baru Anda. Pastikan kombinasi sulit ditebak untuk menjaga keamanan akun.
                    </p>
                    
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fa-solid fa-key me-1"></i> Password Baru
                            </label>
                            <input type="password" name="password_baru" class="form-control" placeholder="Minimal 5 karakter" required minlength="5">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fa-solid fa-check-double me-1"></i> Konfirmasi Password
                            </label>
                            <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password baru" required minlength="5">
                        </div>
                        
                        <div class="d-grid gap-3 mt-5">
                            <button type="submit" name="update_password" class="btn-custom btn-primary-custom">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                            </button>
                            <a href="profil.php" class="btn-custom btn-light-custom text-center">
                                Batal & Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($alert_script)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?= $alert_script ?>
    });
</script>
<?php endif; ?>

</body>
</html>