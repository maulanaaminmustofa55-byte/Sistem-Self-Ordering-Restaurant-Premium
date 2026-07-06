<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'restoran_amin';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>