<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $profile['nickname'] }} | Landing Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Fraunces:opsz,wght@9..144,400;9..144,600&display=swap" rel="stylesheet" />
  <style>
    [data-theme="dark"] {
      --bg: #0b0f18;
      --bg-alt: #121a27;
      --surface: rgba(21, 29, 43, 0.8);
      --surface-strong: #1b2435;
      --border: rgba(255, 255, 255, 0.1);
      --text: #eaf0ff;
      --muted: #9eabc8;
      --accent: #4ed0c5;
      --accent-soft: rgba(78, 208, 197, 0.12);
      --ok: #53d769;
      --shadow: 0 14px 44px rgba(0, 0, 0, 0.45);
    }

    [data-theme="light"] {
      --bg: #f2f7ff;
      --bg-alt: #e5efff;
      --surface: rgba(255, 255, 255, 0.82);
      --surface-strong: #ffffff;
      --border: rgba(17, 28, 45, 0.1);
      --text: #101b2e;
      --muted: #56627d;
      --accent: #0e9d92;
      --accent-soft: rgba(14, 157, 146, 0.12);
      --ok: #1f8f3b;
      --shadow: 0 12px 38px rgba(0, 38, 86, 0.14);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      min-height: 100vh;
      color: var(--text);
      background:
        radial-gradient(1000px 560px at 15% -5%, rgba(78, 208, 197, 0.2), transparent 55%),
        radial-gradient(900px 520px at 95% 15%, rgba(95, 132, 255, 0.18), transparent 54%),
        linear-gradient(180deg, var(--bg), var(--bg-alt));
      font-family: 'Sora', sans-serif;
      padding: 16px;
      transition: background 0.25s ease, color 0.25s ease;
    }

    .shell {
      width: min(980px, 100%);
      margin: 0 auto;
    }

    .topbar {
      position: sticky;
      top: 12px;
      z-index: 30;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 10px;
      border-radius: 14px;
      border: 1px solid var(--border);
      background: var(--surface);
      backdrop-filter: blur(12px);
      box-shadow: var(--shadow);
      margin-bottom: 14px;
    }

    .brand {
      font-size: 0.74rem;
      text-transform: uppercase;
      letter-spacing: 0.14em;
      color: var(--muted);
      text-decoration: none;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--muted);
      font-size: 0.78rem;
      border: 1px solid transparent;
      border-radius: 999px;
      padding: 8px 11px;
      transition: 0.2s ease;
    }

    .nav-links a:hover {
      border-color: var(--accent);
      color: var(--accent);
      background: var(--accent-soft);
    }

    .actions {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .theme-toggle,
    .logout-btn {
      border: 1px solid var(--border);
      background: var(--surface-strong);
      color: var(--text);
      cursor: pointer;
      transition: 0.2s ease;
    }

    .theme-toggle {
      width: 38px;
      height: 38px;
      border-radius: 999px;
      font-size: 16px;
    }

    .menu-toggle {
      display: none;
      width: 38px;
      height: 38px;
      border-radius: 999px;
      font-size: 19px;
      line-height: 1;
      border: 1px solid var(--border);
      background: var(--surface-strong);
      color: var(--text);
      cursor: pointer;
    }

    .logout-btn {
      border-radius: 999px;
      padding: 10px 14px;
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.09em;
    }

    .theme-toggle:hover,
    .menu-toggle:hover,
    .logout-btn:hover,
    .cta:hover,
    .cta-ghost:hover {
      border-color: var(--accent);
      color: var(--accent);
      transform: translateY(-1px);
    }

    .mobile-menu {
      display: none;
      margin-top: -4px;
      margin-bottom: 12px;
      border: 1px solid var(--border);
      border-radius: 14px;
      background: var(--surface);
      padding: 10px;
      box-shadow: var(--shadow);
    }

    .mobile-menu.open {
      display: grid;
      gap: 8px;
      animation: menuIn 0.18s ease;
    }

    .mobile-menu a {
      text-decoration: none;
      color: var(--text);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 9px 10px;
      font-size: 0.82rem;
      background: var(--surface-strong);
    }

    .mobile-menu .logout-btn {
      width: 100%;
      border-radius: 10px;
      text-transform: none;
      letter-spacing: 0;
      font-size: 0.82rem;
      padding: 9px 10px;
    }

    .hero {
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 18px;
      background: var(--surface);
      box-shadow: var(--shadow);
      overflow: hidden;
      position: relative;
      isolation: isolate;
      margin-bottom: 14px;
    }

    .hero::after {
      content: "";
      position: absolute;
      inset: auto -40px -90px auto;
      width: 180px;
      height: 180px;
      border-radius: 50%;
      background: var(--accent-soft);
      z-index: -1;
    }

    .hero-top {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 14px;
    }

    .avatar {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      border: 2px solid var(--accent);
      overflow: hidden;
      flex-shrink: 0;
    }

    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .hello {
      font-size: 0.67rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--muted);
      margin-bottom: 5px;
    }

    h1 {
      font-family: 'Fraunces', serif;
      font-size: 1.55rem;
      line-height: 1.16;
      font-weight: 600;
      margin-bottom: 4px;
    }

    .subtitle {
      font-size: 0.82rem;
      color: var(--muted);
      line-height: 1.5;
    }

    .bio {
      color: var(--muted);
      line-height: 1.8;
      font-size: 0.9rem;
      margin-bottom: 16px;
    }

    .hero-cta {
      display: grid;
      grid-template-columns: 1fr;
      gap: 8px;
    }

    .cta,
    .cta-ghost {
      text-decoration: none;
      border-radius: 12px;
      padding: 12px;
      text-align: center;
      font-size: 0.82rem;
      border: 1px solid var(--border);
      transition: 0.2s ease;
    }

    .cta {
      background: var(--accent);
      color: #04211e;
      border-color: transparent;
      font-weight: 600;
    }

    .cta-ghost {
      background: var(--surface-strong);
      color: var(--text);
    }

    .grid {
      display: grid;
      gap: 12px;
    }

    .panel {
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 16px;
      background: var(--surface);
      box-shadow: var(--shadow);
    }

    .label {
      font-size: 0.64rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--muted);
      margin-bottom: 12px;
    }

    .facts {
      display: grid;
      gap: 10px;
    }

    .fact {
      padding: 10px 12px;
      border: 1px solid var(--border);
      border-radius: 10px;
      background: var(--surface-strong);
    }

    .fact-key {
      display: block;
      font-size: 0.65rem;
      color: var(--muted);
      margin-bottom: 3px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }

    .fact-val {
      font-size: 0.86rem;
      line-height: 1.5;
    }

    .status {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 12px;
      padding: 7px 10px;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: var(--surface-strong);
      font-size: 0.75rem;
      color: var(--muted);
    }

    .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--ok);
      animation: pulse 2s ease infinite;
    }

    .contact-list {
      display: grid;
      gap: 8px;
    }

    .contact-link {
      text-decoration: none;
      color: var(--text);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 12px;
      background: var(--surface-strong);
      transition: 0.2s ease;
      display: block;
    }

    .contact-link:hover {
      border-color: var(--accent);
      transform: translateY(-1px);
    }

    .contact-type {
      font-size: 0.62rem;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.14em;
      margin-bottom: 4px;
    }

    .contact-value {
      font-size: 0.85rem;
      line-height: 1.4;
    }

    .footer {
      margin-top: 14px;
      text-align: center;
      color: var(--muted);
      font-size: 0.74rem;
      padding-bottom: 20px;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.35; }
    }

    @keyframes menuIn {
      from { opacity: 0; transform: translateY(-6px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 799px) {
      .nav-links,
      .logout-form {
        display: none;
      }

      .menu-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
      }
    }

    @media (min-width: 800px) {
      body {
        padding: 20px;
      }

      .hero {
        padding: 26px;
      }

      .hero-top {
        gap: 18px;
      }

      .avatar {
        width: 90px;
        height: 90px;
      }

      h1 {
        font-size: 2.2rem;
      }

      .hero-cta {
        grid-template-columns: 1fr 1fr;
        max-width: 380px;
      }

      .grid {
        grid-template-columns: 1fr 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="shell">
    <nav class="topbar">
      <a class="brand" href="#home">My Profile</a>
      <div class="nav-links">
        <a href="#tentang">Tentang</a>
        <a href="#kontak">Kontak</a>
      </div>
      <div class="actions">
        <button class="menu-toggle" id="menuBtn" title="Menu">&#8942;</button>
        <button class="theme-toggle" id="toggleBtn" title="Ganti tema">☀️</button>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" class="logout-btn">Keluar</button>
        </form>
      </div>
    </nav>

    <div class="mobile-menu" id="mobileMenu">
      <a href="#tentang">Tentang</a>
      <a href="#kontak">Kontak</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Keluar</button>
      </form>
    </div>

    <section class="hero" id="home">
      <div class="hero-top">
        <div class="avatar">
          <img src="{{ asset('img/foto.jpg') }}" alt="Foto {{ $profile['name'] }}" />
        </div>
        <div>
          <div class="hello">Hai, saya</div>
          <h1>{{ $profile['name'] }}</h1>
          <p class="subtitle">{{ $profile['nickname'] }} • {{ $profile['major'] }} • {{ $profile['semester'] }}</p>
        </div>
      </div>

      <p class="bio">{{ $profile['bio'] }}</p>

      <div class="hero-cta">
        <a class="cta" href="#kontak">Hubungi Saya</a>
        <a class="cta-ghost" href="#tentang">Lihat Detail</a>
      </div>
    </section>

    <main class="grid">
      <section class="panel" id="tentang">
        <div class="label">Informasi Profil</div>
        <div class="facts">
          <div class="fact">
            <span class="fact-key">Universitas</span>
            <span class="fact-val">{{ $profile['university'] }}</span>
          </div>
          <div class="fact">
            <span class="fact-key">Jurusan</span>
            <span class="fact-val">{{ $profile['major'] }}</span>
          </div>
          <div class="fact">
            <span class="fact-key">Semester</span>
            <span class="fact-val">{{ $profile['semester'] }}</span>
          </div>
          <div class="fact">
            <span class="fact-key">Lokasi</span>
            <span class="fact-val">{{ $profile['location'] }}</span>
          </div>
        </div>

        <div class="status">
          <span class="dot"></span>
          Aktif berkuliah
        </div>
      </section>

      <section class="panel" id="kontak">
        <div class="label">Kontak</div>
        <div class="contact-list">
          <a class="contact-link" href="mailto:{{ $profile['email'] }}">
            <div class="contact-type">Email</div>
            <div class="contact-value">{{ $profile['email'] }}</div>
          </a>
          <a class="contact-link" href="tel:{{ preg_replace('/[^0-9+]/', '', $profile['phone']) }}">
            <div class="contact-type">WhatsApp / Phone</div>
            <div class="contact-value">{{ $profile['phone'] }}</div>
          </a>
        </div>
      </section>
    </main>

    <footer class="footer">
      {{ $profile['nickname'] }} © {{ date('Y') }}
    </footer>
  </div>

  <script>
    const html = document.documentElement;
    const btn = document.getElementById('toggleBtn');
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const saved = localStorage.getItem('theme') || 'dark';

    html.setAttribute('data-theme', saved);
    btn.textContent = saved === 'dark' ? '☀️' : '🌙';

    btn.addEventListener('click', () => {
      const current = html.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';

      html.setAttribute('data-theme', next);
      btn.textContent = next === 'dark' ? '☀️' : '🌙';
      localStorage.setItem('theme', next);
    });

    if (menuBtn && mobileMenu) {
      menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
      });

      mobileMenu.querySelectorAll('a').forEach((item) => {
        item.addEventListener('click', () => {
          mobileMenu.classList.remove('open');
        });
      });
    }
  </script>
</body>
</html>