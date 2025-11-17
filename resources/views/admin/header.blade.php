<header class="main-header">
  <nav class="navbar navbar-expand-lg custom-navbar navbar-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <!-- Sidebar Toggle -->
      <button id="sidebarCollapse" class="btn btn-sm" title="Toggle Menu">
        <i class="fa fa-bars text-light"></i>
      </button>

      <!-- Brand -->
      <a href="{{ route('admin.dashboard') }}" class="navbar-brand text-gradient fs-5 m-0">
        <strong>Admin Dashboard</strong>
      </a>

      <!-- Right Controls -->
      <div class="d-flex align-items-center gap-2">
        <button id="themeToggle" class="btn btn-primary btn-sm px-3">
          🌙 Dark / ☀️ Light
        </button>

        <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm px-3">
          Home
        </a>

        <!-- Secure Logout -->
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm px-3">
            Logout
          </button>
        </form>
      </div>

    </div>
  </nav>
</header>

<style>
  /* ✅ Remove unwanted top spacing */
  .main-header {
    margin: 0;
    padding: 0;
  }

  .custom-navbar {
    margin: 0 !important;
    padding: 8px 20px !important;
    background: #1f2937 !important; /* dark blue-gray */
    border-bottom: 1px solid #374151;
  }

  .navbar-brand {
    color: #fff !important;
    font-weight: 600;
  }

  .btn-outline-light:hover {
    background: #fff;
    color: #111;
  }

  body {
    background: #1e1e1e !important;
    color: #f9fafb !important;
  }

  .page-content {
    margin-top: 0 !important;
    padding-top: 20px;
    background-color: #1e1e1e;
  }
</style>
