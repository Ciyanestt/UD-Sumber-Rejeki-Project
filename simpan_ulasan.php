<?php
// 1. Panggil file koneksi (Sekarang aman karena beda file!)
include 'koneksi.php';

// 2. Tangkap data canggih dari JavaScript HTML-mu
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // 3. Masukkan ke variabel
    $username = $data['name'];
    $teks     = $data['text'];
    $rating   = $data['rating'];
    
    // (Abaikan media dulu kalau kamu belum bikin kolom media di database)

    // 4. Query untuk memasukkan data
    $sql = "INSERT INTO ulasan (username, teks, rating) VALUES ('$username', '$teks', '$rating')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "pesan" => "Ulasan berhasil disimpan!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Error database: " . $conn->error]);
    }
}
?>