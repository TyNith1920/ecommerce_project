<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - LFC Shop</title>

    {{-- CSS របស់ project --}}
    @include('home.css')

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* 🌈 LFCShop Gradient Background */
        body {
            background: linear-gradient(to bottom, #1f8a70, #33b9a5, #80d6c4, #b9ebe0, #e8f6f2);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        /* 📦 Orders Section */
        .orders-section {
            padding: 60px 0;
        }

        .orders-title {
            font-weight: 700;
            font-size: 1.9rem;
            color: #0d6efd;
            text-align: center;
            margin-bottom: 40px;
            text-shadow:
                0 0 10px rgba(13, 110, 253, 0.3),
                0 0 20px rgba(13, 110, 253, 0.2);
            letter-spacing: 0.5px;
        }

        /* 🧱 Order Cards */
        .order-card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e3e6ec;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
            transition: all 0.28s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .order-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.22);
        }

        .order-img-wrapper {
            position: relative;
            background: radial-gradient(circle at top, #e0f2fe, #e5e7eb);
        }

        .order-img {
            height: 190px;
            width: 100%;
            object-fit: cover;
        }

        .order-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.8);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .card-body {
            background-color: #fff;
            padding: 14px 12px 16px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-weight: 600;
            font-size: 0.98rem;
            margin-bottom: 4px;
            color: #111827;
        }

        .price {
            color: #0f9d58;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .status {
            margin-top: 4px;
            font-size: 0.8rem;
        }

        .badge {
            border-radius: 999px;
            font-size: 0.73rem;
            padding: 6px 11px;
        }

        .progress {
            height: 5px;
            border-radius: 10px;
            margin-top: 6px;
            background-color: #e5e7eb;
        }

        .progress-bar {
            border-radius: 10px;
        }

        .btn-view {
            margin-top: 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            padding: 6px 14px;
            transition: all 0.25s ease;
        }

        .btn-view i {
            margin-right: 4px;
        }

        .btn-view:hover {
            background-color: #0d6efd;
            color: white;
            transform: translateY(-1px) scale(1.04);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.4);
        }

        .no-order-box {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 18px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.16);
        }

        .no-order-box p {
            margin: 0;
        }

        /* 🧾 Responsive */
        @media (max-width: 575px) {
            .order-img {
                height: 150px;
            }

            .orders-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="hero_area">
        {{-- 🧭 Header --}}
        @include('home.header')

        {{-- 📦 Orders Section --}}
        <section class="orders-section">
            <div class="container">
                <h2 class="orders-title">
                    <i class="fa-solid fa-box-open"></i> My Orders
                </h2>

                @if($order->count() == 0)
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="no-order-box">
                            <div class="fs-1 mb-2">😅</div>
                            <h5 class="mb-2">មិនទាន់មានការកម្មង់ទេ</h5>
                            <p class="text-muted mb-3">
                                ចូលទៅកាន់​ទំព័រ​ shop ដើម្បីជ្រើសរើសអាវកីឡាដែលបងចូលចិត្ត។
                            </p>
                            <a href="{{ url('shop') }}" class="btn btn-primary rounded-pill px-4">
                                ចាប់ផ្តើម Shopping 🛒
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="row g-3 justify-content-center">
                    {{-- កុំប្រើ $order ជា collection & item ដូចគ្នា --}}
                    @foreach($order as $order)
                    @if($order->product)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-flex">
                        <div class="order-card w-100">
                            <div class="order-img-wrapper">
                                <img src="{{ asset('products/' . $order->product->image) }}"
                                    class="order-img"
                                    alt="{{ $order->product->title }}">
                                <span class="order-tag">
                                    {{ $order->product->category ?? 'Jersey' }}
                                </span>
                            </div>

                            <div class="card-body">
                                <div>
                                    <h6 class="card-title">{{ $order->product->title }}</h6>
                                    <p class="price">${{ $order->product->price }}</p>

                                    @php $status = strtolower($order->status); @endphp

                                    @if($status == 'delivery')
                                    <span class="badge bg-success status">
                                        <i class="fa-solid fa-truck"></i> Delivered
                                    </span>
                                    <div class="progress mt-1">
                                        <div class="progress-bar bg-success" style="width:100%"></div>
                                    </div>

                                    @elseif($status == 'in progress')
                                    <span class="badge bg-warning text-dark status">
                                        <i class="fa-solid fa-hourglass-half"></i> In Progress
                                    </span>
                                    <div class="progress mt-1">
                                        <div class="progress-bar bg-warning" style="width:60%"></div>
                                    </div>

                                    @else
                                    <span class="badge bg-secondary status">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                    <div class="progress mt-1">
                                        <div class="progress-bar bg-secondary" style="width:30%"></div>
                                    </div>
                                    @endif
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('orders.view', $order->id) }}"
                                        class="btn btn-outline-primary btn-view">
                                        <i class="fa-solid fa-eye"></i> មើលព័ត៌មាន
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
        </section>
    </div>

    {{-- 🦶 Footer --}}
    @include('home.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>