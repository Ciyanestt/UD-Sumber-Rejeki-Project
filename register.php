<?php
include "koneksiDB/koneksi.php";

if (isset($_POST["register"])) {
    // Amankan input untuk mencegah SQL Injection
    $nama = mysqli_real_escape_string($conn, $_POST["nama_lengkap"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $telepon = mysqli_real_escape_string($conn, $_POST["telepon"]);
    $alamat = mysqli_real_escape_string($conn, $_POST["alamat_lengkap"]);
    $password_input = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Match Validation (PHP Side)
    if ($password_input !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit();
    }

    // Length Validation (PHP Side)
    if (strlen($password_input) < 8) {
        echo "<script>alert('Password minimal 8 karakter!'); window.history.back();</script>";
        exit();
    }

    // Enkripsi password
    $password = password_hash($password_input, PASSWORD_DEFAULT);

    // Cek apakah username sudah dipakai
    $cek_username = mysqli_query(
        $conn,
        "SELECT * FROM pelanggan WHERE username='$username'"
    );

    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username sudah terdaftar!'); window.history.back();</script>";
        exit();
    }

    // Eksekusi Insert dengan tambahan role 'pelanggan'
    $query = "INSERT INTO pelanggan (nama_lengkap, username, password, no_hp, email, alamat_lengkap, role) 
              VALUES ('$nama', '$username', '$password', '$telepon', '$email', '$alamat', 'pelanggan')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Pendaftaran Gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UD. Sumber Rejeki</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #fdf6e3;
            --orange: #ff9f43;
            --navy: #2c3e50;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Quicksand', sans-serif; }

        body { display: flex; flex-direction: row; min-height: 100vh; background-color: var(--cream); overflow-x: hidden; position: relative; }

        /* --- Kiri: Area Gambar Bebek --- */
        .left-side-promo {
            flex: 1; background-color: var(--navy); display: flex; flex-direction: column;
            justify-content: center; align-items: center; padding: 40px; position: relative; overflow: hidden;
        }

        .left-side-promo::before {
            content: ''; position: absolute; width: 600px; height: 600px;
            background: rgba(255, 159, 67, 0.05); border-radius: 50%; bottom: -100px; left: -100px;
        }

        .promo-content { text-align: center; color: white; z-index: 5; max-width: 420px; }
        
        .main-image-container {
            font-size: 90px; margin-bottom: 20px; animation: bounce 3s infinite ease-in-out;
            background: rgba(255,255,255,0.1); width: 200px; height: 200px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center; margin: 0 auto 30px;
            border: 4px dashed var(--orange);
        }

        .promo-content h3 { font-size: 32px; color: var(--orange); margin-bottom: 15px; line-height: 1.3; }
        .promo-content p { font-size: 16px; line-height: 1.6; color: #d1d8e0; }

        .floating-deco { position: absolute; opacity: 0.7; animation: floatAround 5s infinite ease-in-out; z-index: 1; }
        .deco-1 { top: 10%; right: 15%; animation-delay: 0.5s; font-size: 55px; transform: scaleX(-1); }
        .deco-2 { top: 25%; left: 10%; animation-delay: 2s; font-size: 45px; }
        .deco-3 { bottom: 20%; right: 10%; animation-delay: 1s; font-size: 60px; }
        .deco-4 { bottom: 10%; left: 20%; animation-delay: 3s; font-size: 50px; }

        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        @keyframes floatAround { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(-15deg); } }

        /* --- Kanan: Area Form Register --- */
        .right-side-form {
            flex: 1.2; display: flex; justify-content: center; align-items: center; padding: 40px; position: relative; z-index: 10;
        }

        .form-container {
            background: #ffffff; padding: 40px 30px; border-radius: 24px; width: 100%; max-width: 500px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        .form-container h2 { color: var(--navy); text-align: center; font-size: 26px; margin-bottom: 5px; }
        .form-container p { color: #7f8c8d; text-align: center; font-size: 14px; margin-bottom: 25px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .input-group { margin-bottom: 5px; }
        .full-width { grid-column: span 2; }

        .input-group label { display: block; color: var(--navy); font-size: 13px; font-weight: 700; margin-bottom: 6px; }
        .input-group input {
            width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #e1e8ed;
            font-size: 14px; outline: none; transition: 0.3s; background-color: #f8f9fa;
        }
        .input-group input:focus { border-color: var(--orange); background-color: #fff; }

        /* CSS Baru untuk Wrapper Password dan Icon Mata */
        .password-wrapper { position: relative; width: 100%; }
        .password-wrapper input { padding-right: 40px; }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 16px;
            user-select: none;
        }

        .btn-submit {
            width: 100%; padding: 15px; background-color: var(--orange); color: white;
            border: none; border-radius: 12px; font-size: 16px; font-weight: 700;
            cursor: pointer; transition: 0.3s; margin-top: 20px;
        }
        .btn-submit:hover { background-color: #f38f31; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(255, 159, 67, 0.3); }
        
        .back-to-home {
            display: inline-flex; align-items: center; gap: 8px; color: var(--navy);
            text-decoration: none; font-weight: 700; font-size: 14px; margin-bottom: 20px; transition: 0.3s;
        }
        .back-to-home:hover { color: var(--orange); transform: translateX(-5px); }
        
        .footer-link { text-align: center; margin-top: 20px; font-size: 14px; color: var(--navy); font-weight: 600; }
        .footer-link a { color: var(--orange); text-decoration: none; font-weight: 700; }

        /* --- CSS Notifikasi Custom (Toast) --- */
        .toast-notification {
            position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 12px;
            color: white; font-weight: 600; font-size: 15px; display: flex; align-items: center;
            gap: 10px; box-shadow: 0 10px 20px rgba(0,0,0,0.15); z-index: 9999;
            transform: translateX(150%); transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
        .toast-notification.show { transform: translateX(0); }
        .toast-success { background-color: #2ecc71; } 
        .toast-error { background-color: #e74c3c; }   

        @media (max-width: 768px) {
            .left-side-promo, .right-side-form { padding: 10px; }
            .form-container { padding: 20px 15px; }
            .form-grid { grid-template-columns: 1fr; gap: 8px; } 
            .full-width { grid-column: span 1; }
            .form-container h2 { font-size: 18px; }
            .form-container p { font-size: 11px; margin-bottom: 15px; }
            .input-group label { font-size: 11px; margin-bottom: 3px; }
            .input-group input { padding: 8px 10px; font-size: 12px; }
            .btn-submit { padding: 10px; font-size: 13px; margin-top: 10px; }
            .footer-link { font-size: 11px; margin-top: 10px; }
            .promo-content h3 { font-size: 16px; }
            .promo-content p { font-size: 11px; }
            .main-image-container { font-size: 40px; width: 80px; height: 80px; border-width: 2px; margin-bottom: 15px; }
            .floating-deco { font-size: 20px !important; } 
            .toast-notification { top: 10px; right: 10px; left: 10px; text-align: center; justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="left-side-promo">
        <div class="floating-deco deco-1">🐥</div>
        <div class="floating-deco deco-2">🍖</div>
        <div class="floating-deco deco-3">🦆</div>
        <div class="floating-deco deco-4">🍗</div>

        <div class="promo-content">
            <div class="main-image-container">
                📝🦆
            </div>
            <h3>Gabung Jadi Mitra!</h3>
            <p>Dapatkan harga spesial dan promo potongan harga untuk pembelian grosir.</p>
        </div>
    </div>

    <div class="right-side-form">
        <div class="form-container">
            <a href="index.php" class="back-to-home">
            <span>⬅</span> Kembali ke Beranda
        </a>
            <h2>Pendaftaran</h2>
            <p>Lengkapi data di bawah ini</p>

            <form id="formRegister" method="POST" action="" novalidate>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nama Lengkap <span style="color:red;">*</span></label>
                        <input type="text" id="regNama" name="nama_lengkap" placeholder="Nama Anda" required>
                    </div>
                    <div class="input-group">
                        <label>Username <span style="color:red;">*</span></label>
                        <input type="text" id="regUsername" name="username" placeholder="Pilih username" required>
                    </div>
                    <div class="input-group full-width">
                        <label>Email <span style="color:red;">*</span></label>
                        <input type="email" id="regEmail" name="email" placeholder="contoh@email.com" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Password <span style="color:red;">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" id="regPassword" name="password" placeholder="Min. 8 karakter" required>
                            <span class="toggle-password" onclick="togglePassword('regPassword', 'eyeIcon1')">
                                <span id="eyeIcon1">👁️</span>
                            </span>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Konfirmasi Password <span style="color:red;">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" id="regConfirmPassword" name="confirm_password" placeholder="Ulangi password" required>
                            <span class="toggle-password" onclick="togglePassword('regConfirmPassword', 'eyeIcon2')">
                                <span id="eyeIcon2">👁️</span>
                            </span>
                        </div>
                    </div>

                    <div class="input-group full-width">
                        <label>Nomor Telepon <span style="color:red;">*</span></label>
                        <input type="text" id="regTelepon" name="telepon" placeholder="Contoh: 08123456789" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="input-group full-width">
                        <label>Alamat Lengkap <span style="color:red;">*</span></label>
                        <input type="text" id="regAlamat" name="alamat_lengkap" placeholder="Detail alamat" required>
                    </div>
                </div>
                
                <button type="submit" name="register" class="btn-submit">Daftar</button>
            </form>

            <div class="footer-link">
                Sudah punya akun? <br> <a href="login.php">Login di sini</a>
            </div>  
        </div>
    </div>

    <div id="toastNotification" class="toast-notification">
        <span id="toastIcon"></span>
        <span id="toastMessage"></span>
    </div>

    <script>
        const formRegister = document.getElementById('formRegister');
        const toast = document.getElementById('toastNotification');
        const toastIcon = document.getElementById('toastIcon');
        const toastMessage = document.getElementById('toastMessage');

        // Fitur Toggle Password (Mata)
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === "password") {
                input.type = "text";
                icon.innerText = "🙈"; // Ikon mata tertutup
            } else {
                input.type = "password";
                icon.innerText = "👁️"; // Ikon mata terbuka
            }
        }

        function showNotification(type, message) {
            toast.classList.remove('toast-success', 'toast-error', 'show');
            
            if (type === 'success') {
                toast.classList.add('toast-success');
                toastIcon.innerText = '✅';
            } else {
                toast.classList.add('toast-error');
                toastIcon.innerText = '❌';
            }

            toastMessage.innerText = message;
            
            setTimeout(() => {
                toast.classList.add('show');
            }, 50);

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        formRegister.addEventListener('submit', function(event) {
            const nama = document.getElementById('regNama').value.trim();
            const username = document.getElementById('regUsername').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const telepon = document.getElementById('regTelepon').value.trim();
            const alamat = document.getElementById('regAlamat').value.trim();

            // 1. Required Validation
            if (!nama) { event.preventDefault(); return showNotification('error', 'Nama tidak boleh kosong!'); }
            if (!username) { event.preventDefault(); return showNotification('error', 'Username tidak boleh kosong!'); }
            if (!email) { event.preventDefault(); return showNotification('error', 'Email tidak boleh kosong!'); }
            if (!password) { event.preventDefault(); return showNotification('error', 'Password tidak boleh kosong!'); }
            if (!confirmPassword) { event.preventDefault(); return showNotification('error', 'Konfirmasi Password tidak boleh kosong!'); }
            if (!telepon) { event.preventDefault(); return showNotification('error', 'Nomor telepon tidak boleh kosong!'); }
            if (!alamat) { event.preventDefault(); return showNotification('error', 'Alamat tidak boleh kosong!'); }

            // 2. Email Validation (Format yang benar)
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                event.preventDefault();
                showNotification('error', 'Format email tidak valid! (Contoh: user@gmail.com)');
                return;
            }

            // 3. Length Validation (Minimal 8 karakter)
            if (password.length < 8) {
                event.preventDefault();
                showNotification('error', 'Password minimal 8 karakter!');
                return;
            }

            // 4. Match Validation (Password == Konfirmasi Password)
            if (password !== confirmPassword) {
                event.preventDefault();
                showNotification('error', 'Password dan Konfirmasi Password tidak sama!');
                return;
            }

            // 5. Number Validation (Nomor HP panjangnya wajar, misal minimal 10 digit)
            // Note: Validasi huruf sudah dicegah via oninput regex di HTML
            if (telepon.length < 10) {
                event.preventDefault();
                showNotification('error', 'Nomor telepon tidak valid! (Minimal 10 angka)');
                return;
            }

            showNotification('success', 'Memproses pendaftaran...');
        });
    </script>

</body>
</html>