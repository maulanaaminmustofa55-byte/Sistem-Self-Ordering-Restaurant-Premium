<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>KDS PREMIUM - Seafood Amin | Kitchen Display System</title>
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
            overflow-x: hidden;
        }

        /* ========== BACKGROUND PREMIUM ========== */
        .kds-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0a0a 0%, #0f0f1a 50%, #0a0a0f 100%);
            z-index: -2;
        }

        .kds-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 60%);
            z-index: -1;
        }

        .kds-bg::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle at 70% 80%, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            z-index: -1;
        }

        /* ========== HEADER PREMIUM KDS ========== */
        .kds-header {
            background: linear-gradient(135deg, rgba(0,0,0,0.95) 0%, rgba(10,10,20,0.98) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            padding: 20px 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .kds-logo {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            font-weight: 800;
            letter-spacing: 3px;
            background: linear-gradient(135deg, #d4af37 0%, #f5e6a3 50%, #d4af37 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .kds-badge {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            color: white;
        }

        .kds-badge i {
            color: #d4af37;
            margin-right: 8px;
        }

        .live-clock {
            font-family: 'Courier New', monospace;
            font-size: clamp(1rem, 3vw, 1.5rem);
            font-weight: 700;
            background: rgba(0,0,0,0.5);
            padding: 8px 20px;
            border-radius: 50px;
            letter-spacing: 3px;
            color: #d4af37;
            border: 1px solid rgba(212,175,55,0.2);
        }

        /* ========== STATS BAR PREMIUM ========== */
        .stats-premium {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            background: rgba(15,15,25,0.8);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 20px 30px;
            margin: 25px 25px;
            border: 1px solid rgba(212,175,55,0.15);
        }

        .stat-premium-card {
            background: rgba(0,0,0,0.4);
            border-radius: 16px;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            border-left: 3px solid #d4af37;
            min-width: 180px;
        }

        .stat-premium-card:hover {
            transform: translateY(-3px);
            background: rgba(0,0,0,0.6);
        }

        .stat-icon-premium {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #d4af37;
        }

        .stat-info-premium {
            display: flex;
            flex-direction: column;
        }

        .stat-label-premium {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .stat-value-premium {
            font-size: clamp(1.3rem, 4vw, 2rem);
            font-weight: 800;
            color: #d4af37;
            line-height: 1;
        }

        /* ========== ORDER GRID - OPTIMIZED FOR TV ========== */
        .order-grid-premium {
            padding: 0 25px 30px 25px;
        }

        .kds-title {
            font-family: 'Playfair Display', serif;
            color: #d4af37;
            font-size: clamp(1.2rem, 3.5vw, 1.6rem);
            font-weight: 700;
            margin: 20px 0 25px 0;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(212,175,55,0.3);
            display: inline-block;
        }

        /* ========== CARD PESANAN PREMIUM ========== */
        .order-card-premium {
            background: linear-gradient(135deg, rgba(20,20,35,0.95) 0%, rgba(15,15,25,0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(212,175,55,0.12);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 25px;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .order-card-premium:hover {
            transform: translateY(-8px);
            border-color: rgba(212,175,55,0.4);
            box-shadow: 0 25px 45px rgba(0,0,0,0.4), 0 0 25px rgba(212,175,55,0.1);
        }

        /* New order animation */
        @keyframes newOrderGlow {
            0% {
                border-color: rgba(212,175,55,0.12);
                box-shadow: none;
            }
            50% {
                border-color: #d4af37;
                box-shadow: 0 0 30px rgba(212,175,55,0.3);
            }
            100% {
                border-color: rgba(212,175,55,0.12);
                box-shadow: none;
            }
        }

        .order-card-premium.new-order {
            animation: newOrderGlow 1s ease;
        }

        /* Card Header */
        .card-header-premium {
            background: linear-gradient(135deg, rgba(231,76,60,0.9), rgba(192,57,43,0.9));
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-number-premium {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            font-weight: 800;
            color: white;
            letter-spacing: 2px;
        }

        .table-number-premium i {
            margin-right: 10px;
            color: #d4af37;
        }

        .queue-number-premium {
            background: rgba(0,0,0,0.5);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #d4af37;
        }

        /* Card Body */
        .card-body-premium {
            padding: 22px;
            flex: 1;
        }

        .customer-name-premium {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .customer-name-premium i {
            color: #27ae60;
            margin-right: 10px;
        }

        .order-time-premium {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.6);
            margin-bottom: 18px;
        }

        .order-time-premium i {
            margin-right: 6px;
        }

        /* Timer Countdown */
        .timer-premium {
            background: rgba(0,0,0,0.3);
            border-radius: 12px;
            padding: 8px 15px;
            margin-bottom: 18px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .timer-premium i {
            color: #d4af37;
        }

        .timer-value {
            font-weight: 700;
            color: white;
        }

        /* Detail Pesanan */
        .order-detail-premium {
            background: rgba(0,0,0,0.3);
            border-radius: 16px;
            padding: 18px;
            margin-top: 10px;
            font-family: 'Courier New', monospace;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            line-height: 1.6;
            color: rgba(255,255,255,0.85);
            max-height: 250px;
            overflow-y: auto;
        }

        .order-detail-premium::-webkit-scrollbar {
            width: 5px;
        }

        .order-detail-premium::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }

        .order-detail-premium::-webkit-scrollbar-thumb {
            background: #d4af37;
            border-radius: 10px;
        }

        /* Button Siap Saji */
        .btn-ready-premium {
            background: linear-gradient(135deg, #27ae60, #219a52);
            border: none;
            padding: 16px;
            font-weight: 800;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            border-radius: 0;
            letter-spacing: 2px;
            color: white;
        }

        .btn-ready-premium:hover {
            transform: scale(1.02);
            filter: brightness(1.05);
            box-shadow: 0 5px 25px rgba(39,174,96,0.3);
        }

        /* Empty State */
        .empty-state-premium {
            text-align: center;
            padding: 80px 30px;
            background: rgba(15,15,25,0.6);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            margin: 50px 0;
            border: 1px solid rgba(212,175,55,0.15);
        }

        .empty-state-premium i {
            font-size: clamp(3rem, 10vw, 5rem);
            color: #d4af37;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state-premium h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            color: white;
        }

        /* Toast Notification Premium */
        .toast-premium {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #d4af37, #b8960c);
            color: #0a0a0a;
            padding: 15px 25px;
            border-radius: 16px;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 10px 30px rgba(212,175,55,0.3);
            font-size: 0.9rem;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Skeleton Loading */
        .skeleton-premium {
            background: rgba(255,255,255,0.05);
            border-radius: 24px;
            height: 400px;
            animation: skeletonPulse 1.5s ease-in-out infinite;
        }

        @keyframes skeletonPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        /* Scrollbar Global */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #d4af37, #b8960c);
            border-radius: 10px;
        }

        /* ========== RESPONSIVE ========== */
        /* TV / Large Desktop (min 1366px) */
        @media (min-width: 1366px) {
            .order-grid-premium .row {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
                gap: 25px;
            }
            
            .order-grid-premium .col {
                padding: 0;
            }
            
            .stats-premium {
                margin: 30px 35px;
                padding: 25px 35px;
            }
            
            .stat-premium-card {
                padding: 18px 30px;
            }
            
            .stat-icon-premium {
                width: 60px;
                height: 60px;
                font-size: 1.8rem;
            }
            
            .stat-value-premium {
                font-size: 2rem;
            }
            
            .order-card-premium {
                margin-bottom: 0;
            }
        }

        /* 4K TV (min 2560px) */
        @media (min-width: 2560px) {
            .container {
                max-width: 2400px;
                margin: 0 auto;
            }
            
            .order-grid-premium .row {
                grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
                gap: 35px;
            }
            
            .stats-premium {
                margin: 40px 50px;
            }
            
            .stat-premium-card {
                padding: 25px 40px;
            }
            
            .stat-icon-premium {
                width: 80px;
                height: 80px;
                font-size: 2.2rem;
            }
            
            .stat-value-premium {
                font-size: 2.5rem;
            }
            
            .card-header-premium {
                padding: 25px 30px;
            }
            
            .card-body-premium {
                padding: 30px;
            }
            
            .order-detail-premium {
                font-size: 1rem;
                padding: 22px;
            }
            
            .btn-ready-premium {
                padding: 20px;
                font-size: 1.1rem;
            }
        }

        /* Tablet & Mobile */
        @media (max-width: 768px) {
            .kds-header {
                padding: 12px 16px;
            }
            
            .stats-premium {
                margin: 15px;
                padding: 15px;
                flex-direction: column;
            }
            
            .stat-premium-card {
                width: 100%;
                justify-content: center;
            }
            
            .order-grid-premium {
                padding: 0 15px 20px 15px;
            }
            
            .toast-premium {
                left: 20px;
                right: 20px;
                text-align: center;
                justify-content: center;
            }
            
            @keyframes slideInRight {
                from {
                    transform: translateY(100%);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .stats-premium {
                margin: 20px;
            }
            
            .order-grid-premium .row {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 20px;
            }
            
            .order-grid-premium .col {
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="kds-bg"></div>

<!-- Header Premium KDS -->
<div class="kds-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="kds-logo">
                <i class="fas fa-utensils" style="color: #d4af37; margin-right: 10px;"></i>
                SEAFOOd BANG UGI
            </div>
            <div class="mt-2">
                <span class="kds-badge">
                    <i class="fas fa-tv"></i> KITCHEN DISPLAY SYSTEM
                </span>
                <span class="kds-badge ms-2">
                    <i class="fas fa-bolt"></i> REAL-TIME
                </span>
                <span class="kds-badge ms-2">
                    <i class="fas fa-mobile-alt"></i> SELF ORDER
                </span>
            </div>
        </div>
        <div class="live-clock" id="jam">
            00:00:00
        </div>
    </div>
</div>

<!-- Stats Premium -->
<div class="stats-premium">
    <div class="stat-premium-card">
        <div class="stat-icon-premium">
            <i class="fas fa-fish"></i>
        </div>
        <div class="stat-info-premium">
            <span class="stat-label-premium">RESTAURANT</span>
            <span class="stat-value-premium" style="font-size: clamp(1rem, 3vw, 1.3rem); color: white;">Seafood Bang Ugi</span>
        </div>
    </div>
    <div class="stat-premium-card">
        <div class="stat-icon-premium">
            <i class="fas fa-list-ol"></i>
        </div>
        <div class="stat-info-premium">
            <span class="stat-label-premium">ACTIVE ORDERS</span>
            <span class="stat-value-premium" id="total-pesanan">0</span>
        </div>
    </div>
    <div class="stat-premium-card">
        <div class="stat-icon-premium">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info-premium">
            <span class="stat-label-premium">LAST UPDATE</span>
            <span class="stat-value-premium" style="font-size: clamp(0.8rem, 2.5vw, 1rem);" id="last-update">-</span>
        </div>
    </div>
    <div class="stat-premium-card">
        <div class="stat-icon-premium">
            <i class="fas fa-qrcode"></i>
        </div>
        <div class="stat-info-premium">
            <span class="stat-label-premium">ORDER MODE</span>
            <span class="stat-value-premium" style="font-size: clamp(0.9rem, 2.8vw, 1.1rem);">QR Self Service</span>
        </div>
    </div>
</div>

<!-- Order Grid -->
<div class="order-grid-premium">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
        <h3 class="kds-title">
            <i class="fas fa-fire"></i> LIVE ORDERS
        </h3>
        <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">
            <i class="fas fa-sync-alt"></i> Auto-refresh every 5 seconds
        </span>
    </div>
    
    <div id="konten-pesanan" class="row">
        <div class="col-12">
            <div class="skeleton-premium"></div>
        </div>
        <div class="col-12 mt-3">
            <div class="skeleton-premium"></div>
        </div>
        <div class="col-12 mt-3">
            <div class="skeleton-premium"></div>
        </div>
    </div>
</div>

<script>
    // ========== JAM DIGITAL ==========
    setInterval(() => {
        const d = new Date();
        document.getElementById('jam').innerText = d.toLocaleTimeString('id-ID');
    }, 1000);

    let lastHtml = '';
    let lastOrderCount = 0;
    
    // ========== LOAD PESANAN DENGAN ANIMASI ==========
    function loadPesanan() {
        fetch('get_data.php')
            .then(response => response.text())
            .then(newHtml => {
                const container = document.getElementById('konten-pesanan');
                const now = new Date();
                document.getElementById('last-update').innerText = now.toLocaleTimeString('id-ID');
                
                // Hitung jumlah pesanan baru
                const newOrderCount = (newHtml.match(/order-card-premium/g) || []).length;
                const oldOrderCount = (lastHtml.match(/order-card-premium/g) || []).length;
                
                if (lastHtml !== newHtml && container) {
                    // Animasi fade
                    container.style.opacity = '0.5';
                    container.style.transition = 'opacity 0.2s ease';
                    
                    setTimeout(() => {
                        container.innerHTML = newHtml;
                        container.style.opacity = '1';
                        updateTotalPesanan();
                        
                        // Deteksi pesanan baru
                        if (newOrderCount > oldOrderCount && oldOrderCount !== 0) {
                            playNewOrderNotification();
                            showToastPremium('📢 NEW ORDER! Check kitchen display 🔥', 'new');
                        }
                        
                        // Tambah class animasi untuk card baru
                        if (newOrderCount > oldOrderCount) {
                            const cards = document.querySelectorAll('.order-card-premium');
                            for (let i = cards.length - (newOrderCount - oldOrderCount); i < cards.length; i++) {
                                if (cards[i]) {
                                    cards[i].classList.add('new-order');
                                    setTimeout(() => {
                                        cards[i].classList.remove('new-order');
                                    }, 1000);
                                }
                            }
                        }
                    }, 150);
                    lastHtml = newHtml;
                } else if (container && container.innerHTML !== newHtml) {
                    container.innerHTML = newHtml;
                    updateTotalPesanan();
                    lastHtml = newHtml;
                }
            })
            .catch(err => {
                console.error('Error:', err);
                const container = document.getElementById('konten-pesanan');
                if (container && container.innerHTML.indexOf('skeleton') === -1) {
                    container.innerHTML = `
                        <div class="col-12">
                            <div class="empty-state-premium">
                                <i class="fas fa-exclamation-triangle"></i>
                                <h2>Connection Error</h2>
                                <p style="color: rgba(255,255,255,0.5); margin-top: 15px;">Trying to reconnect...</p>
                            </div>
                        </div>
                    `;
                }
            });
    }

    function updateTotalPesanan() {
        const cards = document.querySelectorAll('.order-card-premium');
        const total = cards.length;
        const totalElement = document.getElementById('total-pesanan');
        if(totalElement) {
            totalElement.textContent = total;
        }
    }

    function playNewOrderNotification() {
        // Notifikasi suara (opsional - bisa diaktifkan)
        try {
            // const audio = new Audio('https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3');
            // audio.play().catch(e => console.log('Audio not supported'));
        } catch(e) {}
    }

    function showToastPremium(message, type = 'new') {
        const existingToast = document.querySelector('.toast-premium');
        if(existingToast) existingToast.remove();
        
        const toast = document.createElement('div');
        toast.className = 'toast-premium';
        toast.innerHTML = `
            <i class="fas ${type === 'new' ? 'fa-bell' : 'fa-check-circle'}" style="font-size: 1.3rem;"></i>
            <span>${message}</span>
            <i class="fas fa-utensils"></i>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    function selesaikan(id) {
        if(confirm('✅ Ready to serve this order?\n\nPress OK to confirm.')) {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> PROCESSING...';
            btn.disabled = true;
            
            fetch('update_status.php?id=' + id)
                .then(() => {
                    loadPesanan();
                    showToastPremium('✅ Order completed! Ready to serve 🎉', 'complete');
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToastPremium('❌ Failed to update status!', 'error');
                })
                .finally(() => {
                    if (btn) {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                });
        }
    }

    // ========== AUTO REFRESH ==========
    document.addEventListener('DOMContentLoaded', function() {
        loadPesanan();
        setInterval(loadPesanan, 5000);
    });
</script>

</body>
</html>