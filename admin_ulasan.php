<?php
session_start();
include "koneksiDB/koneksi.php";

// Proteksi halaman admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Proses Balas Ulasan
if (isset($_POST["balas"])) {
    $id = $_POST["id_ulasan"];
    $balasan = mysqli_real_escape_string($conn, $_POST["isi_balasan"]);
    $id_admin = $_SESSION["id_admin"]; // Ambil ID admin yang sedang login

    // Update ulasan dengan teks balasan DAN id_admin yang membalas
    mysqli_query(
        $conn,
        "UPDATE ulasan SET 
        balasan_admin = '$balasan', 
        id_admin = '$id_admin' 
        WHERE id_ulasan = '$id'"
    );

    // Set session flag untuk menampilkan pop-up sukses, lalu redirect
    $_SESSION['sukses_balas'] = true;
    header("Location: admin_ulasan.php");
    exit();
}

include "include/header.php";
?>

<style>
    :root {
        --duck-yellow: #FFD166;
        --duck-orange: #F77F00;
        --duck-orange-hover: #E07300;
        --cream-light: #FFFBF0;
        --cream-dark: #FDF0D5;
        --water-blue: #38BDF8;
        --water-blue-hover: #0EA5E9;
        --text-dark: #334155;
        --text-muted: #64748B;
    }

    /* Animasi Masuk Halaman (Fade In Up Halus) */
    .animate-fade-in {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card & Table Styling */
    .duck-card {
        border: none;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(247, 127, 0, 0.04) !important;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .duck-table thead {
        background-color: var(--cream-dark);
        color: var(--text-dark);
    }

    .duck-table th {
        font-weight: 700;
        padding: 16px;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        border-bottom: 3px solid var(--duck-yellow);
    }

    .duck-table tbody tr {
        transition: background-color 0.25s ease, transform 0.25s ease;
    }

    /* Efek hover baris tabel yang elegan */
    .duck-table tbody tr:hover {
        background-color: #FFFDF9 !important;
    }

    .duck-table td {
        padding: 16px;
        color: var(--text-dark);
        font-size: 0.875rem;
        border-bottom: 1px solid #F1F5F9;
    }

    /* Badge & Keterangan */
    .badge-duck-count {
        background-color: var(--cream-dark);
        color: var(--duck-orange);
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        border: 1px dashed var(--duck-orange);
    }

    .badge-belum-dibalas {
        background-color: #FEF2F2;
        color: #EF4444;
        border: 1px solid #FEE2E2;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: 600;
    }

    /* Kotak Balasan Terpasang */
    .box-balasan-admin {
        background-color: var(--cream-light);
        border-left: 4px solid var(--duck-orange);
        padding: 10px 12px;
        border-radius: 4px 12px 12px 4px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.01);
    }

    /* Input & Button Form di Tabel */
    .duck-input-reply {
        border-radius: 12px 0 0 12px !important;
        border: 2px solid #E2E8F0;
        padding: 8px 14px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.25s ease;
        background-color: #F8FAFC;
    }

    .duck-input-reply:focus {
        border-color: var(--duck-yellow);
        box-shadow: 0 0 0 3px rgba(255, 209, 102, 0.25);
        background-color: #ffffff;
    }

    .duck-btn-send {
        border-radius: 0 12px 12px 0 !important;
        background-color: var(--duck-orange);
        border: 2px solid var(--duck-orange);
        color: white;
        padding: 0 14px;
        transition: all 0.25s ease;
    }

    .duck-btn-send:hover {
        background-color: var(--duck-orange-hover);
        border-color: var(--duck-orange-hover);
        color: white;
    }

    .duck-btn-photo {
        background-color: #F0F9FF;
        color: var(--water-blue-hover);
        border: 1px solid #E0F2FE;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 6px 12px;
        transition: all 0.25s ease;
    }

    .duck-btn-photo:hover {
        background-color: var(--water-blue);
        color: white;
        border-color: var(--water-blue);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(56, 189, 248, 0.2);
    }

    /* Custom Style untuk SweetAlert agar matching */
    .duck-swal-popup {
        font-family: 'Nunito', sans-serif !important;
        border-radius: 24px !important;
        border: 4px solid var(--duck-orange) !important;
        box-shadow: 0 20px 50px rgba(247, 127, 0, 0.15) !important;
    }
    .duck-swal-button {
        border-radius: 12px !important;
        font-weight: 700 !important;
        padding: 10px 24px !important;
        transition: transform 0.2s ease !important;
    }
    .duck-swal-button:hover {
        transform: scale(1.02) !important;
    }
</style>

<div class="container mt-5 mb-5 animate-fade-in">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h4 class="fw-extrabold text-dark m-0 d-flex align-items-center">
                <i class="bi bi-chat-left-heart-fill text-warning me-2 fs-4"></i>
                Kelola Ulasan User
            </h4>
            <p class="text-muted small m-0 mt-1">Pantau dan beri balasan hangat untuk feedback para pelanggan.</p>
        </div>
        <div>
            <span class="badge-duck-count">
                <i class="bi bi-stars text-warning me-1"></i> Maksimal 10 Ulasan Terbaru
            </span>
        </div>
    </div>

    <div class="table-responsive bg-white p-4 shadow-sm duck-card">
        <table class="table table-hover align-middle duck-table m-0">
            <thead>
                <tr>
                    <th width="22%"><i class="bi bi-person me-1"></i> Pengirim & Rating</th>
                    <th width="25%"><i class="bi bi-envelope-open me-1"></i> Pesan Pelanggan</th>
                    <th width="15%"><i class="bi bi-camera me-1"></i> Foto Bukti</th>
                    <th width="20%"><i class="bi bi-reply-all me-1"></i> Balasan Anda</th>
                    <th width="18%"><i class="bi bi-pencil-square me-1"></i> Aksi Balas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_tampil = "SELECT ulasan.*, pelanggan.username 
                            FROM ulasan 
                            LEFT JOIN pelanggan ON ulasan.id_pelanggan = pelanggan.id_pelanggan 
                            ORDER BY ulasan.id_ulasan DESC";

                $res = mysqli_query($conn, $query_tampil);

                if (mysqli_num_rows($res) > 0):
                    while ($row = mysqli_fetch_assoc($res)):
                        // Logika nama pengirim
                        $pengirim = !empty($row["username"]) ? $row["username"] : "User Publik"; 
                ?>
                <tr>
                    <td>
                        <div class="mb-1 d-flex align-items-center">
                            <i class="bi bi-person-circle me-2 text-secondary fs-6"></i>
                            <span class="fw-bold text-dark text-truncate" style="max-width: 140px;"><?= htmlspecialchars($pengirim) ?></span>
                        </div>
                        <div class="text-nowrap mt-1">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star-fill <?= $i <= $row["rating"] ? "text-warning" : "text-body-tertiary" ?>" style="font-size: 0.8rem; margin-right: 1px;"></i>
                            <?php endfor; ?>
                            <small class="text-muted ms-1 fw-bold" style="font-size: 0.75rem;">(<?= $row["rating"] ?>/5)</small>
                        </div>
                    </td>

                    <td>
                        <p class="mb-0 text-secondary fw-medium" style="line-height: 1.5; font-size: 0.85rem; max-height: 60px; overflow-y: auto;">
                            <?= nl2br(htmlspecialchars($row["pesan"])) ?>
                        </p>
                    </td>

                    <td>
                        <?php if ($row["foto_bukti"]): ?>
                            <a href="uploads/<?= $row["foto_bukti"] ?>" target="_blank" class="btn duck-btn-photo btn-sm d-inline-flex align-items-center">
                                <i class="bi bi-image-fill me-1"></i> Lihat Foto
                            </a>
                        <?php else: ?>
                            <span class="text-body-tertiary small ps-2">-</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($row["balasan_admin"]): ?>
                            <div class="box-balasan-admin">
                                <small class="text-dark fw-semibold d-block" style="font-size: 0.8rem; line-height: 1.4;">
                                    <?= htmlspecialchars($row["balasan_admin"]) ?>
                                </small>
                            </div>
                        <?php else: ?>
                            <span class="badge-belum-dibalas small d-inline-block">
                                <i class="bi bi-exclamation-circle me-1"></i> Belum dibalas
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <form action="" method="POST" class="m-0">
                            <input type="hidden" name="id_ulasan" value="<?= $row["id_ulasan"] ?>">
                            <div class="input-group input-group-sm">
                                <input type="text" name="isi_balasan" class="form-control duck-input-reply" placeholder="Ketik pesan balasan..." required autocomplete="off">
                                <button type="submit" name="balas" class="btn duck-btn-send d-flex align-items-center justify-content-center" title="Kirim Balasan">
                                    <i class="bi bi-send-fill" style="font-size: 0.75rem;"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                <?php
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <div class="py-4">
                            <i class="bi bi-chat-left-x text-body-tertiary display-4 d-block mb-3"></i>
                            <span class="fw-bold text-secondary">Belum ada ulasan dari pelanggan masuk sarang.</span>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['sukses_balas'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<h4 style="color:#F77F00; font-weight:800; margin:0;">Terkirim! 🦆</h4>',
            text: 'Balasan ulasan berhasil disimpan dengan aman.',
            icon: 'success',
            iconColor: '#F77F00',
            background: '#FFFBF0',
            color: '#334155',
            confirmButtonColor: '#38BDF8',
            confirmButtonText: '<i class="bi bi-check2-circle me-1"></i> Siap, Mantap!',
            backdrop: `rgba(255, 209, 102, 0.15)`,
            customClass: {
                popup: 'duck-swal-popup',
                confirmButton: 'duck-swal-button'
            }
        });
    });
</script>
<?php 
    unset($_SESSION['sukses_balas']); 
endif; 
?>

<?php include "include/footer.php"; ?>