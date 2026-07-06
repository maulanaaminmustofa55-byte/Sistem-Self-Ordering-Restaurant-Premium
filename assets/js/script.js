function loadPesanan() {
    const container = document.getElementById('konten-pesanan');
    
    if (container) {
        container.innerHTML = `
            <div class="col-12 text-center mt-5">
                <div class="loading-spinner"></div>
                <h3 class="text-secondary mt-3" style="font-size: clamp(1rem, 5vw, 1.3rem);">nungguin pesanan...</h3>
            </div>
        `;
    }
    
    fetch('get_data.php')
        .then(response => response.text())
        .then(data => {
            if (container) {
                container.innerHTML = data;
                const newCards = document.querySelectorAll('.card-pesanan-custom').length;
                window.pesananCount = newCards;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            if (container) {
                container.innerHTML = `
                    <div class="col-12 text-center mt-5">
                        <h3 class="text-danger" style="font-size: clamp(1rem, 5vw, 1.3rem);">⚠️ gagal dapet data bos</h3>
                        <button class="btn btn-warning mt-3" onclick="loadPesanan()" style="padding: 8px 20px; background: #c9a03d; border: none; color: #0d0c0a; border-radius: 40px;">coba lagi</button>
                    </div>
                `;
            }
        });
}

function selesaikan(id) {
    if(confirm('✅ udah jadi nih pesanannya?\n\nYakin? klik OK aja.')) {
        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = '⏳ proses...';
        btn.disabled = true;
        
        fetch('update_status.php?id=' + id)
            .then(() => {
                loadPesanan();
                showToast('selesai! 🎉 silahkan diantar');
            })
            .catch(err => {
                console.error('Error:', err);
                showToast('gagal update status!', 'error');
            })
            .finally(() => {
                if (btn) {
                    btn.innerText = originalText;
                    btn.disabled = false;
                }
            });
    }
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        left: ${window.innerWidth <= 480 ? '20px' : 'auto'};
        background: ${type === 'success' ? '#4a7c59' : '#b55b3c'};
        color: white;
        padding: clamp(10px, 4vw, 14px) clamp(15px, 5vw, 22px);
        border-radius: 50px;
        font-weight: 500;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        font-size: clamp(0.8rem, 4vw, 0.9rem);
        text-align: center;
        font-family: 'Segoe UI', sans-serif;
    `;
    toast.innerHTML = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

window.addEventListener('resize', function() {
    const toasts = document.querySelectorAll('[style*="position: fixed"][style*="bottom: 20px"]');
    toasts.forEach(toast => {
        if (window.innerWidth <= 480) {
            toast.style.left = '20px';
            toast.style.right = '20px';
        } else {
            toast.style.left = 'auto';
            toast.style.right = '20px';
        }
    });
});

if (!document.querySelector('#toast-styles')) {
    const style = document.createElement('style');
    style.id = 'toast-styles';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        @media (max-width: 480px) {
            @keyframes slideIn {
                from {
                    transform: translateY(100%);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateY(0);
                    opacity: 1;
                }
                to {
                    transform: translateY(100%);
                    opacity: 0;
                }
            }
        }
    `;
    document.head.appendChild(style);
}

document.addEventListener('DOMContentLoaded', function() {
    loadPesanan();
    setInterval(loadPesanan, 5000);
});