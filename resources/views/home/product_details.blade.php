{{-- resources/views/home/product_details.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  @include('home.css')
  <title>{{ $data->title }} - Product Details</title>

  {{-- OwlCarousel (needs jQuery) --}}
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    integrity="sha512-tS3jnBOZ2xZkG2v4v7K9b1m9FvQG9c0oQk8mWg6m6bqgJ0iQqv8k0pQXb4g1G2b0vQbq0bP4GZ3o0P8QztK5PA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e40af;
      --accent: #f97316;
      --text: #111827;
      --sub: #4b5563;
      --muted: #9ca3af;
      --bg: #f3f4f6;
      --card: #ffffff;
      --line: #e5e7eb;
      --success: #16a34a;
      --danger: #e11d48;
    }

    body {
      background: linear-gradient(to bottom, #1f8a70, #33b9a5, #80d6c4, #b9ebe0, #e8f6f2);
      background-attachment: fixed;
      min-height: 100vh;
      font-family: 'Poppins', system-ui, -apple-system, sans-serif;
    }

    /* === SHELL === */
    .page-card {
      background: var(--card);
      border-radius: 14px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
      padding: 30px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: 1.1fr 1.1fr .8fr;
      gap: 28px;
      align-items: start;
    }

    /* === LEFT: GALLERY === */
    .gallery {
      position: relative;
    }

    .main-img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
      transition: .25s;
    }

    .main-img:hover {
      transform: scale(1.02)
    }

    .thumbs {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 12px
    }

    .thumb {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border: 1px solid var(--line);
      border-radius: 8px;
      cursor: pointer;
      transition: .2s
    }

    .thumb:hover {
      border-color: var(--primary);
      transform: scale(1.08)
    }

    /* === CENTER: DETAILS === */
    .title {
      font-size: 28px;
      font-weight: 700;
      color: var(--text);
      margin: 0 0 8px
    }

    .pricebox {
      font-size: 22px;
      margin: 10px 0 14px
    }

    .price-now {
      color: var(--danger);
      font-weight: 700;
      margin-right: 10px
    }

    .price-old {
      color: #888;
      margin-right: 10px
    }

    .save {
      color: var(--success);
      font-weight: 600
    }

    .meta p {
      margin: .2rem 0;
      color: #374151
    }

    .opt-row {
      display: flex;
      gap: 14px;
      align-items: center;
      margin: 14px 0
    }

    .select,
    .qty {
      padding: 9px 12px;
      border: 1px solid #d1d5db;
      border-radius: 8px
    }

    .actions {
      display: flex;
      gap: 12px;
      margin-top: 16px
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: none;
      border-radius: 8px;
      padding: 12px 20px;
      font-weight: 600;
      cursor: pointer;
      transition: .25s;
      text-decoration: none
    }

    .btn-primary {
      background: var(--primary);
      color: #fff
    }

    .btn-primary:hover {
      background: var(--primary-dark)
    }

    .btn-accent {
      background: var(--accent);
      color: #fff
    }

    .btn-accent:hover {
      filter: brightness(.95)
    }

    .shipping {
      margin-top: 18px;
      color: var(--sub);
      border-top: 1px solid var(--line);
      padding-top: 12px
    }

    .mini-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: .35rem 0
    }

    /* === RIGHT: SELLER === */
    .seller {
      background: #f9fafb;
      border-radius: 12px;
      padding: 18px;
      box-shadow: 0 3px 14px rgba(0, 0, 0, .06);
      transition: .25s
    }

    .seller:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(0, 0, 0, .10)
    }

    .seller h4 {
      margin: 0 0 10px;
      font-weight: 700;
      color: var(--text)
    }

    .seller p {
      margin: .25rem 0;
      color: #374151
    }

    .btn-outline {
      display: inline-block;
      background: var(--primary);
      color: #fff;
      padding: 8px 14px;
      border-radius: 8px;
      text-decoration: none
    }

    .btn-outline:hover {
      background: var(--primary-dark)
    }

    /* === TABS === */
    .nav-tabs {
      border-bottom: 2px solid var(--line)
    }

    .nav-tabs .nav-link {
      color: #4b5563;
      font-weight: 600
    }

    .nav-tabs .nav-link.active {
      color: var(--primary);
      border-color: var(--primary) var(--primary) transparent
    }

    .tab-card {
      background: var(--card);
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
      padding: 18px
    }

    /* === RELATED === */
    .related h3 {
      font-weight: 700;
      text-align: center;
      margin: 28px 0 14px
    }

    .product-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 12px;
      text-align: center;
      transition: .25s
    }

    .product-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 24px rgba(0, 0, 0, .08)
    }

    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px
    }

    .price-mini {
      color: var(--danger);
      font-weight: 700
    }

    /* === STICKY BAR === */
    .sticky-bar {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #fff;
      border-top: 1px solid var(--line);
      box-shadow: 0 -6px 18px rgba(0, 0, 0, .06);
      padding: 10px 0;
      z-index: 999
    }

    .sticky-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px
    }

    .sticky-title {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 60vw
    }

    @media (max-width: 992px) {
      .product-grid {
        grid-template-columns: 1fr
      }

      .sticky-title {
        max-width: 50vw
      }
    }
  </style>
</head>

<body>
  <div class="hero_area">@include('home.header')</div>

  <section class="shop_section layout_padding">
    <div class="container">

      <div class="heading_container heading_center mb-4">
        <h2>PRODUCT DETAILS</h2>
      </div>

      <div class="page-card">
        <div class="product-grid">
          {{-- LEFT: GALLERY --}}
          <div class="gallery">
            @php $gallery = $data->images ?? collect(); @endphp
            <img id="mainImage" class="main-img"
              src="{{ asset('products/'.$data->image) }}" alt="{{ $data->title }}">
            @if($gallery->count())
            <div class="thumbs">
              @foreach($gallery as $g)
              <img class="thumb" src="{{ asset('products/gallery/'.$g->image) }}" alt="thumb"
                onclick="document.getElementById('mainImage').src=this.src">
              @endforeach
            </div>
            @endif
          </div>

          {{-- CENTER: DETAILS --}}
          <div>
            <h1 class="title">{{ $data->title }}</h1>

            <div class="pricebox">
              @if($data->discount_price)
              <span class="price-now">${{ number_format($data->discount_price,2) }}</span>
              <del class="price-old">${{ number_format($data->price,2) }}</del>
              <span class="save">
                Save {{ round((($data->price - $data->discount_price) / max(1,$data->price)) * 100) }}%
              </span>
              @else
              <span class="price-now">${{ number_format($data->price,2) }}</span>
              @endif
            </div>

            <div class="meta">
              <p><strong>Category:</strong> {{ $data->category }}</p>
              <p><strong>Available Quantity:</strong> {{ $data->quantity }}</p>
            </div>

            <form action="{{ url('add_to_cart', $data->id) }}" method="POST" class="mt-2">
              @csrf
              <div class="opt-row">
                <label class="fw-semibold">Size:</label>
                <select name="size" class="select" required>
                  <option value="S">S</option>
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                  <option value="XXL">XXL</option>
                </select>
              </div>

              <div class="opt-row">
                <label class="fw-semibold">Quantity:</label>
                <input type="number" name="quantity" value="1" min="1" max="{{ $data->quantity }}" class="qty">
              </div>

              <div class="actions">
                <button type="submit" class="btn btn-primary">
                  <span>🛒</span> Add to Cart
                </button>
                {{-- Buy Now can be GET or POST based on your route; sample GET below --}}
                <a href="{{ url('buy_now', $data->id) }}" class="btn btn-accent">⚡ Buy Now</a>
              </div>
            </form>

            <div class="shipping">
              <div class="mini-row">🚚 Free Shipping on orders over $50</div>
              <div class="mini-row">↩️ 7-day easy return policy</div>
            </div>
          </div>

          {{-- RIGHT: SELLER --}}
          <aside class="seller">
            <h4>Seller Information</h4>
            <p><strong>Store:</strong> {{ $data->seller_name ?? 'Official Store' }}</p>
            <p><strong>Rating:</strong> ⭐⭐⭐⭐☆ (4.5/5)</p>
            <a class="btn-outline" href="{{ url('seller/'.$data->seller_id) }}">Visit Store</a>
          </aside>
        </div>
      </div>

      {{-- TABS --}}
      <ul class="nav nav-tabs mt-5" id="productTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#desc">Description</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#spec">Specification</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews</a></li>
      </ul>

      <div class="tab-content mt-3 tab-card">
        <div class="tab-pane fade show active" id="desc">
          <p class="mb-0">{{ $data->description }}</p>
        </div>
        <div class="tab-pane fade" id="spec">
          <ul class="mb-0">
            <li><strong>Brand:</strong> {{ $data->brand ?? 'N/A' }}</li>
            <li><strong>Material:</strong> {{ $data->material ?? 'N/A' }}</li>
            <li><strong>Color:</strong> {{ $data->color ?? 'N/A' }}</li>
            <li><strong>Sizes:</strong> S / M / L / XL / XXL</li>
          </ul>
        </div>
        <div class="tab-pane fade" id="reviews">
          <h6 class="mb-2">Customer Reviews</h6>
          <p class="text-muted mb-0">No reviews yet. Be the first to review!</p>
        </div>
      </div>

      {{-- RELATED PRODUCTS CAROUSEL --}}
      <div class="related">
        <h3>Related Products</h3>
        <div class="owl-carousel" id="relatedCarousel">
          @foreach(($relatedProducts ?? collect()) as $item)
          <div class="product-card">
            <img src="{{ asset('products/'.$item->image) }}" alt="{{ $item->title }}">
            <div class="mt-2 fw-semibold">{{ $item->title }}</div>
            <div class="price-mini">{{ $item->discount_price ? '$'.number_format($item->discount_price,2) : '$'.number_format($item->price,2) }}</div>
            <a class="btn btn-primary mt-2" style="padding:8px 14px"
              href="{{ url('product_details', $item->id) }}">View</a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- Sticky bar (optional) --}}
  <div class="sticky-bar">
    <div class="container sticky-inner">
      <div class="sticky-title">
        <strong>{{ $data->title }}</strong> —
        <span class="price-mini">
          {{ $data->discount_price ? '$'.number_format($data->discount_price,2) : '$'.number_format($data->price,2) }}
        </span>
      </div>
      <div class="d-flex gap-2">
        {{-- Use POST for add_to_cart in sticky as well --}}
        <form action="{{ url('add_to_cart', $data->id) }}" method="POST">
          @csrf
          <input type="hidden" name="size" value="M">
          <input type="hidden" name="quantity" value="1">
          <button class="btn btn-primary">🛒 Add to Cart</button>
        </form>
        <a href="{{ url('buy_now', $data->id) }}" class="btn btn-accent">⚡ Buy Now</a>
      </div>
    </div>
  </div>

  @include('home.footer')

  {{-- JS: jQuery (for OwlCarousel), Bootstrap, Owl --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI1QGYa+Yszm2M3e9GZrGtbT3YHcCwZ1nV0Wf6M8K/7nO4xN7i2Y5x7v0QfQpQ5i3rVA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-3fP3p7nq8m4kV7fS3f3cWzH0Wq1+5k6m8m9vH9z4i7JpZ2+0f5o2F3oA8m1wWQqS1o3S7k0rGqIBQ7fK9J3U5w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(function() {
      $('#relatedCarousel').owlCarousel({
        loop: true,
        margin: 14,
        dots: true,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
          0: {
            items: 1
          },
          576: {
            items: 2
          },
          768: {
            items: 3
          },
          1200: {
            items: 4
          }
        }
      });
    });
  </script>
</body>

</html>