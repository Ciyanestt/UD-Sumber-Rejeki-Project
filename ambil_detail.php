<?php
// Pastikan balasannya selalu format JSON
header('Content-Type: application/json');

// Matikan error bawaan PHP biar nggak ngerusak format JSON kalau ada masalah
error_reporting(0); 

$conn = mysqli_connect("localhost", "root", "", "db_sumber_rejeki");

// Cek apakah koneksi database nyala/berhasil
if (!$conn) {
    echo json_encode(["error" => "Koneksi ke database gagal. Cek XAMPP-nya coy!"]);
    exit; // Berhenti di sini
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM ulasan WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Cek apakah query berhasil
if ($result) {
    $data = mysqli_fetch_assoc($result);
    
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Data tidak ditemukan"]);
    }
} else {
    echo json_encode(["error" => "Terjadi kesalahan pada sistem database."]);
}

mysqli_close($conn);
?>