<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
  {{-- Konfigurasi dasar dokumen dan metadata halaman. --}}
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  {{-- Judul tab browser dibuat dinamis berdasarkan nickname dari route/web.php. --}}
  <title>{{ $profile['nickname'] }} — Profile</title>
  {{-- Import font dari Google Fonts untuk nuansa modern & elegan. --}}
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;1,400&display=swap" rel="stylesheet"/>
  <style>
    /*
      Variabel warna untuk mode gelap.
      Semua komponen mengambil warna dari variabel ini agar mudah di-maintain.
    */
    [data-theme="dark"] {
      --bg:        #0F0F0E;
      --surface:   #1C1C1A;
      --surface2:  #252523;
      --border:    rgba(255,255,255,0.08);
      --text:      #EDEAE3;
      --text2:     #9A9690;
      --accent:    #D4A853;
      --accent-bg: rgba(212,168,83,0.1);
      --shadow:    0 8px 40px rgba(0,0,0,0.5);
      --toggle-icon: "☀️";
    }

    /*
      Variabel warna untuk mode terang.
      Nilai akan aktif saat atribut html = data-theme="light".
    */
    [data-theme="light"] {
      --bg:        #F4F1EB;
      --surface:   #FFFFFF;
      --surface2:  #F0EDE6;
      --border:    rgba(0,0,0,0.07);
      --text:      #1A1916;
      --text2:     #7A7570;
      --accent:    #B8873A;
      --accent-bg: rgba(184,135,58,0.1);
      --shadow:    0 8px 40px rgba(0,0,0,0.1);
      --toggle-icon: "🌙";
    }

    /* Reset default browser agar layout konsisten di semua device. */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { transition: background 0.3s, color 0.3s; }

    /* Body menjadi kanvas utama: background, font, dan jarak halaman. */
    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Bricolage Grotesque', sans-serif;
      font-weight: 300;
      min-height: 100vh;
      padding: 80px 20px 60px;
      transition: background 0.3s, color 0.3s;
    }

    /* Tombol floating untuk mengganti tema dark/light. */
    .theme-toggle {
      position: fixed;
      top: 20px; right: 20px;
      z-index: 100;
      width: 44px; height: 44px;
      border-radius: 50%;
      border: 1px solid var(--border);
      background: var(--surface);
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px;
      box-shadow: var(--shadow);
      transition: all 0.3s;
    }

    .theme-toggle:hover {
      border-color: var(--accent);
      transform: scale(1.08);
    }

    /* Card utama sebagai kontainer seluruh isi profil. */
    .card {
      max-width: 580px;
      margin: 0 auto;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      overflow: hidden;
      box-shadow: var(--shadow);
      opacity: 0;
      transform: translateY(20px);
      animation: appear 0.8s ease forwards 0.1s;
    }

    /* Hero section: avatar + nama + ringkasan role. */
    .hero {
      padding: 48px 40px 36px;
      display: flex;
      align-items: center;
      gap: 28px;
      border-bottom: 1px solid var(--border);
      background: var(--surface);
    }

    .avatar {
      width: 96px;
      height: 96px;
      border-radius: 50%;
      border: 2px solid var(--accent);
      background: var(--accent-bg);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-family: 'Lora', serif;
      font-size: 2.2rem;
      font-weight: 400;
      color: var(--accent);
      position: relative;
    }

    /* Styling gambar di avatar (jika memakai foto profil asli). */
    .avatar img {
      width: 100%; height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    .hero-text { flex: 1; }

    .greeting {
      font-size: 0.7rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 6px;
    }

    .fullname {
      font-size: clamp(1.5rem, 4vw, 2rem);
      font-weight: 600;
      line-height: 1.15;
      letter-spacing: -0.02em;
      margin-bottom: 6px;
    }

    .subrole {
      font-size: 0.82rem;
      color: var(--text2);
    }

    .subrole span {
      color: var(--accent);
    }

    /* Area konten utama setelah hero. */
    .body { padding: 36px 40px; }

    /* Paragraf bio dengan gaya italic untuk pemisahan visual. */
    .bio {
      font-family: 'Lora', serif;
      font-style: italic;
      font-size: 0.95rem;
      line-height: 1.8;
      color: var(--text2);
      margin-bottom: 36px;
      padding-bottom: 32px;
      border-bottom: 1px solid var(--border);
    }

    /* Label kecil antar section (contoh: Informasi, Kontak). */
    .sec-label {
      font-size: 0.65rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--text2);
      margin-bottom: 16px;
    }

    /* List informasi akademik/personal dalam bentuk row. */
    .info-list {
      display: flex;
      flex-direction: column;
      gap: 0;
      margin-bottom: 32px;
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
    }

    .info-item {
      display: flex;
      align-items: center;
      padding: 14px 18px;
      border-bottom: 1px solid var(--border);
      transition: background 0.2s;
    }

    .info-item:last-child { border-bottom: none; }
    .info-item:hover { background: var(--surface2); }

    .info-icon {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: var(--accent-bg);
      display: flex; align-items: center; justify-content: center;
      font-size: 14px;
      flex-shrink: 0;
      margin-right: 14px;
    }

    .info-key {
      font-size: 0.7rem;
      color: var(--text2);
      width: 90px;
      flex-shrink: 0;
    }

    .info-val {
      font-size: 0.85rem;
      color: var(--text);
      font-weight: 400;
      flex: 1;
    }

    /* Garis pembatas horizontal antar konten. */
    .divider {
      height: 1px;
      background: var(--border);
      margin: 32px 0;
    }

    /* Kartu link kontak (email/phone) dengan efek hover. */
    .contact-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 0;
    }

    .contact-link {
      display: flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      padding: 14px 18px;
      border: 1px solid var(--border);
      border-radius: 14px;
      color: var(--text);
      background: var(--surface2);
      transition: all 0.25s;
    }

    .contact-link:hover {
      border-color: var(--accent);
      background: var(--accent-bg);
    }

    .contact-link:hover .c-arrow {
      transform: translateX(4px);
      color: var(--accent);
    }

    .c-icon {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: var(--accent-bg);
      display: flex; align-items: center; justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .c-meta { flex: 1; }

    .c-type {
      font-size: 0.65rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text2);
      margin-bottom: 2px;
    }

    .c-val {
      font-size: 0.82rem;
      color: var(--text);
    }

    .c-arrow {
      font-size: 16px;
      color: var(--text2);
      transition: all 0.25s;
    }

    /* Footer status aktivitas dan copyright tahun berjalan. */
    .footer {
      padding: 20px 40px;
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: var(--surface2);
    }

    .footer-badge {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.72rem;
      color: var(--text2);
    }

    .status-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: #4CAF50;
      animation: blink 2.5s ease infinite;
    }

    .footer-year {
      font-size: 0.72rem;
      color: var(--text2);
    }

    /* Animasi masuk card saat halaman pertama kali dibuka. */
    @keyframes appear {
      to { opacity: 1; transform: translateY(0); }
    }

    /* Animasi kedip untuk indikator status aktif. */
    @keyframes blink {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0.3; }
    }

    /* Penyesuaian layout untuk layar kecil/mobile. */
    @media (max-width: 520px) {
      body { padding: 64px 12px 40px; }

      .hero {
        flex-direction: column;
        align-items: flex-start;
        padding: 32px 24px 28px;
        gap: 20px;
      }

      .body { padding: 28px 24px; }

      .footer { padding: 18px 24px; }

      .fullname { font-size: 1.5rem; }

      .info-key { width: 76px; }
    }
  </style>
</head>
<body>

{{--
  Tombol toggle tema.
  Ikon akan berubah sesuai mode aktif (☀️ untuk dark, 🌙 untuk light).
--}}
<button class="theme-toggle" id="toggleBtn" title="Ganti tema">☀️</button>

{{--
  Card utama sebagai wrapper seluruh isi profil.
  Semua section (hero, body, footer) berada di dalam card ini.
--}}
<div class="card">

  {{-- Hero: menampilkan foto, nama lengkap, nickname, dan jurusan. --}}
  <div class="hero">
    <div class="avatar">
      {{--
        Foto profil diambil dari folder public/img/foto.jpg.
        Jika file belum ada, ganti path atau gunakan inisial sebagai fallback.
      --}}
      <img src="{{ asset('img/foto.jpg') }}" alt="Foto Profil"/>
    </div>
    <div class="hero-text">
      <div class="greeting">Halo, saya</div>
      {{-- Nama lengkap berasal dari $profile['name'] yang dikirim route. --}}
      <div class="fullname">{{ $profile['name'] }}</div>
      <div class="subrole">
        {{--
          Menampilkan nickname + jurusan dalam satu baris.
          Contoh output: Agis · Teknik Informatika
        --}}
        <span>{{ $profile['nickname'] }}</span> &nbsp;·&nbsp; {{ $profile['major'] }}
      </div>
    </div>
  </div>

  {{-- Body: bagian isi utama profil (bio, informasi, dan kontak). --}}
  <div class="body">

    {{-- Bio singkat dari data $profile['bio'] yang dikirim dari route. --}}
    <p class="bio">{{ $profile['bio'] }}</p>

    {{-- Informasi akademik/personal ditampilkan dalam list item. --}}
    <div class="sec-label">Informasi</div>
    <div class="info-list">
      <div class="info-item">
        <div class="info-icon">🎓</div>
        <span class="info-key">Universitas</span>
        {{-- Value universitas ditampilkan dari array $profile. --}}
        <span class="info-val">{{ $profile['university'] }}</span>
      </div>
      <div class="info-item">
        <div class="info-icon">📚</div>
        <span class="info-key">Jurusan</span>
        <span class="info-val">{{ $profile['major'] }}</span>
      </div>
      <div class="info-item">
        <div class="info-icon">📅</div>
        <span class="info-key">Semester</span>
        <span class="info-val">{{ $profile['semester'] }}</span>
      </div>
      <div class="info-item">
        <div class="info-icon">📍</div>
        <span class="info-key">Lokasi</span>
        <span class="info-val">{{ $profile['location'] }}</span>
      </div>
    </div>

    {{-- Kontak interaktif: klik email membuka mail client, klik phone membuka dialer/WA. --}}
    <div class="sec-label">Kontak</div>
    <div class="contact-list">
      {{--
        Link mailto: akan membuka aplikasi email default user.
        Nilai email diambil dari $profile['email'].
      --}}
      <a class="contact-link" href="mailto:{{ $profile['email'] }}">
        <div class="c-icon">✉️</div>
        <div class="c-meta">
          <div class="c-type">Email</div>
          <div class="c-val">{{ $profile['email'] }}</div>
        </div>
        <span class="c-arrow">→</span>
      </a>
      {{--
        Link tel: dipakai untuk panggilan telepon/WhatsApp compatible app.
        preg_replace membersihkan karakter selain angka dan + supaya URL valid.
      --}}
      <a class="contact-link" href="tel:{{ preg_replace('/[^0-9+]/', '', $profile['phone']) }}">
        <div class="c-icon">📱</div>
        <div class="c-meta">
          <div class="c-type">WhatsApp / Phone</div>
          <div class="c-val">{{ $profile['phone'] }}</div>
        </div>
        <span class="c-arrow">→</span>
      </a>
    </div>

  </div>

  {{-- Footer: status saat ini + tahun otomatis menggunakan fungsi date('Y'). --}}
  <div class="footer">
    <div class="footer-badge">
      <span class="status-dot"></span>
      Aktif berkuliah
    </div>
    <span class="footer-year">{{ $profile['nickname'] }} © {{ date('Y') }}</span>
  </div>

</div>

<script>
  // Ambil elemen root HTML untuk manipulasi atribut data-theme.
  const html = document.documentElement;
  // Ambil tombol toggle untuk event klik.
  const btn  = document.getElementById('toggleBtn');
  // Ambil tema yang tersimpan di localStorage, default ke dark jika belum ada.
  const saved = localStorage.getItem('theme') || 'dark';

  // Terapkan tema yang tersimpan saat halaman pertama kali dimuat.
  html.setAttribute('data-theme', saved);
  // Sinkronkan ikon tombol dengan tema aktif.
  btn.textContent = saved === 'dark' ? '☀️' : '🌙';

  // Event klik untuk mengganti tema secara realtime.
  btn.addEventListener('click', () => {
    // Baca tema saat ini dari atribut HTML.
    const current = html.getAttribute('data-theme');
    // Tentukan tema berikutnya (toggle dark <-> light).
    const next    = current === 'dark' ? 'light' : 'dark';

    // Update atribut tema, update ikon, lalu simpan preferensi pengguna.
    html.setAttribute('data-theme', next);
    btn.textContent = next === 'dark' ? '☀️' : '🌙';
    localStorage.setItem('theme', next);
  });

  // Catatan:
  // localStorage menyimpan preferensi di browser user,
  // jadi saat refresh halaman, mode tema terakhir tetap dipakai.
</script>

</body>
</html>