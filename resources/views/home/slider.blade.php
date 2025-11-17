{{-- resources/views/home/slider.blade.php --}}

<!-- 🌟 Top Hero + Category Sidebar -->
<section class="home-top-section py-5">
  <div class="container">
    <div class="row g-4 align-items-stretch">

      <!-- 📂 Category Sidebar -->
      <aside class="col-lg-3 d-none d-lg-block">
        <div class="card category-card h-100">
          <div class="card-body">
            <h6 class="text-uppercase small text-muted mb-3">ប្រភេទទំនិញ</h6>
            <ul class="list-unstyled mb-0 category-list">
              <li><a href="{{ url('shop?category=jersey') }}">👕 Jersey / Shirt</a></li>
              <li><a href="{{ url('shop?category=men') }}">🧍‍♂️ Men's Fashion</a></li>
              <li><a href="{{ url('shop?category=women') }}">🧍‍♀️ Woman's Fashion</a></li>
              <li><a href="{{ url('shop?category=electronics') }}">💻 Electronics</a></li>
              <li><a href="{{ url('shop?category=sports') }}">⚽ Sports &amp; Outdoor</a></li>
              <li><a href="{{ url('shop') }}">📦 All Products</a></li>
            </ul>
          </div>
        </div>
      </aside>

      <!-- 🎯 Hero Banner -->
      <div class="col-lg-9">
        <div class="card hero-card h-100 border-0 overflow-hidden">
          <div class="row g-0 align-items-center h-100">
            <!-- Text -->
            <div class="col-md-7">
              <div class="hero-text p-4 p-lg-5 text-light">
                <p class="mb-2 small text-uppercase text-warning fw-semibold">LFCShop Online Store</p>
                <h1 class="fw-bold mb-3 hero-title">
                  សូមស្វាគមន៍មកកាន់ <span class="text-warning">LFCShop!</span><br>
                  <span class="fw-bolder">Welcome To Our Shop</span>
                </h1>
                <p class="mb-4 hero-subtitle">
                  យើងផ្តល់ជូននូវផលិតផលគុណភាពខ្ពស់ និងសេវាកម្មដ៏ល្អប្រណិត
                  <br>
                  <em>High-quality products &amp; excellent service for every fan.</em>
                </p>
                <div class="d-flex flex-wrap gap-2">
                  <a href="{{ url('/shop') }}" class="btn btn-warning fw-bold rounded-pill px-4">
                    🛒 ចាប់ផ្តើមទិញឥឡូវនេះ
                  </a>
                  <a href="{{ url('/contact') }}" class="btn btn-outline-light rounded-pill px-4">
                    📞 ទាក់ទងមកយើង
                  </a>
                </div>
              </div>
            </div>
            <!-- Image -->
            <div class="col-md-5 text-center">
              <div class="p-4 p-lg-5">
                <img src="{{ asset('images/Free.png') }}" alt="LFCShop Banner"
                  class="img-fluid hero-img rounded-4 shadow-lg">
              </div>
            </div>
          </div>

          <!-- small slider dots style (static like template 2) -->
          <div class="hero-dots d-flex justify-content-center align-items-center gap-2 pb-3">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- 🔥 Flash Sale / Promotion Section -->
<section class="flash-sale-section py-5">
  <div class="container">
    <div class="card flash-card border-0">
      <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
          <div>
            <p class="small mb-1 text-danger fw-semibold text-uppercase">Today’s</p>
            <h3 class="fw-bold mb-0 text-light">Flash Sales</h3>
          </div>

          <!-- Countdown -->
          <div class="d-flex align-items-center gap-3 text-center text-light">
            <div>
              <div class="fs-5 fw-bold" id="flashDays">03</div>
              <small class="text-uppercase">Days</small>
            </div>
            <span class="fs-4 fw-bold">:</span>
            <div>
              <div class="fs-5 fw-bold" id="flashHours">23</div>
              <small class="text-uppercase">Hours</small>
            </div>
            <span class="fs-4 fw-bold">:</span>
            <div>
              <div class="fs-5 fw-bold" id="flashMinutes">59</div>
              <small class="text-uppercase">Minutes</small>
            </div>
            <span class="fs-4 fw-bold">:</span>
            <div>
              <div class="fs-5 fw-bold" id="flashSeconds">59</div>
              <small class="text-uppercase">Seconds</small>
            </div>
          </div>
        </div>

        {{-- 🔻 Promotion text / button --}}
        <div class="row align-items-center g-4">
          <div class="col-lg-7 text-light">
            <h4 class="fw-bold mb-2">
              🔥 Promotion Special – បញ្ចុះតម្លៃ <span class="text-warning">30%</span>
            </h4>
            <p class="mb-3">
              សម្រាប់ផលិតផលជ្រើសរើសពិសេស រយៈពេលកំណត់តែប៉ុណ្ណោះ។
              ចាប់ឱកាសនេះឲ្យបានឆាប់ មុននឹងផុតពេល!
            </p>
            <a href="{{ url('/shop') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
              🛒 ទិញ Flash Sale ឥឡូវនេះ
            </a>
          </div>

          <div class="col-lg-5 text-center">
            <img src="{{ asset('images/Promotion.png') }}" alt="Discount"
              class="img-fluid promo-img rounded-4 shadow-lg">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- 🎯 Styles for new home top layout --}}
<style>
  .home-top-section {
    background: linear-gradient(135deg, #005f56, #0b7c73);
  }

  .flash-sale-section {
    background: linear-gradient(135deg, #ff4b5c, #ff6a3d);
  }

  .category-card {
    border-radius: 16px;
    border: none;
    background: rgba(0, 0, 0, 0.15);
    color: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
  }

  .category-list li+li {
    margin-top: 0.35rem;
  }

  .category-list a {
    display: block;
    padding: 0.35rem 0.5rem;
    border-radius: 999px;
    font-size: 0.95rem;
    color: #000000ff;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .category-list a:hover {
    background: rgba(0, 0, 0, 0.72);
    color: #ffd43b;
    transform: translateX(4px);
  }

  .hero-card {
    background: radial-gradient(circle at top left, #0fa39a 0, #04544c 45%, #023835 100%);
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
  }

  .hero-title {
    font-size: clamp(1.8rem, 2.4vw + 1rem, 2.8rem);
    line-height: 1.2;
  }

  .hero-subtitle {
    font-size: 0.98rem;
    max-width: 470px;
  }

  .hero-img {
    max-height: 260px;
    object-fit: contain;
  }

  .hero-dots .dot {
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.4);
    transition: all 0.2s ease;
  }

  .hero-dots .dot.active {
    width: 18px;
    background: #ffd43b;
  }

  .flash-card {
    border-radius: 24px;
    background: rgba(0, 0, 0, 0.1);
    box-shadow: 0 18px 35px rgba(0, 0, 0, 0.35);
  }

  .flash-card .card-body {
    padding: 1.8rem 1.8rem 2.1rem;
  }

  @media (max-width: 991.98px) {
    .home-top-section {
      padding-top: 5rem;
    }

    .flash-card .card-body {
      padding: 1.5rem;
    }
  }
</style>

{{-- ⏱️ Simple countdown for Flash Sales (change target date as you like) --}}
<script>
  (function() {
    const targetDate = new Date("2025-12-31T23:59:59").getTime(); // 👉 ប្ដូរថ្ងៃទីនេះតាមចិត្ត

    function updateTimer() {
      const now = new Date().getTime();
      let distance = targetDate - now;

      if (distance < 0) distance = 0;

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
      const minutes = Math.floor((distance / (1000 * 60)) % 60);
      const seconds = Math.floor((distance / 1000) % 60);

      document.getElementById('flashDays').textContent = String(days).padStart(2, '0');
      document.getElementById('flashHours').textContent = String(hours).padStart(2, '0');
      document.getElementById('flashMinutes').textContent = String(minutes).padStart(2, '0');
      document.getElementById('flashSeconds').textContent = String(seconds).padStart(2, '0');
    }

    updateTimer();
    setInterval(updateTimer, 1000);
  })();
</script>
  