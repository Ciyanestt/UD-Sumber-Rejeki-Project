<?php
session_start();
include "koneksiDB/koneksi.php";

// Proteksi Halaman: Admin tidak boleh masuk ke halaman ulasan pelanggan
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: product.php");
    exit();
}

// Cek status login pelanggan untuk digunakan di bagian HTML Form
$is_logged_in = isset($_SESSION["role"]) && $_SESSION["role"] === "pelanggan";

// Proses Simpan Ulasan
if (isset($_POST['kirim_ulasan'])) {
    // Keamanan tambahan: Tolak kiriman POST jika ternyata belum login
    if (!$is_logged_in) {
        echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
        exit();
    }

    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
    $rating = (int)$_POST['rating']; // Mengambil nilai rating (1-5)
    $id_pelanggan = $_SESSION['id_pelanggan']; // Pastikan mengambil langsung dari session yang valid
    
    // Logika Upload Foto
    $foto = null;
    if ($_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = "ulasan_" . time() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    // 1. Simpan ulasan baru
    $query = "INSERT INTO ulasan (id_pelanggan, rating, pesan, foto_bukti) 
              VALUES ($id_pelanggan, $rating, '$pesan', '$foto')";
    mysqli_query($conn, $query);

    // 2. LOGIKA OTOMATIS HAPUS: Sisakan hanya 10 ulasan terbaru
    $delete_query = "DELETE FROM ulasan WHERE id_ulasan NOT IN (
                        SELECT id_ulasan FROM (
                            SELECT id_ulasan FROM ulasan 
                            ORDER BY tanggal_ulasan DESC LIMIT 10
                        ) AS subquery
                     )";
    mysqli_query($conn, $delete_query);

    echo "<script>alert('Ulasan terkirim! Terima kasih atas masukan Anda.'); window.location.href='PesanKesan.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan & Kesan - UD. Sumber Rejeki</title>
    <link rel="icon" type="image/x-icon" href="pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* --- RESET & ROOT VARIABLES --- */
        :root {
            --primary-orange: #fbbd5a;
            --orange-hover: #e5a745;
            --dark-blue: #0b1d3a;
            --bg-light: #f4f6f9;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: #333;
            overflow-x: hidden;
        }

        /* --- HERO BANNER --- */
        .hero-review {
            background-color: var(--dark-blue);
            padding: 60px 20px 80px;
            text-align: center;
            border-radius: 0 0 40px 40px;
            margin-bottom: 50px;
            box-shadow: 0 10px 30px rgba(11, 29, 58, 0.1);
            position: relative;
        }
        .hero-review h2 {
            color: var(--primary-orange);
            font-weight: 800;
            font-size: 2.5rem;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .hero-review p {
            color: #e0e0e0;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* --- FORM KARTU ULASAN --- */
        .review-form-card {
            background: #ffffff;
            border-top: 5px solid var(--primary-orange);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .review-form-card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(251, 189, 90, 0.25);
            border-color: var(--primary-orange);
        }
        .btn-custom {
            background-color: var(--primary-orange);
            color: var(--dark-blue);
            border: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: var(--orange-hover);
            transform: translateY(-2px);
        }

        /* --- STAR RATING --- */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .star-rating input { display: none; }
        .star-rating label {
            font-size: 2rem;
            color: #e4e5e9;
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
            margin-right: 8px;
        }
        .star-rating input:checked ~ label { color: #ffc107; }
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #ffdb70; transform: scale(1.1); }

        .text-warning-star { color: #ffc107; }

        /* --- REVIEW LIST CARDS --- */
        .card-review {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-review:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        
        .user-avatar {
            width: 45px; height: 45px;
            background-color: var(--dark-blue);
            color: var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .admin-reply-box {
            background: #fffaf0;
            border-left: 4px solid var(--primary-orange);
            border-radius: 0 12px 12px 0;
            padding: 15px;
            margin-top: 15px;
        }

        /* --- 🌟 EFEK TRANSISI SCROLL POP-UP 🌟 --- */
        .scroll-pop {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            transition: opacity 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.1), 
                        transform 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }
        .scroll-pop.muncul {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
</head>
<body>

    <?php include "include/header.php"; ?>

    <section class="hero-review">
        <h2>PESAN & KESAN</h2>
        <p>Suara Anda sangat berarti bagi kami. Bagikan pengalaman Anda bermitra dengan UD. Sumber Rejeki.</p>
    </section>

    <div class="container mb-5">
        <div class="row gx-lg-5">
            
            <!-- SISI KIRI: FORM / KOTAK LOGIN -->
            <div class="col-lg-4 mb-5">
                <?php if ($is_logged_in): ?>
                    <!-- JIKA SUDAH LOGIN: Tampilkan Form Ulasan -->
                    <div class="review-form-card p-4 sticky-top scroll-pop" style="top: 100px; z-index: 10;">
                        <h5 class="fw-bold mb-4" style="color: var(--dark-blue);">
                            <i class="bi bi-pencil-square me-2" style="color: var(--primary-orange);"></i> Tulis Ulasan Anda
                        </h5>
                        
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label class="fw-semibold text-muted small d-block mb-2">Penilaian Anda</label>
                                <div class="star-rating">
                                    <input type="radio" name="rating" id="star5" value="5" class="rating-input" required><label for="star5" class="bi bi-star-fill"></label>
                                    <input type="radio" name="rating" id="star4" value="4" class="rating-input"><label for="star4" class="bi bi-star-fill"></label>
                                    <input type="radio" name="rating" id="star3" value="3" class="rating-input"><label for="star3" class="bi bi-star-fill"></label>
                                    <input type="radio" name="rating" id="star2" value="2" class="rating-input"><label for="star2" class="bi bi-star-fill"></label>
                                    <input type="radio" name="rating" id="star1" value="1" class="rating-input"><label for="star1" class="bi bi-star-fill"></label>
                                </div>
                            </div>

                            <div id="detail-ulasan" style="display: none;">
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small mb-1">Ceritakan Pengalaman Anda</label>
                                    <textarea name="pesan" class="form-control bg-light" rows="4" placeholder="Bagaimana kualitas produk atau pelayanan kami?" required style="border-radius: 12px;"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="fw-semibold text-muted small mb-1">Foto Bukti (Opsional)</label>
                                    <input type="file" name="foto" class="form-control bg-light" style="border-radius: 12px; font-size: 0.9rem;">
                                </div>
                                <button type="submit" name="kirim_ulasan" class="btn btn-custom w-100 fw-bold rounded-pill py-2 shadow-sm">
                                    <i class="bi bi-send-fill me-1"></i> KIRIM ULASAN
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <!-- JIKA BELUM LOGIN: Tampilkan Kotak Peringatan/CTA -->
                    <div class="review-form-card p-4 text-center sticky-top scroll-pop" style="top: 100px; z-index: 10; border-top: 5px solid var(--dark-blue);">
                        <i class="bi bi-lock-fill text-muted mb-3" style="font-size: 3rem; color: var(--dark-blue) !important;"></i>
                        <h5 class="fw-bold mb-2" style="color: var(--dark-blue);">Ingin Menulis Ulasan?</h5>
                        <p class="text-muted small mb-4">Silakan login untuk menulis ulasan.</p>
                        <a href="login.php" class="btn btn-custom w-100 fw-bold rounded-pill py-2 shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> LOGIN SEKARANG
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- SISI KANAN: DAFTAR ULASAN (Bisa dilihat siapa saja) -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <h5 class="fw-bold m-0" style="color: var(--dark-blue);">
                        <i class="bi bi-chat-left-quote-fill me-2" style="color: var(--primary-orange);"></i> Apa Kata Mitra Kami?
                    </h5>
                    <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary-orange); color: var(--dark-blue); font-weight: 700;">10 Terbaru</span>
                </div>

                <div class="review-list">
                    <?php 
                    $query_tampil = "SELECT ulasan.*, pelanggan.username, admin.nama_lengkap AS nama_admin 
                                     FROM ulasan 
                                     LEFT JOIN pelanggan ON ulasan.id_pelanggan = pelanggan.id_pelanggan 
                                     LEFT JOIN admin ON ulasan.id_admin = admin.id_admin 
                                     ORDER BY tanggal_ulasan DESC";
                    $tampil = mysqli_query($conn, $query_tampil);
                    
                    if(mysqli_num_rows($tampil) > 0):
                        while($r = mysqli_fetch_assoc($tampil)):
                            $username_display = !empty($r['username']) ? htmlspecialchars($r['username']) : 'Pelanggan Setia';
                    ?>
                    
                    <div class="card p-4 mb-4 border-0 card-review scroll-pop">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar shadow-sm">
                                    <?= strtoupper(substr($username_display, 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold" style="color: var(--dark-blue);"><?= $username_display ?></h6>
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        <i class="bi bi-clock me-1"></i> <?= date('d F Y', strtotime($r['tanggal_ulasan'])) ?>
                                    </small>
                                </div>
                            </div>
                            <div class="bg-light px-2 py-1 rounded-pill">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="bi bi-star-fill <?= $i <= $r['rating'] ? 'text-warning-star' : 'text-secondary opacity-25' ?>" style="font-size: 0.9rem;"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <p class="mb-3 text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($r['pesan'])) ?>
                        </p>
                        
                        <?php if($r['foto_bukti']): ?>
                            <div class="mb-3">
                                <img src="uploads/<?= $r['foto_bukti'] ?>" class="rounded-4 shadow-sm" style="max-height: 180px; width: auto; object-fit: cover;">
                            </div>
                        <?php endif; ?>

                        <?php if($r['balasan_admin']): ?>
                        <div class="admin-reply-box">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-patch-check-fill text-success fs-5"></i>
                                <span class="fw-bold text-dark small">Respon dari Admin (<?= htmlspecialchars($r['nama_admin'] ?? 'Official') ?>)</span>
                            </div>
                            <p class="small mb-0 text-secondary mt-1">
                                "<?= nl2br(htmlspecialchars($r['balasan_admin'])) ?>"
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; else: ?>
                        
                        <div class="text-center py-5 scroll-pop">
                            <i class="bi bi-chat-square-heart text-muted" style="font-size: 4rem; opacity: 0.5;"></i>
                            <h5 class="mt-3 text-muted fw-bold">Belum Ada Ulasan</h5>
                            <p class="text-secondary small">Jadilah yang pertama membagikan pengalaman Anda!</p>
                        </div>
                        
                    <?php endif; ?>
                </div> 
            </div>
        </div>
    </div>

    <?php include "include/footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script rating bintang hanya dipasang seandainya user sudah login -->
    <?php if ($is_logged_in): ?>
    <script>
    document.querySelectorAll('.rating-input').forEach(input => {
        input.addEventListener('change', function() {
            const detailContainer = document.getElementById('detail-ulasan');
            if (this.checked) {
                detailContainer.style.display = 'block';
                detailContainer.style.animation = "fadeIn 0.5s ease-in-out forwards";
            }
        });
    });
    </script>
    <?php endif; ?>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const elemenPopUp = document.querySelectorAll('.scroll-pop');

            const opsiObserver = {
                root: null,
                threshold: 0.1, 
                rootMargin: "0px 0px -50px 0px"
            };

            const observer = new IntersectionObserver(function (entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('muncul');
                    }
                });
            }, opsiObserver);

            elemenPopUp.forEach(elemen => {
                observer.observe(elemen);
            });
        });
    </script>
</body>
</html>