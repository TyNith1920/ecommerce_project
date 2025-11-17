@php
use Illuminate\Support\Facades\Route;
@endphp

<header class="header_section glass-navbar fixed-top">
  <nav class="navbar navbar-expand-lg container-fluid">
    <!-- Brand -->
    <a class="navbar-brand text-light fw-bold fs-3 glow-text" href="{{ url('/') }}">
      LFC<span class="text-warning">SHOP</span>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Center Menu -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav gap-3">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('shop') ? 'active' : '' }}" href="{{ url('shop') }}">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('why') ? 'active' : '' }}" href="{{ url('why') }}">Feedback</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('testimonial') ? 'active' : '' }}" href="{{ url('testimonial') }}">Rating</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a>
        </li>
      </ul>
    </div>

    <!-- Right Side -->
    <div class="d-flex align-items-center user-option-wrapper me-3">

      {{-- Logged-in users --}}
      @auth
      <!-- My Orders -->
      <a href="{{ url('myorders') }}" class="text-light fw-semibold d-flex align-items-center nav-btn-glow me-3">
        <i class="fa-solid fa-box me-1"></i> My Orders
      </a>

      <!-- Cart -->
      <a href="{{ url('mycart') }}" class="text-light position-relative me-3">
        <i class="fa fa-shopping-bag" style="font-size:22px;"></i>
        <span id="cart_count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          {{ $count ?? 0 }}
        </span>
      </a>

      <!-- Wishlist -->
      @if (Route::has('wishlist.index'))
      <a href="{{ route('wishlist.index') }}" class="text-light fw-semibold d-flex align-items-center nav-btn-glow me-3">
        <i class="bi bi-heart me-1"></i> My Wishlist
      </a>
      @endif

      <!-- Profile dropdown -->
      <div class="dropdown">
        <a class="dropdown-toggle text-light fw-semibold text-decoration-none d-flex align-items-center"
          href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img
            src="{{ auth()->user()?->profile_photo
                ? asset('storage/' . auth()->user()->profile_photo)
                : asset('images/profile.png') }}"
            alt="profile" class="rounded-circle me-2 shadow-glow" width="35" height="35">
          {{ auth()->user()?->name }}
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
          <li><a class="dropdown-item" href="{{ url('/profile') }}">👤 Profile</a></li>
          <li><a class="dropdown-item" href="{{ url('/settings') }}">⚙️ Settings</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger">🚪 Logout</button>
            </form>
          </li>
        </ul>
      </div>
      @endauth

      {{-- Guests --}}
      @guest
      <a href="{{ url('/login') }}" class="btn-glow text-light fw-semibold px-3 py-1 rounded me-2">Login</a>
      <a href="{{ url('/register') }}" class="btn-glow btn-warning text-dark fw-semibold px-3 py-1 rounded">Register</a>
      @endguest
    </div>
  </nav>
</header>

<!-- 🌈 Header Style -->
<style>
  .glass-navbar {
    background: rgba(15, 107, 99, 0.75);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    z-index: 1000;
  }

  .glow-text {
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.6), 0 0 25px rgba(255, 215, 0, 0.6);
    transition: 0.3s;
  }

  .glow-text:hover {
    color: #FFD43B !important;
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.8), 0 0 30px rgba(255, 215, 0, 0.9);
  }

  .nav-link {
    color: #f5f5f5 !important;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
  }

  .nav-link:hover,
  .nav-link.active {
    color: #FFD43B !important;
    text-shadow: 0 0 8px rgba(255, 212, 59, 0.8);
  }

  .nav-link::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 2px;
    left: 0;
    bottom: -4px;
    background: #FFD43B;
    transition: all 0.3s ease;
  }

  .nav-link:hover::after {
    width: 100%;
  }

  .user-option-wrapper {
    display: flex;
    align-items: center;
    gap: 28px;
  }

  .nav-btn-glow:hover {
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    transition: all 0.3s ease;
  }

  .shadow-glow {
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.4),
      0 0 15px rgba(255, 215, 0, 0.2),
      inset 0 0 6px rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease-in-out;
    border: 2px solid rgba(255, 215, 0, 0.6);
  }

  .shadow-glow:hover {
    box-shadow: 0 0 15px rgba(255, 223, 0, 0.8),
      0 0 30px rgba(255, 255, 200, 0.6),
      inset 0 0 8px rgba(255, 255, 255, 0.4);
    transform: scale(1.05);
    border-color: rgba(255, 230, 100, 0.9);
  }

  body {
    padding-top: 80px;
  }

  .navbar-toggler {
    border: none;
    color: white;
    font-size: 20px;
  }

  .navbar-toggler:focus {
    box-shadow: none;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>