<?php
// 1. Koneksi ke database
session_start();

// Menggunakan __DIR__ agar path absolut dan aman saat di-upload ke hosting nantinya
require_once __DIR__ . "/../koneksiDB/koneksi.php";

// Cek keamanan role
if (!isset($_SESSION["role"])) {
    header("Location: ../login.php");
    exit();
}

// 2. Ambil ID produk dari URL dan amankan dari SQL Injection
$id_produk = isset($_GET["id"]) ? mysqli_real_escape_string($conn, $_GET["id"]) : "";

// Jika ID produk kosong di URL, kembalikan ke product.php
if (empty($id_produk)) {
    header("Location: ../product.php");
    exit();
}

// 3. Ambil data produk spesifik
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
$data = mysqli_fetch_assoc($query);

// Jika produk tidak ditemukan di database, arahkan kembali ke halaman produk
if (!$data) {
    header("Location: /project itik 2/product.php");
    exit();
}

$list_variasi = explode(", ", $data["berat_produk"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli <?= htmlspecialchars($data["nama_produk"]) ?> - UD. SUMBER REJEKI</title>
    <link rel="icon" type="image/x-icon" href="/project itik 2/pictures/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        
        /* Animasi Muncul Lembut (Fade In Up) */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Efek Melayang (Hover Lift) pada Kartu */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }

        /* Efek Tombol Ukuran (Radio) */
        .btn-outline-warning {
            transition: all 0.3s ease;
            border-width: 2px;
        }
        .btn-check:checked + .btn-outline-warning {
            background-color: #ffc107;
            color: #000;
            transform: scale(1.05); /* Sedikit membesar saat dipilih */
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4);
            border-color: #ffc107;
        }

        /* Header Gradient Lembut */
        .bg-header-gradient {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-bottom: 3px solid #ffcc80;
        }

        /* Tombol Checkout Bergradien & Animasi Denyut */
        .btn-checkout {
            background: linear-gradient(45deg, #ffc107, #ff9800);
            border: none;
            transition: all 0.3s ease;
            color: #000;
        }
        .btn-checkout:hover {
            background: linear-gradient(45deg, #ff9800, #ffc107);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.4);
            color: #fff;
        }

        /* Fokus pada Input Form */
        .form-control:focus, .form-select:focus {
            border-color: #ffb300;
            box-shadow: 0 0 0 0.25rem rgba(255, 179, 0, 0.25);
        }
    </style>
</head>
<body>

    <?php include "../include/header.php"; ?>

    <div class="bg-header-gradient py-5 text-center text-dark mb-5 shadow-sm fade-in-up">
        <h1 class="fw-bold h2 mb-2 text-uppercase text-dark">
            <?= htmlspecialchars($data["nama_produk"]) ?>
        </h1>
        <p class="mb-0 opacity-75 fs-6"><i class="fa-solid fa-leaf text-success me-2"></i>Segar dari peternakan, higienis, dan siap diolah.</p>
    </div>

    <main class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-5 fade-in-up delay-1">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm product-preview hover-lift bg-white">
                    <img src="../<?= htmlspecialchars($data["foto_produk"]) ?>" class="card-img-top" style="object-fit: cover; height: 350px;" alt="<?= htmlspecialchars($data["nama_produk"]) ?>">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark"><?= htmlspecialchars($data["nama_produk"]) ?></h4>
                        <p class="text-muted small lh-lg"><?= htmlspecialchars($data["deskripsi"]) ?></p>
                        <hr class="text-muted">
                        <div class="small fw-semibold text-secondary">
                            <div class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i> Langsung dari peternakan sendiri</div>
                            <div><i class="fa-solid fa-box-open text-warning me-2"></i> Pengiriman dengan kemasan aman</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 fade-in-up delay-2">
                <form action="checkout.php" method="POST" class="p-lg-4 bg-white rounded-4 shadow-sm p-4 hover-lift">
                    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
                    <input type="hidden" name="nama_produk" value="<?= htmlspecialchars($data["nama_produk"]) ?>">
                    <input type="hidden" name="harga_satuan" id="hidden-harga-satuan">
                    <input type="hidden" name="total_harga" id="hidden-total-harga">
                    <input type="hidden" name="biaya_ongkir" id="hidden-ongkir" value="0">
                    
                    <div class="mb-4">
                        <label class="fw-bold mb-3 d-block text-dark"><i class="fa-solid fa-scale-balanced me-2 text-warning"></i>Pilih Ukuran / Berat:</label>
                        <div class="row g-2">
                        <?php foreach ($list_variasi as $index => $v):
                            preg_match("#\((.*?)\)#", $v, $match);
                            $harga_aja = isset($match[1]) ? $match[1] : 0;
                            $label_aja = str_replace("(" . $harga_aja . ")", "", $v);
                            ?>
                            <div class="col-6 col-md-3">
                                <input type="radio" class="btn-check size-radio" name="ukuran" 
                                    id="size<?= $index ?>" 
                                    value="<?= trim($label_aja) ?>" 
                                    data-harga="<?= $harga_aja ?>" 
                                    <?= $index === 0 ? "checked" : "" ?>>
                                <label class="btn btn-outline-warning w-100 py-2 rounded-3 fw-bold text-dark" for="size<?= $index ?>">
                                    <?= trim($label_aja) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="row align-items-end mb-4 g-3">
                        <div class="col-md-4">
                            <label class="fw-bold mb-2 d-block small text-dark"><i class="fa-solid fa-calculator me-2 text-primary"></i>Jumlah:</label>
                            <input type="number" name="jumlah" class="form-control text-center fw-bold rounded-3 shadow-sm border-0 bg-light py-2" value="1" min="1" required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card p-3 border border-warning border-opacity-25 bg-light rounded-4 h-100">
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-wallet text-success me-2"></i>Pembayaran</h6>
                                <select name="metode_pembayaran" class="form-select border-0 shadow-sm mb-2 rounded-3" required>
                                    <option value="Transfer Bank">Transfer Bank</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="COD">COD (Bayar ditempat)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-3 border border-primary border-opacity-25 bg-light rounded-4 h-100">
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-truck text-primary me-2"></i>Pengiriman</h6>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input opsi-pengiriman" type="radio" name="pengiriman" id="sh1" value="Kirim ke Alamat" checked>
                                    <label class="form-check-label small fw-bold" for="sh1">Kirim ke Alamat</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input opsi-pengiriman" type="radio" name="pengiriman" id="sh2" value="Ambil di Toko">
                                    <label class="form-check-label small fw-bold" for="sh2">Ambil di Toko</label>
                                </div>

                                <div id="form-alamat-pengiriman" class="mt-3 p-3 bg-white rounded-3 shadow-sm">
                                    <div class="mb-2">
                                        <label class="small fw-bold">Provinsi:</label>
                                        <select name="provinsi" id="provinsi" class="form-select form-select-sm border-0 bg-light" required>
                                            <option value="">-- Pilih Provinsi --</option>
                                            <option value="Jawa Timur">Jawa Timur</option>
                                            <option value="Bali">Bali</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="small fw-bold">Kabupaten/Kota:</label>
                                        <select name="kabupaten" id="kabupaten" class="form-select form-select-sm border-0 bg-light" required>
                                            <option value="">-- Pilih Kabupaten --</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="small fw-bold">Alamat Lengkap:</label>
                                        <textarea name="alamat_lengkap" class="form-control form-control-sm border-0 bg-light" rows="2" placeholder="Nama Jalan, RT/RW, Desa/Kelurahan" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-3 border-0 bg-dark text-white shadow-lg rounded-4 mt-4 mb-2 text-center" style="background: linear-gradient(135deg, #212529, #343a40) !important;">
                        <span id="display-total-harga" class="fw-normal fs-6">
                            Harga: Rp 0 | Ongkir: Rp 0 | Total: Rp 0
                        </span>
                    </div>
                    
                    <?php $role = isset($_SESSION["role"]) ? $_SESSION["role"] : ""; ?>

                    <?php if ($role === "admin"): ?>
                        <button type="button" class="btn btn-secondary w-100 py-3 rounded-pill fw-bold text-white fs-5 shadow-sm mt-3" disabled>
                            <i class="fa-solid fa-ban me-2"></i> CHECKOUT SEKARANG (ADMIN)
                        </button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-checkout w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm mt-3">
                            <i class="fa-solid fa-cart-shopping me-2"></i> CHECKOUT SEKARANG
                        </button>
                    <?php endif; ?>

                    <a href="/project itik 2/product.php" class="btn btn-outline-secondary w-100 py-2 rounded-pill fw-bold fs-6 shadow-sm mt-2">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Produk
                    </a>
                    
                </form>
            </div>
        </div>
    </main>

    <?php include "../include/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bundle.min.js"></script>
    <script>
        const tarifOngkir = {
            "Jawa Timur": {
                "Jember": 10000,
                "Banyuwangi": 15000,
                "Lumajang": 12000,
                "Bondowoso": 11000,
                "Situbondo": 13000
            },
            "Bali": {
                "Denpasar": 25000,
                "Badung": 27000
            }
        };

        const radios = document.querySelectorAll('.size-radio');
        const inputJumlah = document.querySelector('input[name="jumlah"]');
        const opsiPengiriman = document.querySelectorAll('.opsi-pengiriman');
        const formAlamat = document.getElementById('form-alamat-pengiriman');
        
        const selectProvinsi = document.getElementById('provinsi');
        const selectKabupaten = document.getElementById('kabupaten');
        const displayTotal = document.getElementById('display-total-harga');

        opsiPengiriman.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'Kirim ke Alamat') {
                    formAlamat.style.display = 'block';
                    selectProvinsi.setAttribute('required', 'required');
                    selectKabupaten.setAttribute('required', 'required');
                    document.querySelector('textarea[name="alamat_lengkap"]').setAttribute('required', 'required');
                } else {
                    formAlamat.style.display = 'none';
                    selectProvinsi.removeAttribute('required');
                    selectKabupaten.removeAttribute('required');
                    document.querySelector('textarea[name="alamat_lengkap"]').removeAttribute('required');
                    selectProvinsi.value = "";
                    selectKabupaten.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                }
                updateHarga();
            });
        });

        selectProvinsi.addEventListener('change', function() {
            const prov = this.value;
            selectKabupaten.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
            
            if (prov && tarifOngkir[prov]) {
                const kabupatenData = tarifOngkir[prov];
                for (let kab in kabupatenData) {
                    let option = document.createElement('option');
                    option.value = kab;
                    option.text = kab + " (Rp " + kabupatenData[kab].toLocaleString('id-ID') + ")";
                    option.setAttribute('data-ongkir', kabupatenData[kab]);
                    selectKabupaten.appendChild(option);
                }
            }
            updateHarga();
        });

        selectKabupaten.addEventListener('change', updateHarga);
        inputJumlah.addEventListener('input', updateHarga);
        radios.forEach(radio => {
            radio.addEventListener('change', updateHarga);
        });

        function updateHarga() {
            let hargaSatuan = 0;
            
            radios.forEach(radio => {
                if (radio.checked) {
                    hargaSatuan = parseInt(radio.getAttribute('data-harga')) || 0;
                }
            });

            const jumlah = parseInt(inputJumlah.value) || 1;
            let subtotal = hargaSatuan * jumlah;
            
            let ongkir = 0;
            const pengirimanDipilih = document.querySelector('input[name="pengiriman"]:checked').value;
            
            if (pengirimanDipilih === 'Kirim ke Alamat' && selectKabupaten.value !== "") {
                const selectedOption = selectKabupaten.options[selectKabupaten.selectedIndex];
                ongkir = parseInt(selectedOption.getAttribute('data-ongkir')) || 0;
            }

            const totalBayar = subtotal + ongkir;

            displayTotal.innerHTML = "Harga: Rp " + hargaSatuan.toLocaleString('id-ID') + " (x" + jumlah + ") <span class='mx-2 opacity-50'>|</span> " +
                                     "Ongkir: Rp " + ongkir.toLocaleString('id-ID') + " <span class='mx-2 opacity-50'>|</span> " +
                                     "<span class='fw-bold text-warning fs-5'>Total: Rp " + totalBayar.toLocaleString('id-ID') + "</span>";

            document.getElementById('hidden-harga-satuan').value = hargaSatuan;
            document.getElementById('hidden-total-harga').value = totalBayar;
            document.getElementById('hidden-ongkir').value = ongkir;
        }

        updateHarga();
    </script>
</body>
</html>