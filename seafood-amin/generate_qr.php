<?php
// ==============================================
// GENERATE QR CODE UNTUK SELF ORDER SEAFOOD AMIN
// ==============================================

// Buat folder qr_codes jika belum ada
if (!file_exists('qr_codes')) {
    mkdir('qr_codes', 0777, true);
}

// Daftar meja (3 meja)
$meja_list = [1, 2, 3];

// Fungsi generate QR Code menggunakan cURL (tanpa warning)
function generateQR($data, $filename) {
    $size = "300";
    $url = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($data);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $qr_image = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close($ch); // TIDAK PERLU - PHP akan tutup otomatis
    
    if ($httpCode == 200 && $qr_image !== false && strlen($qr_image) > 500) {
        file_put_contents($filename, $qr_image);
        return true;
    }
    return false;
}

// Generate QR code untuk semua meja
foreach($meja_list as $meja) {
    $qr_url = "http://seapoodshrupp.great-site.net/input_pesanan.php?meja=" . $meja;
    $qr_filename = "qr_codes/meja_{$meja}.png";
    generateQR($qr_url, $qr_filename);
}

$domain_anda = "seapoodshrupp.great-site.net";
$base_url = "http://" . $domain_anda;

// Cek apakah file QR sudah ada
$qr_exists = [];
foreach($meja_list as $meja) {
    $qr_exists[$meja] = (file_exists("qr_codes/meja_{$meja}.png") && filesize("qr_codes/meja_{$meja}.png") > 500);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Generate QR Code - Seafood Amin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #0f0f1a 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 30px 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .premium-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 8vw, 3rem);
            font-weight: 800;
            background: linear-gradient(135deg, #d4af37 0%, #f5e6a3 50%, #d4af37 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .domain-info {
            background: rgba(212,175,55,0.15);
            border: 1px solid rgba(212,175,55,0.3);
            color: #d4af37;
            padding: 10px 20px;
            border-radius: 50px;
            margin-bottom: 30px;
            font-weight: 500;
            word-break: break-all;
            display: inline-block;
        }
        
        .qr-card {
            background: rgba(20,20,35,0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(212,175,55,0.2);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .qr-card:hover {
            transform: translateY(-5px);
            border-color: rgba(212,175,55,0.5);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .meja-number {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 7vw, 2.5rem);
            font-weight: 800;
            color: #d4af37;
        }
        
        .qr-code {
            background: white;
            padding: 20px;
            border-radius: 20px;
            margin: 20px 0;
            display: inline-block;
        }
        
        .qr-code img {
            max-width: 100%;
            width: 200px;
            height: auto;
        }
        
        .btn-download {
            background: linear-gradient(135deg, #d4af37, #b8960c);
            border: none;
            padding: 12px 25px;
            font-weight: 700;
            color: #0a0a0a;
            text-decoration: none;
            border-radius: 50px;
            width: 100%;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-download:hover {
            transform: scale(1.02);
            color: #0a0a0a;
        }
        
        .instruction {
            background: rgba(20,20,35,0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 30px;
            margin-top: 40px;
            border: 1px solid rgba(212,175,55,0.2);
        }
        
        code {
            font-size: 11px;
            word-break: break-all;
            background: rgba(0,0,0,0.3);
            padding: 8px;
            border-radius: 10px;
            color: #d4af37;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 20px 12px;
            }
            .qr-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="premium-title">🦞 SEAFOOD AMIN</h1>
            <p class="text-white-50 mt-2">Generate QR Code for Each Table</p>
            <div class="domain-info">
                🌐 <?php echo $domain_anda; ?>
            </div>
        </div>

        <div class="row">
            <?php foreach($meja_list as $meja): 
                $qr_url = $base_url . "/input_pesanan.php?meja=" . $meja;
                $qr_filename = "qr_codes/meja_{$meja}.png";
                $qr_ok = ($qr_exists[$meja]);
            ?>
            <div class="col-md-4 mb-4">
                <div class="qr-card">
                    <div class="meja-number">MEJA <?php echo $meja; ?></div>
                    <div class="qr-code">
                        <?php if($qr_ok): ?>
                            <img src="<?php echo $qr_filename; ?>?t=<?php echo time(); ?>" alt="QR Code">
                        <?php else: ?>
                            <div style="width: 200px; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                                <span style="color: #999;">Click Generate</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <code class="d-block mb-3"><?php echo $qr_url; ?></code>
                    <?php if($qr_ok): ?>
                        <a href="<?php echo $qr_filename; ?>" download="QR_Meja_<?php echo $meja; ?>.png" class="btn-download">
                            📥 Download QR Meja <?php echo $meja; ?>
                        </a>
                    <?php else: ?>
                        <form method="POST" action="">
                            <input type="hidden" name="generate_meja" value="<?php echo $meja; ?>">
                            <button type="submit" name="generate_single" class="btn-download" style="background: #3498db;">
                                🔄 Generate QR Meja <?php echo $meja; ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="instruction">
            <h4 class="text-center mb-3" style="color: #d4af37;">📋 How to Use</h4>
            <div class="row text-center">
                <div class="col-md-4">
                    <div style="font-size: 2rem;">1️⃣</div>
                    <p class="text-white-50">Generate/Download QR Code for each table</p>
                </div>
                <div class="col-md-4">
                    <div style="font-size: 2rem;">2️⃣</div>
                    <p class="text-white-50">Print & place on each table</p>
                </div>
                <div class="col-md-4">
                    <div style="font-size: 2rem;">3️⃣</div>
                    <p class="text-white-50">Customers scan → order themselves!</p>
                </div>
            </div>
            <hr style="background: rgba(212,175,55,0.3);">
            <div class="alert alert-success text-center bg-transparent text-white border border-success">
                ✅ QR Code files saved in <strong>qr_codes/</strong> folder
            </div>
        </div>
    </div>

    <?php
    if(isset($_POST['generate_single']) && isset($_POST['generate_meja'])) {
        $meja = intval($_POST['generate_meja']);
        $qr_url = $base_url . "/input_pesanan.php?meja=" . $meja;
        $qr_filename = "qr_codes/meja_{$meja}.png";
        
        $url_api = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qr_url);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $qr_image = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch); // TIDAK PERLU
        
        if($httpCode == 200 && $qr_image !== false && strlen($qr_image) > 500) {
            file_put_contents($qr_filename, $qr_image);
            echo "<script>alert('✅ QR Code Meja $meja berhasil digenerate!'); window.location.href='generate_qr.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal generate QR Code! Coba lagi.'); window.location.href='generate_qr.php';</script>";
        }
    }
    ?>
</body>
</html>