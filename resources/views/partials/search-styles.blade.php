{{--
    Tambahkan CSS ini ke dalam <style> di resources/views/partials/styles.blade.php
    Letakkan sebelum tag </style> penutup
--}}

/* ══ Search Bar ══════════════════════════════════════════════════════════ */
.search-bar-wrap {
    position: relative;
    width: 100%;
    max-width: 600px;
    margin: 1.5rem 0;
}

.search-bar {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 8px 8px 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.search-bar.focused {
    border-color: rgba(200, 255, 62, 0.4);
    box-shadow: 0 0 0 3px rgba(200, 255, 62, 0.08);
    background: var(--surface-2);
}

.search-bar input {
    flex: 1;
    border: none;
    background: transparent;
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 300;
    outline: none;
    min-width: 0;
}

.search-bar input::placeholder { color: var(--muted); }

.search-icon-left {
    font-size: 0.85rem;
    flex-shrink: 0;
    transition: color 0.2s;
}

.search-btn {
    background: var(--accent);
    border: none;
    border-radius: 10px;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.search-btn:hover {
    transform: scale(1.06);
    box-shadow: 0 0 16px rgba(200, 255, 62, 0.4);
}

.search-btn:active { transform: scale(0.97); }

/* ── Dropdown ── */
.search-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0; right: 0;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    z-index: 200;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
    animation: dropdown-in 0.18s ease;
}

@keyframes dropdown-in {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

.suggestion-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    cursor: pointer;
    transition: background 0.15s;
    border-bottom: 1px solid var(--border);
}

.suggestion-item:last-of-type { border-bottom: none; }

.suggestion-item:hover,
.suggestion-item.active {
    background: var(--surface-2);
}

.suggestion-img {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.suggestion-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--white);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.suggestion-price {
    font-size: 0.78rem;
    color: var(--accent);
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    margin-top: 0.15rem;
}

.suggestion-badge {
    font-size: 0.62rem;
    font-weight: 700;
    font-family: 'Syne', sans-serif;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 0.2rem 0.5rem;
    border-radius: 100px;
    flex-shrink: 0;
}

.badge-baru  { background: rgba(200,255,62,0.12); color: var(--accent);  border: 1px solid rgba(200,255,62,0.25); }
.badge-bekas { background: rgba(255,160,50,0.12); color: #ffaa33; border: 1px solid rgba(255,160,50,0.25); }

.suggestion-footer {
    padding: 0.75rem 1.25rem;
    font-size: 0.82rem;
    color: var(--accent);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: background 0.15s;
    border-top: 1px solid var(--border);
}

.suggestion-footer:hover { background: var(--surface-2); }

/* ── Responsive ── */
@media (max-width: 768px) {
    .search-bar-wrap { max-width: 100%; }
    .search-dropdown { border-radius: 12px; }
}
