<?php 
include 'config/koneksi.php'; 
$no_meja = isset($_GET['meja']) ? $_GET['meja'] : "??";

$menu_seafood = [
    "Makanan" => [
        "Kakap Bakar Janur Kuning" => [
            "harga" => 185000,
            "rating" => 4.8,
            "deskripsi" => "Fillet kakap segar yang dibakar perlahan di atas bara arang, menghasilkan aroma asap yang khas dan tekstur daging yang lembut di setiap gigitan.",
            "kalori" => "250kcal",
            "waktu" => "10-15 min",
            "gambar" => "assets/images/menu/foto1.png"
        ],
        "Lobster Panggang Keju Mumbul" => [
            "harga" => 250000,
            "rating" => 4.9,
            "deskripsi" => "Lobster utuh panggang dengan siraman saus jamur krim dan lelehan keju Gruyere yang gurih mantap. Pas untuk dinikmati bersama.",
            "kalori" => "380kcal",
            "waktu" => "20-25 min",
            "gambar" => "assets/images/menu/foto2.png"
        ],
        "Udang Galah Bakar Mentega" => [
            "harga" => 165000,
            "rating" => 4.7,
            "deskripsi" => "Udang ukuran jumbo yang dimarunasi bumbu bawang putih dan rempah pilihan, lalu dibakar sampai aromanya merebak. Gurih dan nagih.",
            "kalori" => "210kcal",
            "waktu" => "12-15 min",
            "gambar" => "assets/images/menu/foto3.png"
        ],
        "Kepiting Soka Lada Hitam" => [
            "harga" => 220000,
            "rating" => 4.8,
            "deskripsi" => "Kepiting pilihan yang ditumis dengan saus lada hitam racikan spesial. Pedas hangatnya pas, aromanya pun menggoda selera.",
            "kalori" => "320kcal",
            "waktu" => "20-25 min",
            "gambar" => "assets/images/menu/foto4.png"
        ],
        "Kepiting Soka Telur Asin" => [
            "harga" => 145000,
            "rating" => 4.6,
            "deskripsi" => "Kepiting cangkang lunak yang digoreng garing, dibalut saus telur asin yang creamy dengan sedikit aroma daun kari yang wangi.",
            "kalori" => "290kcal",
            "waktu" => "15-20 min",
            "gambar" => "assets/images/menu/foto5.png"
        ],
        "Nasi Rempah Segoro" => [
            "harga" => 195000,
            "rating" => 4.7,
            "deskripsi" => "Nasi bumbu rempah kuning ala pesisir yang melimpah dengan isian udang, kerang, remis, dan cumi segar. Kaya rasa dan tekstur.",
            "kalori" => "450kcal",
            "waktu" => "25-30 min",
            "gambar" => "assets/images/menu/foto6.png"
        ]
    ],
    "Minuman" => [
        "Es Teh Solo (Tersedia Panas/Dingin)" => [
            "harga" => 3500,
            "rating" => 4.5,
            "deskripsi" => "Teh hitam tubruk khas Solo dengan aroma melati yang kuat dan pekat. Pilihan pas untuk menetralisir rasa gurih. Tersedia dalam sajian panas yang menenangkan atau dingin yang menyegarkan.",
            "kalori" => "120kcal",
            "gambar" => "assets/images/menu/teh.png"
        ],
        "Es Jeruk Purut (Tersedia Panas/Cold)" => [
            "harga" => 5000,
            "rating" => 4.6,
            "deskripsi" => "Perasan jeruk purut segar yang asam manis dan aromatik. Membangkitkan selera dan membersihkan palet lidah usai menyantap kepiting lada hitam.",
            "kalori" => "180kcal",
            "gambar" => "assets/images/menu/jeruk.png"
        ],
        "Es Kelapa Muda Kopyor" => [
            "harga" => 18000,
            "rating" => 4.7,
            "deskripsi" => "Kesegaran air kelapa muda murni dengan serutan daging kelapa muda kopyor yang lembut dan kenyal. Sempurna untuk mendinginkan suasana panas pesisir.",
            "kalori" => "150kcal",
            "gambar" => "assets/images/menu/kelapa.png"
        ]
    ],
    "Cemilan" => [
        "tempe Goreng Lapis Tepung" => [
            "harga" => 10000,
            "rating" => 4.9,
            "deskripsi" => "tempe pilihan yang dibalut tepung berbumbu rahasia, digoreng garing sampai coklat keemasan Renyah di luar, lembut dan gurih di dalam.",
            "kalori" => "420kcal",
            "gambar" => "assets/images/menu/bakwan.png"
        ],
        "Bakwan Sayur Udang Rebon Garing" => [
            "harga" => 15000,
            "rating" => 4.7,
            "deskripsi" => "Gorengan sayur gurih dengan taburan udang rebon melimpah. Digoreng garing keemasan, renyah di luar dan lembut di dalam.",
            "kalori" => "350kcal",
            "gambar" => "assets/images/menu/tempe.png"
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Seafood Amin - Premium Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #0a0a0a;
            min-height: 100vh;
        }

        /* ========== BACKGROUND PREMIUM ========== */
        .premium-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0a0a 0%, #0f0f1a 50%, #0a0a0f 100%);
            z-index: -2;
        }

        .premium-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 20%, rgba(212, 175, 55, 0.06) 0%, transparent 60%);
            z-index: -1;
        }

        .premium-bg::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle at 70% 80%, rgba(212, 175, 55, 0.04) 0%, transparent 70%);
            z-index: -1;
        }

        /* ========== HEADER SUPER PREMIUM ========== */
        .hero-premium {
            position: relative;
            min-height: 65vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1559339352-11d035aa65de?w=1600&h=900&fit=crop');
            background-size: cover;
            background-position: center;
            z-index: -2;
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.7) 50%, rgba(0,0,0,0.85) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 80px 20px;
        }

        .restaurant-logo {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 10vw, 5rem);
            font-weight: 800;
            letter-spacing: 6px;
            background: linear-gradient(135deg, #d4af37 0%, #f5e6a3 30%, #d4af37 60%, #b8960c 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(212,175,55,0.2);
        }

        .restaurant-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: clamp(0.7rem, 3.5vw, 0.9rem);
            letter-spacing: 8px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .divider-premium {
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4af37, #d4af37, transparent);
            margin: 20px auto;
        }

        .table-badge-premium {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(212,175,55,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212,175,55,0.3);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            color: #d4af37;
        }

        .table-badge-premium i {
            font-size: 1.2rem;
        }

        .table-number {
            font-size: 1.3rem;
            font-weight: 800;
            background: #d4af37;
            color: #0a0a0a;
            padding: 4px 12px;
            border-radius: 30px;
            margin-left: 8px;
        }

        /* ========== SCROLL INDICATOR ========== */
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
            color: #d4af37;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        /* ========== ORDER SUMMARY SIDEBAR ========== */
        .order-summary {
            position: sticky;
            top: 20px;
            background: rgba(15,15,25,0.95);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid rgba(212,175,55,0.2);
            padding: 25px;
            margin-bottom: 20px;
        }

        .summary-title {
            color: #d4af37;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(212,175,55,0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px dashed rgba(255,255,255,0.05);
        }

        .summary-total {
            border-top: 1px solid rgba(212,175,55,0.3);
            padding-top: 15px;
            margin-top: 10px;
            font-weight: 700;
            color: #d4af37;
            font-size: 1.2rem;
            display: flex;
            justify-content: space-between;
        }

        /* ========== CATEGORY TITLE ========== */
        .category-title-premium {
            font-family: 'Playfair Display', serif;
            color: #d4af37;
            font-size: clamp(1.2rem, 5vw, 1.6rem);
            font-weight: 700;
            margin: 20px 0 20px 0;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(212,175,55,0.3);
            display: inline-block;
        }

        .category-title-premium:first-of-type {
            margin-top: 10px;   /* Kategori MAKANAN lebih naik lagi */
        }

        /* ========== PREMIUM MENU CARDS ========== */
        .premium-card {
            background: rgba(20,20,35,0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(212,175,55,0.12);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 25px;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .premium-card:hover {
            transform: translateY(-8px);
            border-color: rgba(212,175,55,0.4);
            box-shadow: 0 25px 45px rgba(0,0,0,0.4), 0 0 25px rgba(212,175,55,0.1);
        }

        .image-container {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .premium-card:hover .card-image {
            transform: scale(1.08);
        }

        .price-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #d4af37, #b8960c);
            color: #0a0a0a;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            z-index: 2;
            font-weight: 700;
        }

        .rating-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            color: #d4af37;
            z-index: 2;
        }

        .rating-badge i {
            color: #ffc107;
            margin-right: 4px;
        }

        .card-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .menu-title {
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .menu-desc {
            color: rgba(255,255,255,0.55);
            font-size: 0.8rem;
            line-height: 1.5;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .menu-desc.full {
            display: block;
            -webkit-line-clamp: unset;
        }

        .read-more {
            color: #d4af37;
            font-size: 0.7rem;
            cursor: pointer;
            margin-top: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .menu-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 12px;
            font-size: 0.7rem;
            color: rgba(212,175,55,0.7);
        }

        .menu-meta i {
            margin-right: 5px;
        }

        .allergen-badge {
            display: inline-block;
            background: rgba(231, 76, 60, 0.12);
            color: #e74c3c;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.65rem;
            margin-right: 6px;
            margin-bottom: 5px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .qty-btn {
            background: rgba(212,175,55,0.15);
            border: 1px solid rgba(212,175,55,0.3);
            color: #d4af37;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .qty-btn:hover {
            background: #d4af37;
            color: #0a0a0a;
        }

        .qty-value {
            color: white;
            font-weight: 600;
            min-width: 45px;
            text-align: center;
            font-size: 1.2rem;
        }

        /* ========== ORDER BUTTON ========== */
        .order-section {
            position: sticky;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.98), rgba(10,10,20,0.98));
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(212,175,55,0.3);
            padding: 20px;
            margin-top: 50px;
            border-radius: 30px 30px 0 0;
        }

        .btn-order-premium {
            background: linear-gradient(135deg, #d4af37, #b8960c);
            border: none;
            padding: 16px 35px;
            border-radius: 60px;
            font-weight: 800;
            font-size: 1rem;
            color: #0a0a0a;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 2px;
        }

        .btn-order-premium:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 35px rgba(212,175,55,0.4);
        }

        /* ========== FORM INPUT ========== */
        .form-control-premium {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(212,175,55,0.25);
            border-radius: 50px;
            padding: 14px 22px;
            color: white;
            font-weight: 500;
            width: 100%;
        }

        .form-control-premium:focus {
            background: rgba(255,255,255,0.12);
            border-color: #d4af37;
            outline: none;
            color: white;
            box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
        }

        .form-control-premium::placeholder {
            color: rgba(255,255,255,0.35);
        }

        .form-label-premium {
            color: #d4af37;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: block;
        }

        /* ========== LOADING ========== */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.97);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s;
        }

        .premium-spinner {
            width: 60px;
            height: 60px;
            border: 3px solid rgba(212,175,55,0.2);
            border-top: 3px solid #d4af37;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .hero-premium {
                min-height: 50vh;
            }
            
            .hero-content {
                padding: 50px 20px;
            }
            
            .restaurant-logo {
                letter-spacing: 3px;
            }
            
            .restaurant-subtitle {
                letter-spacing: 4px;
            }
            
            .table-badge-premium {
                padding: 8px 20px;
                font-size: 0.85rem;
            }
            
            .order-summary {
                position: relative;
                top: 0;
                margin-bottom: 20px;
            }
            
            .image-container {
                height: 180px;
            }
            
            .qty-btn {
                width: 36px;
                height: 36px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .hero-premium {
                min-height: 55vh;
            }
        }

        @media (min-width: 1440px) {
            .container {
                max-width: 1400px;
            }
        }
    </style>
</head>
<body>

<div class="premium-bg"></div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="premium-spinner"></div>
</div>

<!-- HERO SECTION SUPER PREMIUM -->
<div class="hero-premium">
    <div class="hero-background"></div>
    <div class="hero-content">
        <div class="restaurant-logo">
            SEAFOOD BANG UGI
        </div>
        <div class="restaurant-subtitle">
            FINE DINING & SEAFOOD EXCELLENCE
        </div>
        <div class="divider-premium"></div>
        <div class="table-badge-premium">
            <i class="fas fa-crown"></i>
            YOUR TABLE
            <span class="table-number">#<?php echo $no_meja; ?></span>
            <i class="fas fa-utensils"></i>
        </div>
    </div>
    <div class="scroll-indicator" onclick="document.getElementById('menu-section').scrollIntoView({ behavior: 'smooth' })">
        <i class="fas fa-chevron-down"></i>
    </div>
</div>

<div class="container mt-4" id="menu-section">
    <div class="row">
        <!-- Main Menu Column -->
        <div class="col-lg-8">
            <form method="POST" id="orderForm">
                <input type="hidden" name="meja" value="<?php echo $no_meja; ?>">
                
                <!-- Guest Name -->
                <div class="mb-3">
                    <label class="form-label-premium">
                        <i class="fas fa-user-circle"></i> GUEST NAME
                    </label>
                    <input type="text" name="nama" class="form-control-premium" placeholder="Enter your name..." required>
                </div>

                <?php foreach($menu_seafood as $kategori => $items): ?>
                    <h3 class="category-title-premium">
                        <i class="fas fa-<?php echo $kategori == 'Makanan' ? 'fish' : ($kategori == 'Minuman' ? 'wine-glass-alt' : 'ice-cream'); ?>"></i>
                        <?php echo strtoupper($kategori); ?>
                    </h3>
                    
                    <div class="row">
                        <?php foreach($items as $nama_menu => $detail): 
                            $menu_key = md5($nama_menu);
                        ?>
                        <div class="col-md-6">
                            <div class="premium-card">
                                <div class="image-container">
                                    <img src="<?php echo $detail['gambar']; ?>" class="card-image" alt="<?php echo $nama_menu; ?>" loading="lazy" onerror="this.src='https://placehold.co/400x300/1a1a2e/d4af37?text=Seafood+Amin'">
                                    <div class="price-tag">
                                        Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?>
                                    </div>
                                    <?php if(isset($detail['rating'])): ?>
                                    <div class="rating-badge">
                                        <i class="fas fa-star"></i> <?php echo $detail['rating']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-content">
                                    <div class="menu-title"><?php echo $nama_menu; ?></div>
                                    <div class="menu-desc" id="desc_<?php echo $menu_key; ?>">
                                        <?php echo substr($detail['deskripsi'], 0, 80); ?>...
                                    </div>
                                    <span class="read-more" data-menu="<?php echo $menu_key; ?>" data-full="<?php echo htmlspecialchars($detail['deskripsi']); ?>" data-short="<?php echo substr($detail['deskripsi'], 0, 80); ?>...">
                                        Read more <i class="fas fa-arrow-right"></i>
                                    </span>
                                    
                                    <div class="menu-meta">
                                        <?php if(isset($detail['kalori'])): ?>
                                        <span><i class="fas fa-fire"></i> <?php echo $detail['kalori']; ?></span>
                                        <?php endif; ?>
                                        <?php if(isset($detail['waktu'])): ?>
                                        <span><i class="fas fa-clock"></i> <?php echo $detail['waktu']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if(isset($detail['alergen'])): ?>
                                    <div>
                                        <?php foreach($detail['alergen'] as $alergen): ?>
                                        <span class="allergen-badge">⚠️ <?php echo $alergen; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="qty-control">
                                        <div class="qty-btn" data-menu="<?php echo $menu_key; ?>" data-delta="-1">−</div>
                                        <span class="qty-value" id="qty_<?php echo $menu_key; ?>">0</span>
                                        <div class="qty-btn" data-menu="<?php echo $menu_key; ?>" data-delta="1">+</div>
                                        <input type="hidden" name="jumlah[<?php echo $nama_menu; ?>]" id="input_<?php echo $menu_key; ?>" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <div class="order-section">
                    <button type="submit" name="kirim" class="btn-order-premium">
                        <i class="fas fa-paper-plane"></i> PLACE ORDER
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="order-summary">
                <div class="summary-title">
                    <span><i class="fas fa-receipt"></i> YOUR ORDER</span>
                    <span id="item-count">0 items</span>
                </div>
                <div id="summary-items">
                    <div style="color: rgba(255,255,255,0.35); text-align: center; padding: 30px 20px;">
                        <i class="fas fa-shopping-bag" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                        No items selected
                    </div>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span id="summary-total">Rp 0</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="height: 30px;"></div>

<script>
// Data menu untuk summary
const menuData = {
    <?php foreach($menu_seafood as $kategori => $items): ?>
        <?php foreach($items as $nama_menu => $detail): ?>
            "<?php echo md5($nama_menu); ?>": {
                nama: "<?php echo addslashes($nama_menu); ?>",
                harga: <?php echo $detail['harga']; ?>
            },
        <?php endforeach; ?>
    <?php endforeach; ?>
};

// Update ringkasan pesanan
function updateSummary() {
    let total = 0;
    let itemCount = 0;
    let html = '';
    
    for (const [key, data] of Object.entries(menuData)) {
        const input = document.getElementById('input_' + key);
        const qty = input ? parseInt(input.value) : 0;
        
        if (qty > 0) {
            const subtotal = data.harga * qty;
            total += subtotal;
            itemCount += qty;
            let namaSingkat = data.nama.length > 25 ? data.nama.substring(0, 22) + '...' : data.nama;
            html += `
                <div class="summary-item">
                    <span>${namaSingkat} <span style="color: #d4af37;">x${qty}</span></span>
                    <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;
        }
    }
    
    if (html === '') {
        html = '<div style="color: rgba(255,255,255,0.35); text-align: center; padding: 30px 20px;"><i class="fas fa-shopping-bag" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>No items selected</div>';
    }
    
    document.getElementById('summary-items').innerHTML = html;
    document.getElementById('summary-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('item-count').innerText = itemCount + ' items';
}

// Ubah quantity
function changeQty(menuKey, delta) {
    const qtySpan = document.getElementById('qty_' + menuKey);
    const input = document.getElementById('input_' + menuKey);
    let currentQty = parseInt(qtySpan.innerText);
    let newQty = currentQty + delta;
    if (newQty < 0) newQty = 0;
    qtySpan.innerText = newQty;
    input.value = newQty;
    updateSummary();
}

// Toggle read more
function toggleReadMore(menuKey, fullText, shortText, btnElement) {
    const descEl = document.getElementById('desc_' + menuKey);
    
    if (descEl.style.webkitLineClamp === '2' || descEl.classList.contains('truncated')) {
        // Tampilkan full
        descEl.style.display = 'block';
        descEl.style.webkitLineClamp = 'unset';
        descEl.classList.remove('truncated');
        descEl.innerHTML = fullText;
        btnElement.innerHTML = 'Show less <i class="fas fa-arrow-up"></i>';
    } else {
        // Tampilkan pendek
        descEl.style.display = '-webkit-box';
        descEl.style.webkitLineClamp = '2';
        descEl.classList.add('truncated');
        descEl.innerHTML = shortText;
        btnElement.innerHTML = 'Read more <i class="fas fa-arrow-right"></i>';
    }
}

// Event listeners setelah halaman loading
document.addEventListener('DOMContentLoaded', function() {
    // Tombol + -
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const menuKey = this.getAttribute('data-menu');
            const delta = parseInt(this.getAttribute('data-delta'));
            changeQty(menuKey, delta);
        });
    });
    
    // Tombol read more
    document.querySelectorAll('.read-more').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const menuKey = this.getAttribute('data-menu');
            const fullText = this.getAttribute('data-full');
            const shortText = this.getAttribute('data-short');
            toggleReadMore(menuKey, fullText, shortText, this);
        });
    });
    
    // Inisialisasi
    updateSummary();
});

// Form submit
const form = document.getElementById('orderForm');
const loadingOverlay = document.getElementById('loadingOverlay');

if (form) {
    form.addEventListener('submit', function(e) {
        let hasItems = false;
        for (const [key, data] of Object.entries(menuData)) {
            const input = document.getElementById('input_' + key);
            const qty = input ? parseInt(input.value) : 0;
            if (qty > 0) {
                hasItems = true;
                break;
            }
        }
        
        if (!hasItems) {
            e.preventDefault();
            alert('⚠️ Please order at least one item (minimal quantity 1)');
        } else {
            loadingOverlay.style.visibility = 'visible';
            loadingOverlay.style.opacity = '1';
        }
    });
}
</script>

<?php
if(isset($_POST['kirim'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $meja = $_POST['meja'];
    $jumlah_all = $_POST['jumlah'];
    
    $pesanan_final = "";
    $total_harga = 0;

    foreach($menu_seafood as $kategori => $items) {
        foreach($items as $nama_menu => $detail) {
            $qty = isset($jumlah_all[$nama_menu]) ? intval($jumlah_all[$nama_menu]) : 0;
            if($qty > 0){
                $subtotal = $detail['harga'] * $qty;
                $total_harga += $subtotal;
                $pesanan_final .= "- $nama_menu ($qty x) = Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            }
        }
    }
    
    if($total_harga > 0){
        $pesanan_final .= "\n────────────────\n";
        $pesanan_final .= "TOTAL: Rp " . number_format($total_harga, 0, ',', '.');

        $sql = "INSERT INTO pesanan (nama_pelanggan, nomor_meja, detail_pesanan) VALUES ('$nama', '$meja', '$pesanan_final')";
        if(mysqli_query($conn, $sql)){
            echo "<script>
                setTimeout(() => {
                    alert('✅ Order placed successfully! Please wait.');
                    window.location='input_pesanan.php?meja=$meja';
                }, 500);
            </script>";
        }
    }
}
?>
</body>
</html>