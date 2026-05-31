<?php
session_start();
include "koneksiDB/koneksi.php";

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: index.php");
        exit();
    } elseif ($_SESSION["role"] === "pelanggan") {
        header("Location: index.php");
        exit();
    }
}

$step = 1; // Step 1: Validasi data diri, Step 2: Input password baru
$error_message = "";
$success_message = "";
$verified_username = "";

// PROSES STEP 1: VERIFIKASI DATA IDENTITAS USER
if (isset($_POST["verifikasi_data"])) {
    $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $no_hp = mysqli_real_escape_string($conn, trim($_POST["no_hp"]));

    // Ambil data pelanggan yang COCOK KETIGA-TIGANYA (Mencegah brute force asal tebak)
    $query = "SELECT * FROM pelanggan WHERE username='$username' AND email='$email' AND no_hp='$no_hp'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $step = 2;
        $verified_username = $username;
    } else {
        $error_message =
            "Data tidak cocok dengan rekaman kami. Pastikan Username, Email, dan No WhatsApp benar!";
    }
}

// PROSES STEP 2: UPDATE PASSWORD BARU KE DATABASE
if (isset($_POST["ubah_password"])) {
    $username = mysqli_real_escape_string($conn, $_POST["verified_username"]);
    $password_baru = $_POST["password_baru"];
    $konfirmasi_password = $_POST["konfirmasi_password"];

    if (strlen($password_baru) < 5) {
        $error_message = "Password baru minimal harus 5 karakter!";
        $step = 2;
        $verified_username = $username;
    } elseif ($password_baru !== $konfirmasi_password) {
        $error_message = "Konfirmasi password tidak sesuai!";
        $step = 2;
        $verified_username = $username;
    } else {
        // Enkripsi password menggunakan bcrypt standar PHP (Sangat Aman)
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

        $update_query = "UPDATE pelanggan SET password='$password_hash' WHERE username='$username'";
        if (mysqli_query($conn, $update_query)) {
            $success_message =
                "Password Anda berhasil diperbarui! Silakan kembali login.";
            $step = 3; // Selesai
        } else {
            $error_message = "Gagal memperbarui password database.";
            $step = 2;
            $verified_username = $username;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - UD. Sumber Rejeki</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --cream: #fdf6e3;
            --orange: #ff9f43;
            --navy: #2c3e50;
            --mint: #2ecc71;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Quicksand', sans-serif; }

        body { display: flex; flex-direction: row; min-height: 100vh; background-color: var(--cream); overflow-x: hidden; }

        /* --- Kiri: Area Form --- */
        .left-side { flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px; position: relative; z-index: 10; }
        .form-container { background: #ffffff; padding: 40px 30px; border-radius: 24px; width: 100%; max-width: 420px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .header-icon { font-size: 50px; text-align: center; margin-bottom: 15px; color: var(--orange); animation: pulse 2s infinite ease-in-out; }
        .form-container h2 { color: var(--navy); text-align: center; font-size: 24px; margin-bottom: 8px; font-weight: 700; }
        .form-container p { color: #7f8c8d; text-align: center; font-size: 14px; margin-bottom: 25px; font-weight: 600; line-height: 1.5; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; color: var(--navy); font-size: 14px; font-weight: 700; margin-bottom: 8px; }
        .input-group input { width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid #e1e8ed; font-size: 15px; outline: none; transition: 0.3s; background-color: #f8f9fa; font-weight: 600; }
        .input-group input:focus { border-color: var(--orange); background-color: #fff; box-shadow: 0 0 0 4px rgba(255, 159, 67, 0.15); }
        
        .password-wrapper { position: relative; width: 100%; }
        .password-wrapper input { padding-right: 50px; }
        
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
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--navy);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .back-link:hover { color: var(--orange); }

        /* Alert Box */
        .alert { padding: 14px 18px; border-radius: 12px; font-size: 14px; font-weight: 600; margin-bottom: 20px; line-height: 1.5; display: flex; align-items: center; gap: 10px; }
        .alert-danger { background-color: #fde8e8; color: #e74c3c; border-left: 5px solid #e74c3c; }
        .alert-success { background-color: #edfbf7; color: var(--mint); border-left: 5px solid var(--mint); }

        /* --- Kanan: Area Gambar & Dekorasi --- */
        .right-side { flex: 1; background-color: var(--navy); display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px; position: relative; overflow: hidden; }
        .right-side::before { content: ''; position: absolute; width: 600px; height: 600px; background: rgba(255, 159, 67, 0.05); border-radius: 50%; top: -100px; right: -100px; }
        .promo-content { text-align: center; color: white; z-index: 5; max-width: 420px; }
        .main-image-container { font-size: 90px; margin-bottom: 20px; animation: bounce 3s infinite ease-in-out; background: rgba(255,255,255,0.1); width: 180px; height: 180px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 30px; border: 4px dashed var(--orange); }
        .promo-content h3 { font-size: 30px; color: var(--orange); margin-bottom: 15px; line-height: 1.3; font-weight: 700; }
        .promo-content p { font-size: 16px; line-height: 1.6; color: #d1d8e0; font-weight: 500; }

        /* Animasi */
        .floating-deco { position: absolute; opacity: 0.6; animation: floatAround 6s infinite ease-in-out; z-index: 1; }
        .deco-1 { top: 15%; left: 15%; font-size: 55px; }
        .deco-2 { top: 20%; right: 15%; font-size: 45px; animation-delay: 1.5s; }
        .deco-3 { bottom: 15%; left: 20%; font-size: 50px; animation-delay: 2.5s; }
        .deco-4 { bottom: 25%; right: 20%; font-size: 40px; animation-delay: 0.5s; }

        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        @keyframes floatAround { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(10deg); } }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-side, .right-side { flex: none; width: 100%; padding: 20px; }
            .right-side { order: -1; min-height: 280px; }
            .main-image-container { width: 130px; height: 130px; font-size: 60px; margin-bottom: 15px; }
            .promo-content h3 { font-size: 24px; }
        }
    </style>
</head>
<body>

    <!-- SISI KIRI: KONTEN UTAMA / FORM -->
    <div class="left-side">
        <div class="form-container">
            <a href="login.php" class="back-link">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </a>
            
            <!-- STEP 1: VERIFIKASI DATA -->
            <?php if ($step == 1): ?>
                <div class="header-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <h2>Pemulihan Sandi</h2>
                <p>Masukkan data akun terdaftar untuk memverifikasi kepemilikan sah Anda.</p>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?= $error_message ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="input-group">
                        <label>Username Anda</label>
                        <input type="text" name="username" placeholder="Masukkan username" value="<?= isset(
                            $_POST["username"],
                        )
                            ? htmlspecialchars($_POST["username"])
                            : "" ?>" required autocomplete="off">
                    </div>
                    <div class="input-group">
                        <label>Alamat Email Terdaftar</label>
                        <input type="email" name="email" placeholder="contoh@email.com" value="<?= isset(
                            $_POST["email"],
                        )
                            ? htmlspecialchars($_POST["email"])
                            : "" ?>" required autocomplete="off">
                    </div>
                    <div class="input-group">
                        <label>Nomor WhatsApp Terdaftar</label>
                        <input type="text" name="no_hp" placeholder="Contoh: 0822xxxx" value="<?= isset(
                            $_POST["no_hp"],
                        )
                            ? htmlspecialchars($_POST["no_hp"])
                            : "" ?>" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <button type="submit" name="verifikasi_data" class="btn-submit">Verifikasi Identitas</button>
                </form>

            <!-- STEP 2: INPUT PASSWORD BARU -->
            <?php elseif ($step == 2): ?>
                <div class="header-icon" style="color: var(--mint);"><i class="bi bi-patch-check-fill"></i></div>
                <h2>Verifikasi Lolos!</h2>
                <p>Identitas cocok. Buat password baru yang aman untuk akun <strong><?= htmlspecialchars(
                    $verified_username,
                ) ?></strong>.</p>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?= $error_message ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="verified_username" value="<?= htmlspecialchars(
                        $verified_username,
                    ) ?>">
                    
                    <div class="input-group">
                        <label>Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="pass1" name="password_baru" placeholder="Minimal 5 karakter" minlength="5" required>
                            <i class="bi bi-eye-slash toggle-password" onclick="toggleView('pass1', this)"></i>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="pass2" name="konfirmasi_password" placeholder="Ulangi password baru" minlength="5" required>
                            <i class="bi bi-eye-slash toggle-password" onclick="toggleView('pass2', this)"></i>
                        </div>
                    </div>
                    
                    <button type="submit" name="ubah_password" class="btn-submit">Perbarui Password</button>
                </form>

            <!-- STEP 3: SELESAI -->
            <?php elseif ($step == 3): ?>
                <div class="header-icon" style="color: var(--mint);"><i class="bi bi-check-circle-fill"></i></div>
                <h2>Sandi Diperbarui!</h2>
                <p><?= $success_message ?></p>
                <a href="login.php" style="text-decoration: none;">
                    <button class="btn-submit" style="background-color: var(--navy);">Masuk Sekarang</button>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- SISI KANAN: BRANDING & DEKORASI -->
    <div class="right-side">
        <div class="floating-deco deco-1">🐥</div>
        <div class="floating-deco deco-2">🍗</div>
        <div class="floating-deco deco-3">🦆</div>
        <div class="floating-deco deco-4">🔑</div>
        <div class="promo-content">
            <div class="main-image-container">🛡️🦆</div>
            <h3>Keamanan Akun Anda</h3>
            <p>Sistem kami menjaga ketat kerahasiaan data pelanggan demi kenyamanan bertransaksi di UD. Sumber Rejeki.</p>
        </div>
    </div>

    <script>
        function toggleView(inputId, iconEl) {
            const targetInput = document.getElementById(inputId);
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                iconEl.classList.remove('bi-eye-slash');
                iconEl.classList.add('bi-eye');
            } else {
                targetInput.type = 'password';
                iconEl.classList.remove('bi-eye');
                iconEl.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>
</html>