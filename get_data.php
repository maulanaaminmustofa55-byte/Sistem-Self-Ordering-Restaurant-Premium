<?php
include 'config/koneksi.php';

header('Content-Type: text/html; charset=utf-8');

$query = "SELECT * FROM pesanan WHERE status != 'selesai' ORDER BY waktu_pesan ASC";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $no = 1;
    while($row = mysqli_fetch_assoc($result)) {
        $waktu_pesan = strtotime($row['waktu_pesan']);
        $selisih = time() - $waktu_pesan;
        
        // Hitung waiting time dalam MENIT (bukan detik)
        if($selisih < 60) {
            $waiting_text = 'kurang dari 1 menit';
        } else if($selisih < 3600) {
            $waiting_text = floor($selisih/60) . ' menit';
        } else {
            $waiting_text = floor($selisih/3600) . ' jam ' . floor(($selisih % 3600)/60) . ' menit';
        }
        
        echo '
        <div class="col">
            <div class="order-card-premium">
                <div class="card-header-premium">
                    <div class="table-number-premium">
                        <i class="fas fa-chair"></i> MEJA ' . $row['nomor_meja'] . '
                    </div>
                    <div class="queue-number-premium">
                        <i class="fas fa-hashtag"></i> ' . str_pad($no++, 2, '0', STR_PAD_LEFT) . '
                    </div>
                </div>
                <div class="card-body-premium">
                    <div class="customer-name-premium">
                        <i class="fas fa-user-circle"></i> ' . htmlspecialchars($row['nama_pelanggan']) . '
                    </div>
                    <div class="order-time-premium">
                        <i class="fas fa-clock"></i> ' . date('H:i:s', strtotime($row['waktu_pesan'])) . ' WIB
                    </div>
                    <div class="timer-premium">
                        <i class="fas fa-hourglass-half"></i>
                        <span>Waiting time: </span>
                        <span class="timer-value" style="color: #ffffff;">' . $waiting_text . '</span>
                    </div>
                    <div class="order-detail-premium">
                        <strong style="color: #d4af37;">📋 ORDER DETAILS</strong><br><br>
                        ' . nl2br(htmlspecialchars($row['detail_pesanan'])) . '
                    </div>
                </div>
                <button class="btn-ready-premium" onclick="selesaikan(' . $row['id'] . ')">
                    <i class="fas fa-check-circle"></i> READY TO SERVE ✔
                </button>
            </div>
        </div>';
    }
} else {
    echo '<div class="col-12">
            <div class="empty-state-premium">
                <i class="fas fa-utensils"></i>
                <h2>No Orders Yet</h2>
                <p style="color: rgba(255,255,255,0.5); margin-top: 15px;">Waiting for customers to scan QR and place orders</p>
                <div style="margin-top: 20px;">
                    <i class="fas fa-qrcode" style="font-size: 2rem; opacity: 0.3;"></i>
                </div>
            </div>
          </div>';
}
?>