<?php
include "koneksiDB/koneksi.php";

// Sediakan variabel untuk mentrigger SweetAlert2 di bagian bawah HTML
$alert_status = "";
$alert_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST["nama_produk"]);
    $stok = mysqli_real_escape_string($conn, $_POST["stok_tersedia"]);
    $deskripsi = mysqli_real_escape_string($conn, $_POST["deskripsi"]);

    // --- MULAI SINTAKS PEMBARUAN LOGIKA DATA ---
    $list_harga = $_POST["harga_perProduk"];
    $list_berat = $_POST["berat_produk"];

    $hasil_variasi = [];
    for ($i = 0; $i < count($list_harga); $i++) {
        $hasil_variasi[] =
            mysqli_real_escape_string($conn, $list_berat[$i]) .
            "(" .
            mysqli_real_escape_string($conn, $list_harga[$i]) .
            ")";
    }

    $variasi_final = implode(", ", $hasil_variasi);
    // --- SELESAI SINTAKS PEMBARUAN ---

    $target_dir = "pictures/";
    $foto_nama = basename($_FILES["foto_produk"]["name"]);
    $target_file = $target_dir . time() . "_" . $foto_nama;

    if (move_uploaded_file($_FILES["foto_produk"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO produk (nama_produk, harga_perProduk, berat_produk, stok_tersedia, deskripsi, foto_produk) 
                  VALUES ('$nama', 'Multi Harga', '$variasi_final', '$stok', '$deskripsi', '$target_file')";

        if (mysqli_query($conn, $query)) {
            $alert_status = "sukses";
            $alert_message = "Komoditas " . htmlspecialchars($nama) . " berhasil diintegrasikan ke sistem.";
        } else {
            $alert_status = "gagal_db";
            $alert_message = "Gagal menyimpan data: " . mysqli_real_escape_string($conn, mysqli_error($conn));
        }
    } else {
        $alert_status = "gagal_upload";
        $alert_message = "Terjadi kendala teknis saat mengunggah berkas foto produk.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Input Produk - UD. Sumber Rejeki</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #ffb74d;
            --primary-dark: #f57c00;
            --navy: #001f3f;
            --cream-light: #fff3e0;
            --glass: rgba(255, 255, 255, 0.9);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fdfdfd 0%, var(--cream-light) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--navy);
        }

        /* --- STYLING SWEETALERT2 BIAR SELARAS --- */
        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 24px !important;
            padding: 2rem !important;
        }
        .swal2-title {
            color: var(--navy) !important;
            font-weight: 800 !important;
        }
        .swal2-html-container {
            color: #4a5568 !important;
            font-weight: 500 !important;
        }
        .swal2-confirm {
            background: var(--navy) !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            padding: 12px 32px !important;
            text-transform: uppercase !important;
            font-size: 0.85rem !important;
            letter-spacing: 0.5px !important;
        }
        .swal2-confirm:hover {
            background: var(--primary-dark) !important;
        }

        header {
            background: var(--navy);
            padding: 60px 20px 120px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: #fdfdfd;
            clip-path: ellipse(60% 50% at 50% 100%);
        }

        header h1 {
            font-weight: 800;
            font-size: 2.5rem;
            letter-spacing: -1px;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, var(--primary));
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
        
        header p { opacity: 0.8; font-weight: 300; }

        .wrapper {
            max-width: 900px;
            margin: -60px auto 60px;
            width: 100%;
            padding: 0 20px;
            z-index: 10;
        }

        .main-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
        }

        .info-sidebar {
            background: var(--primary);
            border-radius: 24px;
            padding: 30px;
            color: var(--navy);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-sidebar h2 { font-weight: 800; font-size: 1.5rem; margin-bottom: 15px; }

        .form-grid { display: flex; flex-direction: column; gap: 20px; }

        .input-box label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--navy);
        }

        .input-box input, .input-box textarea {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #edf2f7;
            background: white;
            outline: none;
        }

        .btn-action {
            background: var(--navy);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-action:hover { background: var(--primary-dark); transform: translateY(-2px); }

        footer {
            background-color: #0e2052;
            padding: 40px 0 20px 0;
            color: #ffffff;
            margin-top: auto;
        }

        .footer-container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 250px;
        }
        .footer-brand img { height: 65px; }
        .footer-brand span { font-weight: bold; font-size: 13px; color: #ffffff; }

        .footer-links { flex: 0.5; min-width: 120px; }
        .footer-links h4 { font-size: 14px; margin-bottom: 12px; font-weight: 900; }
        .footer-links ul { list-style: none; padding: 0; }
        .footer-links li { font-size: 11px; margin-bottom: 5px; font-weight: 700; }
        .footer-links a { color: #ffffff; text-decoration: none; }

        .footer-info { flex: 1; min-width: 200px; }
        .footer-info h4 { font-size: 16px; margin-bottom: 12px; font-weight: 900; }
        .footer-info p { font-size: 13px; margin-bottom: 15px; font-weight: 500; }

        .footer-social { display: flex; gap: 15px; align-items: center; }
        .footer-social img { height: 45px; cursor: pointer; }

        .footer-bottom {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto 0;
            padding-top: 15px;
            border-top: 1px solid #bbb;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .main-card { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header>
        <div class="brand-box">
            <span style="font-size: 2.5rem;">🦆</span>
        </div>
        <h1>Input Inventaris</h1>
        <p>Manajemen data produk UD. Sumber Rejeki lebih cepat & akurat.</p>
    </header>

    <div class="wrapper">
        <div class="main-card">
            <div class="info-sidebar">
                <div>
                    <h2>Panduan</h2>
                    <p>Pastikan nama produk sesuai dengan label fisik. Gunakan kriteria stok yang tepat untuk menjaga keandalan transaksi pelanggan.</p>
                </div>
                <div style="font-size: 0.8rem; font-weight: 600;">Sistem Internal v2.0</div>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="form-grid">
                <div class="input-box">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" required placeholder="Misal: Daging Bebek Segar">
                </div>
                
                <div id="variasi-container">
                    <div class="input-group-row" style="display: grid; grid-template-columns: 1fr 1fr 50px; gap: 15px; margin-bottom: 15px; align-items: end;">
                        <div class="input-box">
                            <label>Harga per Produk (Rp)</label>
                            <input type="number" name="harga_perProduk[]" required placeholder="50000">
                        </div>
                        <div class="input-box">
                            <label>Ukuran / Berat</label>
                            <input type="text" name="berat_produk[]" required placeholder="Contoh: 0.6kg">
                        </div>
                        <button type="button" id="add-variasi" style="background: var(--primary); border: none; border-radius: 8px; height: 48px; cursor: pointer; font-weight: 800; color: var(--navy);"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-box">
                        <label>Stok Tersedia</label>
                        <select name="stok_tersedia" required style="width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid #edf2f7; background: white;">
                            <option value="tersedia">Tersedia</option>
                            <option value="habis">Habis</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Foto Produk</label>
                        <input type="file" name="foto_produk" accept="image/*" required style="padding: 10px;">
                    </div>
                </div>

                <div class="input-box">
                    <label>Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Keterangan tambahan..."></textarea>
                </div>
                
                <button type="submit" class="btn-action">Simpan ke Database</button>
                <button type="button" class="btn-action" style="background:#dc3545;" onclick="window.location.href='product.php'">Kembali</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <img src="pictures/logo.png" alt="Logo Footer">
                <span>UD. SUMBER REJEKI</span>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="aboutus.php">ABOUT US</a></li>
                    <li><a href="product.php">PRODUCT</a></li>
                    <li><a href="mitra.php">MITRA</a></li>
                    <li><a href="pesan.php">PESAN</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="history.php">HISTORY</a></li>
                    <li><a href="rekap.php">REKAP PENJUALAN</a></li>
                </ul>
            </div>

            <div class="footer-info">
                <h4>Informasi Lebih Lanjut</h4>
                <p>Silahkan ikuti media sosial kami</p>
                <div class="footer-social">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Youtube_logo.png" style="height:35px;" alt="YT"> 
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" style="height:40px;" alt="WA">
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 UD. SUMBER REJEKI. All rights reserved.
        </div>
    </footer>

<script>
    document.getElementById('add-variasi').addEventListener('click', function() {
        const container = document.getElementById('variasi-container');
        const newRow = document.createElement('div');
        newRow.style.display = 'grid';
        newRow.style.gridTemplateColumns = '1fr 1fr 50px';
        newRow.style.gap = '15px';
        newRow.style.marginBottom = '15px';
        newRow.style.alignItems = 'end';
        
        newRow.innerHTML = `
            <div class="input-box">
                <input type="number" name="harga_perProduk[]" required placeholder="50000">
            </div>
            <div class="input-box">
                <input type="text" name="berat_produk[]" required placeholder="Ukuran baru">
            </div>
            <button type="button" class="remove-variasi" style="background: #dc3545; border: none; border-radius: 8px; height: 48px; cursor: pointer; font-weight: 800; color: white;"><i class="fa-solid fa-minus"></i></button>
        `;
        container.appendChild(newRow);
    });

    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('remove-variasi') || e.target.parentElement.classList.contains('remove-variasi'))) {
            const button = e.target.classList.contains('remove-variasi') ? e.target : e.target.parentElement;
            button.parentElement.remove();
        }
    });

    // --- INTEGRASI POPUP MODERNT DARI PHP STATUS ---
    document.addEventListener("DOMContentLoaded", function() {
        const status = "<?= $alert_status ?>";
        const msg = "<?= $alert_message ?>";

        if (status === "sukses") {
            Swal.fire({
                title: 'Berhasil!',
                text: msg,
                icon: 'success',
                confirmButtonText: '<i class="fa-solid fa-check me-2"></i>Selesai',
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm'
                },
                buttonsStyling: false
            }).then(() => {
                window.location.href = 'product.php';
            });
        } else if (status === "gagal_db" || status === "gagal_upload") {
            Swal.fire({
                title: 'Penyimpanan Gagal',
                text: msg,
                icon: 'error',
                confirmButtonText: 'Periksa Kembali',
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm'
                },
                buttonsStyling: false
            });
        }
    });
</script>
</body>
</html>