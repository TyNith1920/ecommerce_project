<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Sellers - LFCShop</title>
  @include('home.css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom right, #1f8a70, #33b9a5, #80d6c4, #b9ebe0, #e8f6f2);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    .seller-section {
      padding: 60px 0;
    }

    .title {
      text-align: center;
      font-weight: 700;
      color: #0d6efd;
      text-shadow: 0 0 10px rgba(13,110,253,0.2);
      margin-bottom: 30px;
      font-size: 1.9rem;
    }

    .seller-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.1);
      overflow: hidden;
      text-align: center;
      transition: all 0.3s ease;
      position: relative;
    }

    .seller-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .seller-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .seller-info {
      padding: 16px;
    }

    .seller-name {
      font-weight: 700;
      font-size: 1.05rem;
      color: #111827;
      margin-bottom: 6px;
    }

    .seller-location {
      color: #4b5563;
      font-size: 0.9rem;
      margin-bottom: 6px;
    }

    .rating {
      color: #facc15;
      margin-bottom: 8px;
    }

    .btn-visit {
      background: #0d6efd;
      color: #fff;
      border-radius: 8px;
      padding: 6px 14px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.2s;
    }

    .btn-visit:hover {
      background: #0b5ed7;
    }

    .badge-top {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #16a34a;
      color: #fff;
      font-size: 0.75rem;
      padding: 4px 8px;
      border-radius: 6px;
    }

    @media (max-width: 576px) {
      .seller-img {
        height: 150px;
      }
    }
  </style>
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <section class="seller-section">
    <div class="container">
      <h2 class="title"><i class="fa-solid fa-store"></i> All Sellers</h2>

      <div class="row g-4 justify-content-center">
        @forelse($sellers as $seller)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="seller-card">
              <span class="badge-top">Top Rated</span>
              <img src="{{ asset('sellers/'.$seller->image ?? 'default_seller.jpg') }}" 
                   class="seller-img" alt="{{ $seller->name }}">
              <div class="seller-info">
                <div class="seller-name">{{ $seller->name }}</div>
                <div class="seller-location">
                  <i class="fa-solid fa-location-dot"></i> 
                  {{ $seller->location ?? 'Cambodia' }}
                </div>
                <div class="rating">
                  ⭐⭐⭐⭐☆ (4.5)
                </div>
                <a href="{{ url('seller/'.$seller->id) }}" class="btn-visit">
                  <i class="fa-solid fa-shop"></i> Visit Store
                </a>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-muted">No sellers found.</p>
        @endforelse
      </div>
    </div>
  </section>

  @include('home.footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
