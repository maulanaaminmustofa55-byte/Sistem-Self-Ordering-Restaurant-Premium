<?php
session_start();
include 'config/koneksi.php';

// Simple auth check - same password as KDS
$KDS_PASSWORD = 'amin2024';

if (!isset($_SESSION['kds_auth']) || $_SESSION['kds_auth'] !== true) {
    http_response_code(401);
    echo 'Unauthorized';
    exit;
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($conn, "UPDATE pesanan SET status='selesai' WHERE id=$id");
}
?>