<?php
session_start();
include "koneksiDB/koneksi.php";

// Proteksi Halaman Login
if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: index.php");
        exit();
    } elseif ($_SESSION["role"] === "pelanggan") {
        header("Location: index.php");
        exit();
    }
}

$login_success = false;
$login_error = false; // Variabel penanda jika login gagal
$user_display_name = "";

if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
    $password = trim($_POST["password"]);

    // 1. CEK KE TABEL ADMIN
    $query_admin = "SELECT * FROM admin WHERE username='$username'";
    $result_admin = mysqli_query($conn, $query_admin);

    if (mysqli_num_rows($result_admin) > 0) {
        $data_admin = mysqli_fetch_assoc($result_admin);
        $db_password = trim($data_admin["password"]);

        if (
            $password === $db_password ||
            password_verify($password, $db_password)
        ) {
            $_SESSION["role"] = "admin";
            $_SESSION["id_admin"] = $data_admin["id_admin"];
            $_SESSION["username"] = $data_admin["username"];
            $user_display_name = $data_admin["nama_lengkap"];
            $login_success = true;
        }
    }

    // 2. CEK AKSES PELANGGAN
    if (!$login_success) {
        $query_pelanggan = "SELECT * FROM pelanggan WHERE username='$username'";
        $result_p = mysqli_query($conn, $query_pelanggan);

        if (mysqli_num_rows($result_p) > 0) {
            $data_p = mysqli_fetch_assoc($result_p);
            $db_pass_p = trim($data_p["password"]);

            if (
                password_verify($password, $db_pass_p) ||
                $password === $db_pass_p
            ) {
                $_SESSION["role"] = "pelanggan";
                $_SESSION["id_pelanggan"] = $data_p["id_pelanggan"];
                $_SESSION["username"] = $data_p["username"];
                $user_display_name = $data_p["username"];
                $login_success = true;
            }
        }
    }

    // 3. AKUN CADANGAN
    if (
        !$login_success &&
        $username === "Admin Ud Sumber Rejeki" &&
        $password === "admin12345"
    ) {
        $check_empty = mysqli_query($conn, "SELECT id_admin FROM admin");
        if (mysqli_num_rows($check_empty) == 0) {
            $_SESSION["role"] = "admin";
            $_SESSION["username"] = "Admin Awal";
            $user_display_name = "Admin Utama";
            $login_success = true;
        }
    }

    // Jika gagal, set flag error menjadi true
    if (!$login_success) {
        $login_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UD. Sumber Rejeki</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --cream: #fdf6e3;
            --orange: #ff9f43;
            --navy: #2c3e50;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Quicksand', sans-serif; }

        body { display: flex; flex-direction: row; min-height: 100vh; background-color: var(--cream); overflow-x: hidden; position: relative; }

        /* --- Kiri: Area Form --- */
        .left-side { flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px; position: relative; z-index: 10; }
        .form-container { background: #ffffff; padding: 40px 30px; border-radius: 24px; width: 100%; max-width: 420px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .header-logo { font-size: 50px; text-align: center; margin-bottom: 10px; }
        .form-container h2 { color: var(--navy); text-align: center; font-size: 26px; margin-bottom: 8px; font-weight: 700; }
        .form-container p { color: #7f8c8d; text-align: center; font-size: 15px; margin-bottom: 30px; font-weight: 600; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; color: var(--navy); font-size: 14px; font-weight: 700; margin-bottom: 8px; }
        
        .password-wrapper { position: relative; width: 100%; }
        
        .input-group input { width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid #e1e8ed; font-size: 15px; outline: none; transition: 0.3s; background-color: #f8f9fa; font-weight: 600; }
        .password-wrapper input { padding-right: 50px; }
        .input-group input:focus { border-color: var(--orange); background-color: #fff; box-shadow: 0 0 0 4px rgba(255, 159, 67, 0.15); }
        
        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            font-size: 18px;
            transition: color 0.2s ease;
            user-select: none;
        }
        .toggle-password:hover { color: var(--orange); }

        .btn-submit { width: 100%; padding: 15px; background-color: var(--orange); color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-submit:hover { background-color: #f38f31; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(255, 159, 67, 0.3); }
        
        /* Tambahan Style Lupa Password */
        .forgot-password-link { text-align: right; margin-top: 12px; font-size: 13px; font-weight: 600; }
        .forgot-password-link a { color: #95a5a6; text-decoration: none; transition: 0.2s; }
        .forgot-password-link a:hover { color: #e74c3c; text-decoration: underline; }

        .footer-link { text-align: center; margin-top: 25px; font-size: 14px; color: var(--navy); font-weight: 600; }
        .footer-link a { color: var(--orange); text-decoration: none; font-weight: 700; }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--navy);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .back-link:hover { color: var(--orange); }

        /* --- Kanan: Area Gambar --- */
        .right-side { flex: 1; background-color: var(--navy); display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px; position: relative; overflow: hidden; }
        .right-side::before { content: ''; position: absolute; width: 600px; height: 600px; background: rgba(255, 159, 67, 0.05); border-radius: 50%; top: -100px; right: -100px; }
        .promo-content { text-align: center; color: white; z-index: 5; max-width: 420px; }
        .main-image-container { font-size: 100px; margin-bottom: 20px; animation: bounce 3s infinite ease-in-out; background: rgba(255,255,255,0.1); width: 200px; height: 200px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 30px; border: 4px dashed var(--orange); }
        .promo-content h3 { font-size: 32px; color: var(--orange); margin-bottom: 15px; line-height: 1.3; font-weight: 700; }
        .promo-content p { font-size: 16px; line-height: 1.6; color: #d1d8e0; font-weight: 500; }

        /* Animasi Melayang */
        .floating-deco { position: absolute; opacity: 0.7; animation: floatAround 6s infinite ease-in-out; z-index: 1; }
        .deco-1 { top: 15%; left: 15%; font-size: 60px; }
        .deco-2 { top: 20%; right: 15%; font-size: 50px; animation-delay: 1.5s; }
        .deco-3 { bottom: 15%; left: 20%; font-size: 55px; animation-delay: 2.5s; }
        .deco-4 { bottom: 25%; right: 20%; font-size: 45px; animation-delay: 0.5s; }

        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        @keyframes floatAround { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-25px) rotate(15deg); } }

        /* --- Loading Screen --- */
        #success-loading-screen { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: var(--cream); display: flex; flex-direction: column; justify-content: center; align-items: center; z-index: 9999; opacity: 0; visibility: hidden; transition: opacity 0.4s ease, visibility 0.4s ease; }
        #success-loading-screen.active { opacity: 1; visibility: visible; }
        .loading-logo { width: 120px; height: 120px; border-radius: 50%; margin-bottom: 20px; animation: pulseLucu 1.5s infinite ease-in-out; display: flex; align-items: center; justify-content: center; background: white; font-size: 60px; }
        .success-title { color: var(--orange); font-size: 28px; margin-bottom: 10px; font-weight: 700; }
        .success-text { color: var(--navy); font-size: 16px; font-weight: 600; }
        .dots::after { content: ''; animation: loadingDots 1.5s infinite; }

        @keyframes pulseLucu { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        @keyframes loadingDots { 0% { content: '.'; } 33% { content: '..'; } 66% { content: '...'; } 100% { content: ''; } }

        /* --- Kustomisasi SweetAlert2 Tema Bebek --- */
        .duck-swal-popup {
            font-family: 'Quicksand', sans-serif !important;
            border-radius: 24px !important;
            padding: 30px !important;
            box-shadow: 0 15px 30px rgba(44, 62, 80, 0.12) !important;
        }
        .duck-swal-title { font-weight: 700 !important; font-size: 22px !important; }
        .duck-swal-html { font-weight: 600 !important; font-size: 15px !important; }
        .duck-swal-btn { border-radius: 12px !important; font-weight: 700 !important; padding: 12px 30px !important; font-size: 15px !important; transition: 0.2s ease !important; }
        .duck-swal-btn:hover { transform: translateY(-1px); }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-side, .right-side { flex: none; width: 100%; padding: 20px; }
            .right-side { order: -1; min-height: 300px; }
        }
    </style>
</head>
<body>

    <div class="left-side">
        <div class="form-container">
            <a href="index.php" class="back-link">
                <span>⬅</span> Beranda
            </a>
            <div class="header-logo">🦆</div>
            <h2>Selamat Datang!</h2>
            <p>Silakan masuk ke akunmu</p>

            <form id="loginForm" method="POST" action="">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" value="<?php echo isset(
                        $_POST["username"],
                    )
                        ? htmlspecialchars($_POST["username"])
                        : ""; ?>" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                        <i class="bi bi-eye-slash toggle-password" id="eyeIcon"></i>
                    </div>
                </div>
                <button type="submit" name="login" class="btn-submit">Login</button>
                
                <div class="forgot-password-link">
                    <a href="lupa_password.php"><i class="bi bi-shield-lock"></i> Lupa Password?</a>
                </div>
            </form>

            <div class="footer-link">
                Belum punya akun? <br> <a href="register.php">Daftar di sini</a>
            </div>
        </div>
    </div>

    <div class="right-side">
        <div class="floating-deco deco-1">🐥</div>
        <div class="floating-deco deco-2">🍗</div>
        <div class="floating-deco deco-3">🦆</div>
        <div class="floating-deco deco-4">🍖</div>
        <div class="promo-content">
            <div class="main-image-container">🦆🍗</div>
            <h3>Bebek Potong Segar!</h3>
            <p>Daging super empuk, potong setiap hari, dan higienis.</p>
        </div>
    </div>

    <div id="success-loading-screen">
        <div class="loading-logo">🦆</div>
        <h2 class="success-title" id="welcome-message">Login Berhasil!</h2>
        <p class="success-text">Membawa kamu ke halaman utama<span class="dots"></span></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('loginPassword');
            const eyeIcon = document.getElementById('eyeIcon');

            eyeIcon.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                }
            });

            <?php if ($login_error): ?>
                Swal.fire({
                    title: 'Gagal Masuk',
                    text: 'Username atau password salah. Coba periksa kembali Username dan Password anda!',
                    icon: 'error',
                    iconColor: '#e74c3c',
                    background: '#fdf6e3',
                    color: '#2c3e50',
                    confirmButtonColor: '#ff9f43',
                    confirmButtonText: 'Coba Lagi',
                    backdrop: `rgba(44, 62, 80, 0.4)`,
                    customClass: {
                        popup: 'duck-swal-popup',
                        title: 'duck-swal-title',
                        htmlContainer: 'duck-swal-html',
                        confirmButton: 'duck-swal-btn'
                    },
                    showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
                    hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' }
                });
            <?php endif; ?>

            <?php if ($login_success): ?>
                const loadingScreen = document.getElementById('success-loading-screen');
                const welcomeMessage = document.getElementById('welcome-message');
                
                welcomeMessage.innerText = "Halo, <?php echo $user_display_name; ?>!";
                loadingScreen.classList.add('active');

                setTimeout(function() {
                    <?php if (
                        isset($_SESSION["role"]) &&
                        $_SESSION["role"] === "admin"
                    ): ?>
                        window.location.href = 'product.php'; 
                    <?php else: ?>
                        window.location.href = 'index.php'; 
                    <?php endif; ?>
                }, 2500);
            <?php endif; ?>
        });
    </script>
</body>
</html>