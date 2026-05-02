<?php
header('Content-Type: application/json');

// Sesuaikan dengan yang ada di screenshot kamu
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sumber_rejeki"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo json_encode(["error" => "Koneksi gagal"]);
    exit;
}

// Ambil data dan sesuaikan namanya biar cocok sama Javascript-nya
$sql = "SELECT id, username AS name, teks AS text, rating, tanggal AS date, media FROM ulasan ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$ulasan = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Karena di database nyimpennya berupa string JSON, kita harus ubah balik jadi array
        // biar Javascript di HTML bisa ngebaca gambarnya
        if (!empty($row['media'])) {
            $row['mediaList'] = json_decode($row['media'], true);
        } else {
            $row['mediaList'] = [];
        }
        
        // Hapus kolom media yang lama biar datanya rapi pas dikirim
        unset($row['media']); 
        
        $ulasan[] = $row;
    }
}

echo json_encode($ulasan);
?>