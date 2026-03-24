<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --ink:         #0a0a0f;
        --ink-2:       #1c1c27;
        --ink-3:       #2e2e40;
        --muted:       #6b6b80;
        --border:      rgba(255,255,255,0.07);
        --surface:     #13131e;
        --surface-2:   #1a1a28;
        --surface-3:   #212133;
        --accent:      #c8ff3e;
        --accent-2:    #7b61ff;
        --accent-glow: rgba(200, 255, 62, 0.15);
        --red:         #ff4d6d;
        --white:       #f0f0f5;
    }

    html { scroll-behavior: smooth; }

    body {
        background: var(--ink);
        color: var(--white);
        font-family: 'DM Sans', sans-serif;
        font-weight: 300;
        min-height: 100vh;
        overflow-x: hidden;
    }

    [x-cloak] { display: none !important; }

    /* Noise overlay */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: 0.4;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--surface); }
    ::-webkit-scrollbar-thumb { background: var(--ink-3); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--muted); }

    /* ── Navbar ── */
    nav.main-nav {
        position: sticky; top: 0; z-index: 50;
        background: rgba(10,10,15,0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border);
        padding: 0 2rem; height: 64px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nav-logo {
        font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.25rem;
        letter-spacing: -0.03em; color: var(--white); text-decoration: none;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .logo-dot {
        width: 8px; height: 8px; background: var(--accent); border-radius: 50%;
        box-shadow: 0 0 12px var(--accent);
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%,100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.4); opacity: 0.7; }
    }
    .nav-actions { display: flex; align-items: center; gap: 1rem; }
    .nav-btn {
        width: 42px; height: 42px; border-radius: 12px;
        background: var(--surface-2); border: 1px solid var(--border);
        color: var(--white); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s ease; font-size: 1rem; position: relative;
    }
    .nav-btn:hover {
        background: var(--surface-3); border-color: var(--accent);
        color: var(--accent); box-shadow: 0 0 20px var(--accent-glow);
    }
    .cart-badge {
        position: absolute; top: -6px; right: -6px;
        background: var(--accent); color: var(--ink);
        font-size: 10px; font-weight: 700; font-family: 'Syne', sans-serif;
        width: 18px; height: 18px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        animation: badge-pop 0.3s cubic-bezier(0.34,1.56,0.64,1);
    }
    @keyframes badge-pop {
        from { transform: scale(0); } to { transform: scale(1); }
    }

    /* ── Hero ── */
    .hero {
        padding: 5rem 2rem 3rem; position: relative; overflow: hidden;
    }
    .hero-bg-blob {
        position: absolute; pointer-events: none;
        border-radius: 50%;
    }
    .hero-bg-blob.purple {
        top: -80px; left: -100px; width: 600px; height: 400px;
        background: radial-gradient(ellipse, rgba(123,97,255,0.18) 0%, transparent 70%);
    }
    .hero-bg-blob.lime {
        top: 0; right: -50px; width: 400px; height: 300px;
        background: radial-gradient(ellipse, rgba(200,255,62,0.07) 0%, transparent 70%);
    }
    .hero-label {
        display: inline-flex; align-items: center; gap: 0.5rem;
        font-size: 0.7rem; font-weight: 500; letter-spacing: 0.15em;
        text-transform: uppercase; color: var(--accent);
        background: var(--accent-glow); border: 1px solid rgba(200,255,62,0.2);
        padding: 0.35rem 0.85rem; border-radius: 100px; margin-bottom: 1.5rem;
    }
    .hero h1 {
        font-family: 'Syne', sans-serif; font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        line-height: 1.05; letter-spacing: -0.04em;
        max-width: 700px; margin-bottom: 1rem;
    }
    .hero h1 span { color: var(--accent); }
    .hero-sub {
        color: var(--muted); font-size: 1rem; font-weight: 300;
        max-width: 480px; line-height: 1.7;
    }

    /* ── Layout ── */
    .main-layout {
        display: flex; gap: 1.5rem;
        padding: 0 2rem 4rem;
        max-width: 1400px; margin: 0 auto;
        align-items: flex-start;
    }

    /* ── Sidebar ── */
    .sidebar { width: 220px; flex-shrink: 0; position: sticky; top: 80px; }
    .sidebar-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 20px; padding: 1.5rem;
    }
    .sidebar-title {
        font-family: 'Syne', sans-serif; font-weight: 700;
        font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.12em;
        color: var(--muted); margin-bottom: 1.25rem;
    }
    .filter-item {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.6rem 0.75rem; border-radius: 10px;
        cursor: pointer; transition: all 0.2s; margin-bottom: 0.25rem;
    }
    .filter-item:hover { background: var(--surface-2); }
    .filter-item input[type="checkbox"] {
        appearance: none; width: 16px; height: 16px;
        border: 1.5px solid var(--ink-3); border-radius: 5px;
        flex-shrink: 0; transition: all 0.2s; cursor: pointer; position: relative;
    }
    .filter-item input[type="checkbox"]:checked {
        background: var(--accent); border-color: var(--accent);
    }
    .filter-item input[type="checkbox"]:checked::after {
        content: '✓'; position: absolute; top: 50%; left: 50%;
        transform: translate(-50%,-50%); font-size: 10px; color: var(--ink); font-weight: 700;
    }
    .filter-label { font-size: 0.875rem; color: var(--muted); transition: color 0.2s; }
    .filter-item:hover .filter-label { color: var(--white); }
    .apply-btn {
        width: 100%; margin-top: 1.25rem; padding: 0.75rem;
        background: var(--accent); color: var(--ink); border: none;
        border-radius: 12px; font-family: 'Syne', sans-serif;
        font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em;
        cursor: pointer; transition: all 0.2s;
    }
    .apply-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 24px var(--accent-glow); }

    /* ── Product Grid ── */
    .products-grid {
        flex: 1; display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    /* ── Product Card ── */
    .product-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 20px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
        animation: card-in 0.5s ease both;
    }
    @keyframes card-in {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .product-card:hover {
        border-color: rgba(200,255,62,0.2);
        transform: translateY(-4px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(200,255,62,0.1);
    }
    .card-img-wrap {
        position: relative; overflow: hidden;
        background: var(--surface-2); aspect-ratio: 4/3;
    }
    .card-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .product-card:hover .card-img-wrap img { transform: scale(1.05); }
    .card-badge {
        position: absolute; top: 10px; left: 10px;
        font-size: 0.65rem; font-weight: 600; font-family: 'Syne', sans-serif;
        letter-spacing: 0.08em; text-transform: uppercase;
        padding: 0.3rem 0.7rem; border-radius: 100px;
    }
    .badge-baru  { background: rgba(200,255,62,0.15); color: var(--accent);  border: 1px solid rgba(200,255,62,0.3); }
    .badge-bekas { background: rgba(255,160,50,0.12); color: #ffaa33;        border: 1px solid rgba(255,160,50,0.25); }
    .card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; gap: 0.5rem; }
    .card-name {
        font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.95rem;
        color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .card-price { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem; color: var(--accent); letter-spacing: -0.02em; }
    .add-btn {
        margin-top: auto; width: 100%; padding: 0.75rem;
        border: 1px solid var(--border); border-radius: 12px;
        background: transparent; color: var(--muted);
        font-family: 'DM Sans', sans-serif; font-size: 0.85rem; font-weight: 500;
        cursor: pointer; transition: all 0.25s ease;
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    }
    .add-btn:hover { background: var(--accent); color: var(--ink); border-color: var(--accent); font-weight: 700; box-shadow: 0 0 20px var(--accent-glow); }
    .col-span-full { grid-column: 1/-1; text-align: center; padding: 4rem 0; color: var(--muted); font-size: 0.875rem; }

    /* ── Cart Drawer ── */
    .drawer-overlay { position: fixed; inset: 0; z-index: 100; display: flex; justify-content: flex-end; }
    .drawer-bg { position: absolute; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); }
    .drawer {
        position: relative; width: 100%; max-width: 420px;
        background: var(--surface); height: 100%;
        overflow-y: auto; display: flex; flex-direction: column;
        border-left: 1px solid var(--border);
        animation: slide-in 0.35s cubic-bezier(0.22,1,0.36,1);
    }
    @keyframes slide-in { from { transform: translateX(100%); } to { transform: translateX(0); } }
    .drawer-header {
        padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
        position: sticky; top: 0; background: var(--surface); z-index: 10;
    }
    .drawer-title { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem; letter-spacing: -0.02em; }
    .drawer-close {
        width: 36px; height: 36px; border-radius: 10px;
        background: var(--surface-2); border: 1px solid var(--border);
        color: var(--muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; transition: all 0.2s;
    }
    .drawer-close:hover { color: var(--red); border-color: var(--red); background: rgba(255,77,109,0.1); }
    .drawer-body { padding: 1.5rem 1.75rem; flex: 1; display: flex; flex-direction: column; gap: 1.75rem; }
    .section-label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.12em; color: var(--muted); margin-bottom: 0.75rem; }
    .cart-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.85rem 1rem; background: var(--surface-2);
        border: 1px solid var(--border); border-radius: 14px; transition: border-color 0.2s;
    }
    .cart-item:hover { border-color: rgba(255,255,255,0.12); }
    .cart-item-name  { font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.85rem; color: var(--white); margin-bottom: 0.2rem; }
    .cart-item-price { font-size: 0.78rem; color: var(--accent); font-weight: 500; }
    .remove-btn {
        width: 30px; height: 30px; border-radius: 8px; background: transparent;
        border: 1px solid var(--border); color: var(--muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; transition: all 0.2s; flex-shrink: 0;
    }
    .remove-btn:hover { color: var(--red); border-color: var(--red); background: rgba(255,77,109,0.1); }
    .empty-cart { text-align: center; color: var(--muted); font-size: 0.875rem; padding: 2rem 0; }
    .empty-cart i { font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.3; display: block; }
    .form-input {
        width: 100%; padding: 0.8rem 1rem; margin-bottom: 0.75rem;
        background: var(--surface-2); border: 1px solid var(--border); border-radius: 12px;
        color: var(--white); font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem; font-weight: 300; transition: all 0.2s; outline: none;
    }
    .form-input::placeholder { color: var(--ink-3); }
    .form-input:focus { border-color: rgba(200,255,62,0.4); box-shadow: 0 0 0 3px var(--accent-glow); }
    .pay-option {
        display: flex; align-items: center; gap: 0.75rem; padding: 0.8rem 1rem;
        border: 1.5px solid var(--border); border-radius: 12px;
        cursor: pointer; transition: all 0.2s; margin-bottom: 0.5rem;
    }
    .pay-option.selected { border-color: var(--accent); background: var(--accent-glow); }
    .pay-option input[type="radio"] {
        appearance: none; width: 16px; height: 16px; border: 2px solid var(--ink-3);
        border-radius: 50%; transition: all 0.2s; position: relative; flex-shrink: 0;
    }
    .pay-option input[type="radio"]:checked { border-color: var(--accent); background: var(--accent); box-shadow: inset 0 0 0 3px var(--surface-2); }
    .pay-label { font-size: 0.85rem; color: var(--muted); transition: color 0.2s; }
    .pay-option.selected .pay-label { color: var(--white); font-weight: 500; }
    .drawer-footer {
        padding: 1.25rem 1.75rem; border-top: 1px solid var(--border);
        background: var(--surface); position: sticky; bottom: 0;
    }
    .total-row { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1rem; }
    .total-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--muted); }
    .total-value { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.6rem; color: var(--accent); letter-spacing: -0.03em; }
    .checkout-btn {
        width: 100%; padding: 1rem; background: var(--accent); color: var(--ink);
        border: none; border-radius: 14px; font-family: 'Syne', sans-serif;
        font-weight: 800; font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;
        cursor: pointer; transition: all 0.25s ease;
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    }
    .checkout-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(200,255,62,0.35); }
    .checkout-btn:disabled { background: var(--surface-3); color: var(--muted); cursor: not-allowed; }

    /* ── Success Modal ── */
    .modal-overlay { position: fixed; inset: 0; z-index: 200; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
    .modal-bg { position: absolute; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(12px); }
    .modal-card {
        position: relative; background: var(--surface);
        border: 1px solid rgba(200,255,62,0.2); border-radius: 28px;
        padding: 2.5rem 2rem; max-width: 360px; width: 100%; text-align: center;
        animation: modal-pop 0.4s cubic-bezier(0.34,1.56,0.64,1);
    }
    @keyframes modal-pop { from { transform: scale(0.7); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .success-icon {
        width: 72px; height: 72px;
        background: linear-gradient(135deg, var(--accent-glow), rgba(200,255,62,0.08));
        border: 1.5px solid rgba(200,255,62,0.3); border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem; font-size: 2rem; color: var(--accent);
        animation: icon-glow 2s ease-in-out infinite;
    }
    @keyframes icon-glow {
        0%,100% { box-shadow: 0 0 20px rgba(200,255,62,0.1); }
        50%      { box-shadow: 0 0 40px rgba(200,255,62,0.3); }
    }
    .modal-title { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.03em; margin-bottom: 0.5rem; }
    .modal-desc  { font-size: 0.875rem; color: var(--muted); line-height: 1.6; margin-bottom: 1.75rem; }
    .modal-btn {
        width: 100%; padding: 0.9rem; background: var(--accent); color: var(--ink);
        border: none; border-radius: 12px; font-family: 'Syne', sans-serif;
        font-weight: 800; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; letter-spacing: 0.03em;
    }
    .modal-btn:hover { box-shadow: 0 8px 24px rgba(200,255,62,0.3); transform: translateY(-1px); }

    /* ── Toast ── */
    .toast {
        position: fixed; bottom: 1.5rem; left: 50%;
        transform: translateX(-50%) translateY(80px);
        background: var(--surface-3); color: var(--white);
        border: 1px solid var(--border); border-radius: 100px;
        padding: 0.65rem 1.25rem; font-size: 0.82rem; z-index: 999;
        display: flex; align-items: center; gap: 0.5rem;
        transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1); white-space: nowrap;
    }
    .toast.show { transform: translateX(-50%) translateY(0); }
    .toast .t-dot { width: 6px; height: 6px; background: var(--accent); border-radius: 50%; box-shadow: 0 0 8px var(--accent); }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .main-layout { flex-direction: column; padding: 0 1rem 3rem; }
        .sidebar { width: 100%; position: static; }
        .hero { padding: 3rem 1rem 2rem; }
        nav.main-nav { padding: 0 1rem; }
    }
</style>
