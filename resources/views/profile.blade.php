<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
  {{-- Metadata dasar halaman + judul dinamis dari data profile. --}}
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $profile['nickname'] }} | Landing Profile</title>
  {{-- Font utama untuk isi (Sora) dan heading (Fraunces). --}}
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Fraunces:opsz,wght@9..144,400;9..144,600&display=swap" rel="stylesheet" />
  <style>
    /* Variabel warna untuk mode gelap. Aktif saat html[data-theme="dark"]. */
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

    /* Variabel warna untuk mode terang. Aktif saat html[data-theme="light"]. */
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

    /* Reset dasar agar ukuran elemen konsisten di semua browser. */
    * { box-sizing: border-box; margin: 0; padding: 0; }

    /* Scroll halus untuk navigasi anchor (contoh: #tentang, #kontak). */
    html { scroll-behavior: smooth; }

    /* Latar belakang utama: kombinasi gradient + warna dari variabel tema. */
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

    /* Kontainer maksimum halaman agar konten tetap nyaman dibaca di layar besar. */
    .shell {
      width: min(980px, 100%);
      margin: 0 auto;
    }

    /* Navbar sticky di atas halaman + anchor posisi dropdown mobile. */
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

    /* Brand kiri atas pada navbar. */
    .brand {
      font-size: 0.74rem;
      text-transform: uppercase;
      letter-spacing: 0.14em;
      color: var(--muted);
      text-decoration: none;
    }

    /* Link navigasi desktop. */
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

    /* Kelompok tombol aksi kanan atas (menu hp, tema, logout). */
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

    /* Tombol ganti tema. Ikon diisi via JavaScript. */
    .theme-toggle {
      width: 38px;
      height: 38px;
      border-radius: 999px;
      font-size: 16px;
    }

    /* Tombol tiga titik, hanya tampil di mode mobile. */
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

    /* Tombol logout desktop. */
    .logout-btn {
      border-radius: 999px;
      padding: 10px 14px;
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.09em;
    }

    /* Efek hover seragam untuk elemen interaktif utama. */
    .theme-toggle:hover,
    .menu-toggle:hover,
    .logout-btn:hover,
    .cta:hover,
    .cta-ghost:hover {
      border-color: var(--accent);
      color: var(--accent);
      transform: translateY(-1px);
    }

    /* Panel menu dropdown mobile (muncul saat tiga titik diklik). */
    .mobile-menu {
      display: none;
      position: absolute;
      top: calc(100% + 8px);
      right: 10px;
      width: min(220px, calc(100vw - 36px));
      border: 1px solid var(--border);
      border-radius: 12px;
      background: var(--surface);
      padding: 8px;
      box-shadow: var(--shadow);
      z-index: 50;
    }

    /* Class .open ditambahkan/dihapus via JavaScript. */
    .mobile-menu.open {
      display: grid;
      gap: 6px;
      animation: menuIn 0.18s ease;
    }

    .mobile-menu a {
      text-decoration: none;
      color: var(--text);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 8px 9px;
      font-size: 0.8rem;
      background: var(--surface-strong);
    }

    .mobile-menu .logout-btn {
      width: 100%;
      border-radius: 10px;
      text-transform: none;
      letter-spacing: 0;
      font-size: 0.8rem;
      padding: 8px 9px;
    }

    /* Kartu hero sebagai section pembuka landing profile. */
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

    /* Ornamen background lingkaran lembut di area hero. */
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

    /* Baris atas hero: avatar + identitas singkat. */
    .hero-top {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 14px;
    }

    /* Avatar profil berbentuk lingkaran dengan border aksen. */
    .avatar {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      border: 2px solid var(--accent);
      overflow: hidden;
      flex-shrink: 0;
    }

    /* Foto menyesuaikan kotak avatar tanpa distorsi. */
    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Teks kecil pembuka sebelum nama. */
    .hello {
      font-size: 0.67rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--muted);
      margin-bottom: 5px;
    }

    /* Heading utama nama profile. */
    h1 {
      font-family: 'Fraunces', serif;
      font-size: 1.55rem;
      line-height: 1.16;
      font-weight: 600;
      margin-bottom: 4px;
    }

    /* Baris info ringkas: nickname, jurusan, semester. */
    .subtitle {
      font-size: 0.82rem;
      color: var(--muted);
      line-height: 1.5;
    }

    /* Bio singkat dari data profile. */
    .bio {
      color: var(--muted);
      line-height: 1.8;
      font-size: 0.9rem;
      margin-bottom: 16px;
    }

    /* Tombol CTA hero (mobile satu kolom, desktop dua kolom). */
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

    /* CTA utama dengan warna aksen kontras. */
    .cta {
      background: var(--accent);
      color: #04211e;
      border-color: transparent;
      font-weight: 600;
    }

    /* CTA sekunder model ghost. */
    .cta-ghost {
      background: var(--surface-strong);
      color: var(--text);
    }

    /* Layout dua panel konten utama (responsive). */
    .grid {
      display: grid;
      gap: 12px;
    }

    /* Card panel untuk section tentang/kontak. */
    .panel {
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 16px;
      background: var(--surface);
      box-shadow: var(--shadow);
    }

    /* Label section kecil (uppercase). */
    .label {
      font-size: 0.64rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--muted);
      margin-bottom: 12px;
    }

    /* List fakta profile di panel informasi. */
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

    /* Kunci label fakta (contoh: Universitas, Jurusan). */
    .fact-key {
      display: block;
      font-size: 0.65rem;
      color: var(--muted);
      margin-bottom: 3px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }

    /* Nilai fakta utama. */
    .fact-val {
      font-size: 0.86rem;
      line-height: 1.5;
    }

    /* Badge status aktivitas. */
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

    /* Titik indikator status aktif dengan animasi pulse. */
    .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--ok);
      animation: pulse 2s ease infinite;
    }

    /* List kontak (email + telepon). */
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

    /* Hover kartu kontak agar terasa interaktif. */
    .contact-link:hover {
      border-color: var(--accent);
      transform: translateY(-1px);
    }

    /* Label jenis kontak. */
    .contact-type {
      font-size: 0.62rem;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.14em;
      margin-bottom: 4px;
    }

    /* Nilai detail kontak. */
    .contact-value {
      font-size: 0.85rem;
      line-height: 1.4;
    }

    /* Footer sederhana dengan nama + tahun dinamis. */
    .footer {
      margin-top: 14px;
      text-align: center;
      color: var(--muted);
      font-size: 0.74rem;
      padding-bottom: 20px;
    }

    /* Animasi indikator status aktif. */
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.35; }
    }

    /* Animasi kemunculan menu mobile saat dibuka. */
    @keyframes menuIn {
      from { opacity: 0; transform: translateY(-6px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Aturan mobile: sembunyikan nav desktop + tampilkan tiga titik. */
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

      .mobile-menu {
        display: none;
      }
    }

    /* Aturan desktop: layout diperbesar untuk ruang layar lebih lebar. */
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

      .mobile-menu {
        display: none !important;
      }
    }
  </style>
</head>
<body>
  {{--
    Catatan umum file ini:
    1) Data profile dikirim dari route /profile pada routes/web.php.
    2) Mode tema disimpan di localStorage dengan key "theme".
    3) Navbar mobile menggunakan tombol tiga titik + class .open.
  --}}
  <div class="shell">
    {{-- Navbar utama: brand, navigasi, tombol menu mobile, tema, dan logout. --}}
    <nav class="topbar">
      <a class="brand" href="#home">My Profile</a>
      <div class="nav-links">
        <a href="#tentang">Tentang</a>
        <a href="#kontak">Kontak</a>
      </div>
      <div class="actions">
        <button class="menu-toggle" id="menuBtn" title="Menu">&#8942;</button>
        <button class="theme-toggle" id="toggleBtn" title="Ganti tema">☀️</button>
        {{-- Form logout wajib POST + @csrf agar lolos validasi keamanan Laravel. --}}
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" class="logout-btn">Keluar</button>
        </form>
      </div>

      {{-- Dropdown menu ringkas untuk mode HP. --}}
      <div class="mobile-menu" id="mobileMenu">
        {{-- Anchor ini scroll ke section dengan id yang sesuai. --}}
        <a href="#tentang">Tentang</a>
        <a href="#kontak">Kontak</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-btn">Keluar</button>
        </form>
      </div>
    </nav>

    {{-- Hero section menampilkan ringkasan profile dan call-to-action. --}}
    <section class="hero" id="home">
      <div class="hero-top">
        <div class="avatar">
          {{-- Gambar diambil dari public/img/foto.jpg lewat helper asset(). --}}
          <img src="{{ asset('img/foto.jpg') }}" alt="Foto {{ $profile['name'] }}" />
        </div>
        <div>
          <div class="hello">Hai, saya</div>
          {{-- Semua nilai berikut berasal dari array $profile di route /profile. --}}
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

    {{-- Konten utama terdiri dari panel informasi dan panel kontak. --}}
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

      {{-- Panel kontak: memanfaatkan protokol mailto: dan tel:. --}}
      <section class="panel" id="kontak">
        <div class="label">Kontak</div>
        <div class="contact-list">
          {{-- mailto: membuka aplikasi email default di perangkat user. --}}
          <a class="contact-link" href="mailto:{{ $profile['email'] }}">
            <div class="contact-type">Email</div>
            <div class="contact-value">{{ $profile['email'] }}</div>
          </a>
          {{--
            tel: digunakan untuk panggilan telepon.
            preg_replace dipakai agar karakter non angka/non + dibersihkan dulu.
          --}}
          <a class="contact-link" href="tel:{{ preg_replace('/[^0-9+]/', '', $profile['phone']) }}">
            <div class="contact-type">WhatsApp / Phone</div>
            <div class="contact-value">{{ $profile['phone'] }}</div>
          </a>
        </div>
      </section>
    </main>

    {{-- Footer: tahun otomatis mengikuti waktu server. --}}
    <footer class="footer">
      {{ $profile['nickname'] }} © {{ date('Y') }}
    </footer>
  </div>

  <script>
    // Ambil elemen utama untuk manipulasi tema dan menu.
    const html = document.documentElement;
    const btn = document.getElementById('toggleBtn');
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    // Baca preferensi tema terakhir user dari localStorage.
    // Fallback ke dark bila user belum pernah memilih tema sebelumnya.
    const saved = localStorage.getItem('theme') || 'dark';

    // Terapkan tema saat halaman pertama kali dibuka.
    html.setAttribute('data-theme', saved);
    btn.textContent = saved === 'dark' ? '☀️' : '🌙';

    // Toggle tema gelap/terang lalu simpan kembali preferensinya.
    btn.addEventListener('click', () => {
      const current = html.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';

      html.setAttribute('data-theme', next);
      btn.textContent = next === 'dark' ? '☀️' : '🌙';
      localStorage.setItem('theme', next);
    });

    // Logika menu mobile: buka/tutup saat tombol tiga titik ditekan.
    // Guard ini mencegah error bila elemen menu tidak ditemukan.
    if (menuBtn && mobileMenu) {
      menuBtn.addEventListener('click', () => {
        // Toggle class .open agar menu mobile bisa tampil / tersembunyi.
        mobileMenu.classList.toggle('open');
        menuBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('open'));
      });

      // Tutup menu saat salah satu link di dalam menu dipilih.
      mobileMenu.querySelectorAll('a').forEach((item) => {
        item.addEventListener('click', () => {
          mobileMenu.classList.remove('open');
          menuBtn.setAttribute('aria-expanded', 'false');
        });
      });

      // Tutup menu saat area luar menu diklik.
      document.addEventListener('click', (event) => {
        const clickedInsideMenu = mobileMenu.contains(event.target);
        const clickedMenuButton = menuBtn.contains(event.target);

        if (!clickedInsideMenu && !clickedMenuButton) {
          mobileMenu.classList.remove('open');
          menuBtn.setAttribute('aria-expanded', 'false');
        }
      });
    }
  </script>
</body>
</html>