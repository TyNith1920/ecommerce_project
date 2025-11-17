<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title', 'Admin Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="{{ asset('admincss/vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admincss/vendor/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admincss/css/style.default.css') }}">
  <link rel="stylesheet" href="{{ asset('admincss/css/custom.css') }}">

  <style>
    /* 🌙 Theme Variables */
    :root {
      --bg-color: #f4f6f9;
      --sidebar-bg: rgba(45, 48, 53, 0.7);
      --sidebar-text: #ccc;
      --active-bg: #6c63ff;
      --text-color: #333;
      --card-bg: #fff;
      --nav-bg: rgba(255, 255, 255, 0.75);
    }

    body.dark-mode {
      --bg-color: #1e1e2f;
      --sidebar-bg: rgba(21, 22, 27, 0.55);
      --sidebar-text: #bbb;
      --text-color: #e0e0e0;
      --card-bg: #2b2b3b;
      --nav-bg: rgba(27, 28, 37, 0.7);
    }

    body {
      background-color: var(--bg-color);
      color: var(--text-color);
      font-family: 'Muli', sans-serif;
      transition: all 0.3s ease;
      overflow-x: hidden;
    }

    /* 🔷 Navbar */
    .custom-navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: linear-gradient(90deg, rgba(25,25,35,0.9), rgba(40,40,50,0.9));
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(108, 99, 255, 0.3);
      box-shadow: 0 3px 15px rgba(0,0,0,0.4);
      padding: 12px 40px;
      z-index: 1050;
    }

    .text-gradient {
      background: linear-gradient(90deg, #60a5fa, #a78bfa);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 700;
      letter-spacing: 1px;
      text-shadow: 0 0 8px rgba(99, 102, 241, 0.5);
    }

    /* 🟣 Sidebar */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background: var(--sidebar-bg);
      backdrop-filter: blur(12px);
      border-right: 1px solid rgba(108,99,255,0.2);
      box-shadow: 4px 0 25px rgba(0,0,0,0.25);
      transition: all 0.3s ease;
      z-index: 1000;
      padding-top: 80px; /* offset for navbar */
      overflow-y: auto;
    }

    .sidebar-header {
      text-align: center;
      padding: 20px 0 10px;
      background: rgba(108, 99, 255, 0.08);
    }

    .sidebar-header .avatar img {
      border-radius: 50%;
      width: 80px;
      height: 80px;
      object-fit: cover;
      border: 3px solid rgba(108, 99, 255, 0.9);
      box-shadow: 0 0 20px rgba(108, 99, 255, 0.7);
    }

    #sidebar ul {
      list-style: none;
      padding-left: 0;
      margin-top: 15px;
    }

    #sidebar ul li a {
      display: block;
      padding: 10px 20px;
      color: var(--sidebar-text);
      text-decoration: none;
      border-radius: 8px;
      transition: 0.3s;
    }

    #sidebar ul li a:hover,
    #sidebar ul li.active > a {
      background: linear-gradient(90deg, #6c63ff, #8b5cf6);
      color: white;
    }

    /* 🧭 Page Content */
    .page-content {
      margin-left: 240px;
      padding: 25px;
      margin-top: 90px !important;
      padding-top: 10px !important;
      background: var(--bg-color);
      min-height: calc(100vh - 80px);
      transition: all 0.3s ease;
    }

    /* 🌗 Toggle Button */
    #themeToggle {
      background: var(--active-bg);
      color: white;
      border: none;
      border-radius: 6px;
      padding: 6px 10px;
      cursor: pointer;
    }

    @media (max-width: 991px) {
      #sidebar {
        left: -240px;
      }
      #sidebar.active {
        left: 0;
      }
      .page-content {
        margin-left: 0;
      }

      body, html {
  height: 100%;
  background-color: #1e1e2f !important; /* dark background */
}

  .custom-navbar {
    background: linear-gradient(90deg, #1e1e2f, #2b2b3b) !important;
  }

  .page-content {
    background: #1e1e2f !important;
    color: #fff;
  }
    }
  </style>
</head>

<body>
  <!-- 🧊 Sidebar -->
  @include('admin.sidebar')

  <!-- 🖥️ Main Page -->
  <div class="page-content flex-grow-1">

    <!-- 🧭 Navbar -->
    <nav class="navbar custom-navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <button id="sidebarCollapse" class="btn btn-sm" title="Toggle Menu">
          <i class="fa fa-bars text-light"></i>
        </button>

        <span class="navbar-brand text-gradient fs-5">Admin Dashboard</span>

        <div class="d-flex align-items-center gap-2">
          <button id="themeToggle" class="btn btn-primary btn-sm px-3">🌙 Dark / ☀️ Light</button>
          <a href="/" class="btn btn-outline-light btn-sm px-3">Home</a>

          <!-- ✅ Secure Logout -->
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm px-3">
              Logout
            </button>
          </form>
        </div>
      </div>
    </nav>

    <!-- 🧩 Content -->
    <div class="container-fluid mt-4">
      @yield('content')
    </div>

    <!-- 🦶 Footer -->
    <footer class="text-center mt-5 mb-3">
      <p class="text-muted">
        2025 © By Team: <strong>Phanit & Sonisa</strong> |
        <a target="_blank" href="https://templateshub.net">Templates Hub</a>
      </p>
    </footer>
  </div>

  <!-- ⚙️ JS -->
  <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
      });
    }

    // ✅ Fallback for Products collapse (works even if Bootstrap JS fails)
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
      button.addEventListener('click', () => {
        const target = document.querySelector(button.dataset.bsTarget);
        if (target) {
          target.classList.toggle('show');
        }
      });
    });

    // 🌗 Dark/Light Theme Toggle
    const toggleBtn = document.getElementById('themeToggle');
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
      body.classList.add('dark-mode');
    }

    toggleBtn.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark' : 'light');
    });
  </script>
</body>
</html>
