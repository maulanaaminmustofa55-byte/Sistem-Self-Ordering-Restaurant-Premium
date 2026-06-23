<?php
include 'config/koneksi.php';
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($conn, "UPDATE pesanan SET status='selesai' WHERE id=$id");
}
?>