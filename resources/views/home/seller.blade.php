<!DOCTYPE html>
<html lang="km">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $seller->name }} - ហាងលក់ផលិតផល</title>
  @include('home.css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom right, #1f8a70, #33b9a5, #80d6c4, #b9ebe0, #e8f6f2);
      font-family: 'Battambang', 'Poppins', sans-serif;
      min-height: 100vh;
    }

    /* ===== Header Card ===== */
    .seller-header {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 18px rgba(0,0,0,0.1);
      padding: 30px;
      margin-bottom: 40px;
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .seller-header img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #0d6efd;
    }

    .seller-info h2 {
      font-weight: 700;
      color: #111827;
      margin-bottom: 6px;
    }

    .seller-info p {
      margin: 2px 0;
      color: #374151;
    }

    .rating {
      color: #facc15;
      font-weight: 600;
    }

    /* ===== Product Section ===== */
    .product-section h3 {
      text-align: center;
      font-weight: 700;
      color: #0d6efd;
      margin-bottom: 25px;
      text-shadow: 0 0 10px rgba(13,110,253,0.15);
    }

    .product-card {
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
      transition: 0.3s;
      text-align: center;
      height: 100%;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .product-title {
      font-weight: 600;
      margin-top: 8px;
      color: #111827;
    }

    .product-price {
      color: #e11d48;
      font-weight: 700;
    }

    .btn-buy {
      background: #f97316;
      color: #fff;
      border-radius: 8px;
      padding: 6px 14px;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
    }

    .btn-buy:hover {
      background: #ea580c;
    }

    @media (max-width: 768px) {
      .seller-header {
        flex-direction: column;
        text-align: center;
      }
      .seller-header img {
        width: 120px;
        height: 120px;
      }
    }
  </style>
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <section class="container py-5">
    <!-- Header -->
    <div class="seller-header">
      <img src="{{ asset('sellers/'.$seller->image ?? 'default_seller.jpg') }}" alt="{{ $seller->name }}">
      <div class="seller-info">
        <h2>{{ $seller->name }}</h2>
        <p><i class="fa-solid fa-location-dot text-danger"></i> {{ $seller->location ?? 'ប្រទេសកម្ពុជា' }}</p>
        <p><i class="fa-solid fa-envelope text-primary"></i> {{ $seller->email ?? 'មិនមានអ៊ីមែល' }}</p>
        <p class="rating">⭐⭐⭐⭐☆ (4.5/5)</p>
        <p class="text-muted">{{ $seller->description ?? 'ហាងនេះកំពុងលក់ផលិតផលគុណភាពល្អ និងមានសេវាកម្មល្អបំផុត។' }}</p>
      </div>
    </div>

    <!-- Product List -->
    <div class="product-section">
      <h3>ផលិតផលរបស់ {{ $seller->name }}</h3>
      <div class="row g-4">
        @forelse($products as $product)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card">
              <img src="{{ asset('products/'.$product->image) }}" alt="{{ $product->title }}">
              <div class="p-3">
                <div class="product-title">{{ $product->title }}</div>
                <div class="product-price">${{ $product->discount_price ?? $product->price }}</div>
                <a href="{{ url('product_details', $product->id) }}" class="btn-buy mt-2">🛒 មើលផលិតផល</a>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-muted">ហាងនេះមិនទាន់មានផលិតផលឡើយ។</p>
        @endforelse
      </div>
    </div>
  </section>

  @include('home.footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
