<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    [data-theme="dark"] {
      --bg: #0b0f18;
      --bg-alt: #121a27;
      --surface: rgba(21, 29, 43, 0.82);
      --border: rgba(255, 255, 255, 0.1);
      --text: #eaf0ff;
      --accent: #4ed0c5;
      --shadow: 0 14px 44px rgba(0, 0, 0, 0.45);
    }

    [data-theme="light"] {
      --bg: #f2f7ff;
      --bg-alt: #e5efff;
      --surface: rgba(255, 255, 255, 0.88);
      --border: rgba(17, 28, 45, 0.1);
      --text: #101b2e;
      --accent: #0e9d92;
      --shadow: 0 12px 38px rgba(0, 38, 86, 0.14);
    }

    body {
      min-height: 100vh;
      display: grid;
      place-items: center;
      background:
        radial-gradient(1000px 560px at 15% -5%, rgba(78, 208, 197, 0.2), transparent 55%),
        radial-gradient(900px 520px at 95% 15%, rgba(95, 132, 255, 0.18), transparent 54%),
        linear-gradient(180deg, var(--bg), var(--bg-alt));
      font-family: 'Segoe UI', Arial, sans-serif;
      color: var(--text);
      padding: 16px;
      transition: background 0.25s ease, color 0.25s ease;
    }

    .theme-toggle {
      position: fixed;
      top: 16px;
      right: 16px;
      width: 38px;
      height: 38px;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: var(--surface);
      color: var(--text);
      cursor: pointer;
      font-size: 16px;
      box-shadow: var(--shadow);
    }

    .login-card {
      border: 1px solid var(--border);
      background: var(--surface);
      border-radius: 14px;
      padding: 18px;
      box-shadow: var(--shadow);
    }

    .login-btn {
      border: 1px solid transparent;
      border-radius: 10px;
      padding: 12px 22px;
      font-size: 1rem;
      cursor: pointer;
      background: var(--accent);
      color: #062320;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <button class="theme-toggle" id="toggleBtn" title="Ganti tema">☀️</button>

  <div class="login-card">
    <form method="POST" action="{{ route('masuk') }}">
      @csrf
      <button type="submit" class="login-btn">Masuk</button>
    </form>
  </div>

  <script>
    const html = document.documentElement;
    const btn = document.getElementById('toggleBtn');
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
  </script>
</body>
</html>
