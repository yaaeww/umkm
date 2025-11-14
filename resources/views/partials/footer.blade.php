<style>
    .footer-minimal {
        background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%);
        border-top: 2px solid rgba(255, 215, 0, 0.3);
        padding: 20px 15px;
        backdrop-filter: blur(10px);
        font-size: 14px;
        line-height: 1.6;
        text-align: center;
        margin-left: 0;
        margin-right: 0;
        width: 100%;
        position: relative;
        z-index: 100;
    }

    /* Container untuk memastikan konten tetap di tengah */
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .footer-main-text {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    .footer-minimal .text-theme {
        color: #e0e0e0 !important;
    }

    .footer-minimal .text-gold {
        color: var(--gold) !important;
    }

    .footer-minimal .brand {
        font-weight: 700;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        white-space: nowrap;
    }

    .footer-minimal .heart {
        color: #ff6b6b;
        animation: pulse 2s infinite;
        margin: 0 4px;
    }

    .footer-separator {
        color: rgba(255, 215, 0, 0.6);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Untuk layar desktop */
    @media (min-width: 768px) {
        .footer-minimal {
            padding: 20px 30px;
        }
        .footer-content {
            flex-direction: row;
            justify-content: space-between;
        }
        .footer-main-text {
            margin-bottom: 0;
            justify-content: flex-start;
        }
        .footer-copyright {
            text-align: right;
        }
    }

    /* Untuk layar sangat kecil (mobile) */
    @media (max-width: 576px) {
        .footer-minimal {
            padding: 15px 10px;
            font-size: 13px;
        }
        .footer-main-text {
            flex-direction: column;
            gap: 5px;
        }
        .footer-separator {
            display: none;
        }
    }

    /* Pastikan footer tidak tertutup sidebar */
    @media (min-width: 992px) {
        .footer-minimal {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }
        
        /* Jika ada sidebar yang terbuka */
        body.sidebar-open .footer-minimal {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
        }
    }

    /* Tambahan untuk compatibility dengan layout yang ada */
    .footer-minimal {
        box-sizing: border-box;
        flex-shrink: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1 0 auto;
    }
</style>

<div class="footer-minimal text-theme">
    <div class="footer-container">
        <div class="footer-content">
            
        </div>
    </div>
</div>