<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LFCShop | Products</title>

  {{-- Include global CSS --}}
  @include('home.css')

  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- 🌈 Custom Shop Theme -->
  <style>
    /* ===== Custom Shop Theme ===== */
    body {
      font-family: "Poppins", "Battambang", sans-serif;
    }

    .shop_section {
      background: linear-gradient(180deg, #0F6B63 0%, #2F8F84 50%, #4FA7A5 100%);
      color: #fff;
      min-height: 100vh;
    }

    /* Sidebar */
    .shop_section aside form {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      border-radius: 14px;
      color: #fff;
    }

    .shop_section aside form label,
    .shop_section aside form h5,
    .shop_section aside form .text-muted {
      color: #fff !important;
    }

    .shop_section input,
    .shop_section select {
      background: rgba(255, 255, 255, 0.9);
      color: #0F6B63;
      border: none;
      border-radius: 6px;
    }

    /* Product cards */
    .product-card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.85));
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
      transition: all 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
    }

    .hover-zoom {
      transition: transform 0.35s ease;
    }

    .product-card:hover .hover-zoom {
      transform: scale(1.05);
    }

    .product-card h6 {
      color: #0F6B63;
      font-weight: 700;
    }

    .text-price {
      color: #FFD43B;
      font-weight: 800;
    }

    .product-card .btn {
      border-radius: 10px;
      font-weight: 600;
      transition: 0.2s;
    }

    .product-card .btn-outline-dark {
      color: #0F6B63;
      border-color: #0F6B63;
    }

    .product-card .btn-outline-dark:hover {
      background: #0F6B63;
      color: #fff;
    }

    .product-card .btn-primary {
      background: #FFD43B;
      border: none;
      color: #0F6B63;
      box-shadow: 0 0 12px rgba(255, 212, 59, 0.5);
    }

    .product-card .btn-primary:hover {
      background: #f5c518;
      transform: scale(1.05);
      box-shadow: 0 0 18px rgba(255, 212, 59, 0.7);
    }

    /* Section Title */
    .shop_section h2 {
      color: #FFD43B;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
      letter-spacing: 1px;
      font-weight: 800;
    }
  </style>
</head>

<body>
  {{-- ✅ Include Header --}}
  <div class="hero_area">
    @include('home.header')
  </div>

  @php
  use Illuminate\Support\Str;
  $categoriesCount = $categoriesCount ?? collect();
  @endphp

  {{-- ✅ Product Section --}}
  <section class="shop_section py-5">
    <div class="container">

      <!-- Heading -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">🛍️ PRODUCTS</h2>
      </div>

      <div class="row g-4">

        <!-- Sidebar -->
        <aside class="col-12 col-lg-3">
          <form action="{{ route('shop') }}" method="GET" class="p-3">
            <h5 class="mb-3 d-flex align-items-center gap-2">
              <i class="bi bi-funnel"></i> Filters
            </h5>

            <!-- Quick search -->
            <div class="mb-3">
              <label class="form-label small text-light">Search</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" name="q" value="{{ request('q') }}"
                  placeholder="Search products...">
              </div>
            </div>

            <!-- Categories -->
            <div class="mb-3">
              <div class="text-uppercase small fw-bold mb-2 text-light">Categories</div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="cat_all" value=""
                  @checked(!request('category'))>
                <label class="form-check-label" for="cat_all">All</label>
              </div>

              @forelse($categoriesCount as $row)
              @php $slug = \Illuminate\Support\Str::slug($row->category); @endphp
              <div class="form-check">
                <input class="form-check-input" type="radio" name="category"
                  id="cat_{{ $slug }}" value="{{ $row->category }}"
                  @checked(request('category')===$row->category)>
                <label class="form-check-label" for="cat_{{ $slug }}">
                  {{ $row->category }} <span class="text-light">({{ $row->cnt }})</span>
                </label>
              </div>
              @empty
              <div class="text-light small">No categories</div>
              @endforelse
            </div>

            <!-- Price -->
            <div class="mb-3">
              <div class="text-uppercase small fw-bold mb-2 text-light">Price Range</div>
              <div class="row g-2">
                <div class="col-6">
                  <input type="number" name="min" step="0.01" min="0" class="form-control"
                    placeholder="Min" value="{{ request('min') }}">
                </div>
                <div class="col-6">
                  <input type="number" name="max" step="0.01" min="0" class="form-control"
                    placeholder="Max" value="{{ request('max') }}">
                </div>
              </div>
            </div>

            <!-- On Sale -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="only_discount"
                name="only_discount" value="1"
                @checked(request()->boolean('only_discount'))>
              <label class="form-check-label" for="only_discount">On Sale</label>
            </div>

            <!-- Sort -->
            <div class="mb-3">
              <label class="form-label small text-light">Sort by</label>
              <select name="sort" class="form-select">
                <option value="newest" @selected(request('sort','newest')==='newest' )>Newest</option>
                <option value="price_asc" @selected(request('sort')==='price_asc' )>Price: Low → High</option>
                <option value="price_desc" @selected(request('sort')==='price_desc' )>Price: High → Low</option>
              </select>
            </div>

            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1">Apply</button>
              <a href="{{ route('shop') }}" class="btn btn-outline-light">Reset</a>
            </div>
          </form>
        </aside>

        <!-- Product Grid -->
        <section class="col-12 col-lg-9">
          <div class="text-light small mb-2">
            @if($products->total())
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
            @if(request('q')) for “<strong>{{ e(request('q')) }}</strong>” @endif
            @else
            0 result
            @endif
          </div>

          <div class="row">
            @forelse($products as $p)
            @php
            $gallery = is_array($p->gallery) ? $p->gallery : (json_decode($p->gallery ?? '[]', true) ?? []);
            $first = $gallery[0] ?? null;
            $rel = $first ? 'products/'.$first : ($p->image ? 'products/'.$p->image : 'images/no-image.png');
            $exists = file_exists(public_path($rel));
            $imgUrl = $exists ? asset($rel) : asset('images/no-image.png');
            @endphp

            <div class="col-sm-6 col-lg-4 mb-4">
              <div class="card h-100 text-center border-0 product-card">
                <a href="{{ url('product_details', $p->id) }}" class="text-decoration-none text-dark">
                  <img src="{{ $imgUrl }}" alt="{{ $p->title }}" class="card-img-top hover-zoom"
                    style="height:220px;object-fit:contain;background:#f9f9f9;">
                  <div class="card-body">
                    <h6>{{ $p->title }}</h6>
                    <p class="mb-1">
                      <span class="text-secondary">Price:</span>
                      @if($p->discount_price && $p->discount_price < $p->price)
                        <span class="text-danger fw-bold">${{ number_format($p->discount_price,2) }}</span>
                        <del class="text-muted ms-1">${{ number_format($p->price,2) }}</del>
                        @else
                        <span class="fw-bold">${{ number_format($p->price,2) }}</span>
                        @endif
                    </p>
                    <div class="small text-muted">{{ $p->category ?? 'Uncategorized' }}</div>
                  </div>
                </a>
                <div class="card-footer bg-transparent border-0 pb-3">
                  <a href="{{ url('product_details', $p->id) }}" class="btn btn-outline-dark btn-sm me-2">Details</a>
                  <a href="{{ url('add_to_cart', $p->id) }}" class="btn btn-primary btn-sm">Add to Cart</a>
                </div>
              </div>
            </div>
            @empty
            <div class="text-center text-light py-5">
              <h5>No products found.</h5>
            </div>
            @endforelse
          </div>

          <div class="d-flex justify-content-center mt-2">
            {{ $products->onEachSide(1)->links() }}
          </div>
        </section>
      </div>
    </div>
  </section>

  {{-- ✅ Include Footer --}}
  @include('home.footer')

  {{-- 💖 Wishlist Script --}}
  <script>
    (function() {
      async function toggleWishlist(productId, btn) {
        try {
          const res = await fetch("{{ route('wishlist.toggle') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              product_id: productId
            })
          });
          const data = await res.json();
          if (data.ok) {
            if (data.action === 'added') {
              btn.classList.add('active');
              btn.innerHTML = '<i class="bi bi-heart-fill"></i>';
            } else {
              btn.classList.remove('active');
              btn.innerHTML = '<i class="bi bi-heart"></i>';
            }
          }
        } catch (e) {
          console.error(e);
        }
      }

      document.addEventListener('click', function(e) {
        const btn = e.target.closest('.wishlist-btn');
        if (!btn) return;
        e.preventDefault();
        toggleWishlist(btn.dataset.productId, btn);
      });
    })();
  </script>
</body>

</html>