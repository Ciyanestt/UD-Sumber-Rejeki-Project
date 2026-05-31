<?php
session_start();
include "koneksiDB/koneksi.php";

// 1. Proteksi: Cek apakah user sudah login
if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];
$alert_script = ""; // Menampung script SweetAlert untuk notifikasi sukses/gagal

// 2. Ambil data profil lama untuk ditampilkan di Form awal
if ($role === "admin") {
    $id_admin = $_SESSION["id_admin"];
    $query = mysqli_query(
        $conn,
        "SELECT nama_lengkap, username FROM admin WHERE id_admin = '$id_admin'",
    );
} else {
    $id_pelanggan = $_SESSION["id_pelanggan"];
    $query = mysqli_query(
        $conn,
        "SELECT nama_lengkap, username, no_hp, email, alamat_lengkap FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'",
    );
}
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data profil tidak ditemukan.";
    exit();
}

// 3. Proses Update Data saat tombol simpan ditekan
if (isset($_POST["update_profil"])) {
    $nama_lengkap = mysqli_real_escape_string(
        $conn,
        trim($_POST["nama_lengkap"]),
    );
    $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
    $password_baru = $_POST["password_baru"];
    $konfirmasi = $_POST["konfirmasi_password"];

    $is_password_changed = false;
    $password_valid = true;
    $pass_final = "";
    $no_hp = "";
    $email = "";
    $alamat_lengkap = "";

    // Validasi Dasar Input Utama
    if (empty($nama_lengkap) || empty($username)) {
        $alert_script = "
            Swal.fire({
                title: 'Gagal!',
                text: 'Nama Lengkap dan Username wajib diisi!',
                icon: 'error',
                confirmButtonColor: '#e11d48'
            });
        ";
        $password_valid = false;
    }

    // Validasi Logika Password jika salah satu kolom password diisi
    if (!empty($password_baru) || !empty($konfirmasi)) {
        if (strlen($password_baru) < 5) {
            $alert_script = "
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Password baru minimal harus 5 karakter!',
                    icon: 'error',
                    confirmButtonColor: '#e11d48'
                });
            ";
            $password_valid = false;
        } elseif ($password_baru !== $konfirmasi) {
            $alert_script = "
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Konfirmasi password tidak cocok. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#e11d48'
                });
            ";
            $password_valid = false;
        } else {
            // Password valid, enkripsi dengan password_hash
            $pass_final = password_hash($password_baru, PASSWORD_DEFAULT);
            $is_password_changed = true;
        }
    }

    // Jika seluruh validasi lolos, jalankan Query Update ke database
    if ($password_valid) {
        if ($role === "admin") {
            if ($is_password_changed) {
                $query_update = "UPDATE admin SET nama_lengkap = '$nama_lengkap', username = '$username', password = '$pass_final' WHERE id_admin = '$id_admin'";
            } else {
                $query_update = "UPDATE admin SET nama_lengkap = '$nama_lengkap', username = '$username' WHERE id_admin = '$id_admin'";
            }
        } else {
            $no_hp = mysqli_real_escape_string($conn, trim($_POST["no_hp"]));
            $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
            $alamat_lengkap = mysqli_real_escape_string(
                $conn,
                trim($_POST["alamat_lengkap"]),
            );

            if ($is_password_changed) {
                $query_update = "UPDATE pelanggan SET nama_lengkap = '$nama_lengkap', username = '$username', no_hp = '$no_hp', email = '$email', alamat_lengkap = '$alamat_lengkap', password = '$pass_final' WHERE id_pelanggan = '$id_pelanggan'";
            } else {
                $query_update = "UPDATE pelanggan SET nama_lengkap = '$nama_lengkap', username = '$username', no_hp = '$no_hp', email = '$email', alamat_lengkap = '$alamat_lengkap' WHERE id_pelanggan = '$id_pelanggan'";
            }
        }

        // Eksekusi Query & Munculkan SweetAlert2 Berhasil
        if (mysqli_query($conn, $query_update)) {
            // Perbarui data lokal halaman agar langsung berubah saat form dirender kembali
            $data["nama_lengkap"] = $nama_lengkap;
            $data["username"] = $username;
            if ($role === "pelanggan") {
                $data["no_hp"] = $no_hp;
                $data["email"] = $email;
                $data["alamat_lengkap"] = $alamat_lengkap;
            }

            $pesan_sukses = $is_password_changed
                ? "Profil dan password Anda berhasil diperbarui!"
                : "Informasi profil berhasil diperbarui!";

            $alert_script = "
                Swal.fire({
                    title: 'Berhasil!',
                    text: '$pesan_sukses',
                    icon: 'success',
                    confirmButtonColor: '#0a1d37',
                    confirmButtonText: '<i class=\"fa-solid fa-check me-1\"></i> Lanjutkan'
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
                    text: 'Gagal memperbarui data: $error_db',
                    icon: 'error',
                    confirmButtonColor: '#e11d48'
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
    <title>Edit Profil & Keamanan - UD. SUMBER REJEKI</title>
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

        .bg-watermark {
            position: fixed;
            bottom: -50px;
            right: -50px;
            font-size: 40vw;
            color: rgba(0,0,0,0.02);
            z-index: -1;
            pointer-events: none;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(10, 29, 55, 0.08);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .profile-header {
            background: var(--navy-gradient);
            padding: 35px 30px;
            text-align: center;
            border-bottom: 4px solid var(--accent-orange);
        }

        .header-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-divider {
            position: relative;
            margin: 35px 0 25px;
            text-align: center;
        }

        .section-divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border-light);
            z-index: 1;
        }

        .section-title-badge {
            position: relative;
            z-index: 2;
            background: #ffffff;
            padding: 5px 15px;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary-navy);
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 2px solid var(--border-light);
            border-radius: 50px;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid var(--border-light);
            background-color: #f8fafc;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--primary-navy);
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 4px rgba(255, 159, 28, 0.15);
            background-color: #ffffff;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: var(--border-light);
            border-width: 2px;
            color: var(--primary-navy);
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            width: 45px;
            justify-content: center;
        }

        /* Desain khusus tombol mata intip password */
        .btn-toggle-password {
            background-color: #f8fafc;
            border: 2px solid var(--border-light);
            border-left: none;
            color: var(--text-muted);
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 0 15px;
            transition: all 0.3s;
        }
        .btn-toggle-password:hover {
            color: var(--accent-orange);
            background-color: #f1f5f9;
        }

        .form-control-has-icon {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        
        .form-control-has-btn {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
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
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(10, 29, 55, 0.2);
        }

        .btn-secondary-custom {
            background-color: #f1f5f9;
            color: #475569;
            border: 2px solid var(--border-light);
        }

        .btn-secondary-custom:hover {
            background-color: #e2e8f0;
            transform: translateY(-2px);
        }

        .custom-swal-popup {
            font-family: 'Montserrat', sans-serif !important;
            border-radius: 20px !important;
        }

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
                    <h2 class="header-title"><i class="fa-solid fa-user-gear me-2"></i>Edit Pengaturan Profil</h2>
                </div>

                <div class="p-4 px-md-5 pb-5">
                    <form action="" method="POST">
                        
                        <div class="section-divider mt-2">
                            <span class="section-title-badge">Informasi Umum</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                <input type="text" name="nama_lengkap" class="form-control form-control-has-icon" value="<?= htmlspecialchars(
                                    $data["nama_lengkap"],
                                ) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username / ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                                <input type="text" name="username" class="form-control form-control-has-icon" value="<?= htmlspecialchars(
                                    $data["username"],
                                ) ?>" required>
                            </div>
                        </div>

                        <?php if ($role === "pelanggan"): ?>
                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" name="no_hp" class="form-control form-control-has-icon" value="<?= htmlspecialchars(
                                        $data["no_hp"],
                                    ) ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control form-control-has-icon" value="<?= htmlspecialchars(
                                        $data["email"],
                                    ) ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3" style="border-radius:12px;"><?= htmlspecialchars(
                                    $data["alamat_lengkap"],
                                ) ?></textarea>
                            </div>
                        <?php endif; ?>


                        <div class="section-divider">
                            <span class="section-title-badge">Ubah Password (Opsional)</span>
                        </div>
                        <p class="text-muted text-center mb-3" style="font-size:0.78rem; font-weight:500; line-height:1.4;">
                            *Kosongkan kedua kolom di bawah ini jika Anda tidak berniat mengganti kata sandi.
                        </p>

                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-key me-1"></i> Password Baru</label>
                            <div class="input-group">
                                <input type="password" id="password_baru" name="password_baru" class="form-control form-control-has-btn" placeholder="Minimal 5 karakter" minlength="5">
                                <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password_baru', 'icon_mata_1')">
                                    <i id="icon_mata_1" class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fa-solid fa-check-double me-1"></i> Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="form-control form-control-has-btn" placeholder="Ulangi password baru" minlength="5">
                                <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('konfirmasi_password', 'icon_mata_2')">
                                    <i id="icon_mata_2" class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>


                        <div class="row g-3 pt-3">
                            <div class="col-sm-7">
                                <button type="submit" name="update_profil" class="btn-action btn-primary-custom w-100">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <a href="profil.php" class="btn-action btn-secondary-custom w-100">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const inputField = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);
    
    if (inputField.type === "password") {
        inputField.type = "text";
        // Ganti ikon mata menjadi terbuka
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        inputField.type = "password";
        // Ganti ikon mata menjadi tertutup kembali
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}
</script>

<?php if (!empty($alert_script)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?= $alert_script ?>
    });
</script>
<?php endif; ?>

</body>
</html>