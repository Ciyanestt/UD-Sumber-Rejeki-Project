<?php
header('Content-Type: application/json');
$conn = mysqli_connect("localhost", "root", "", "db_sumber_rejeki");

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM ulasan WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "pesan" => "ID tidak valid"]);
}
?>