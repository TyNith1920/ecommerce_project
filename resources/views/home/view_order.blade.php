<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ព័ត៌មានបញ្ជា - LFC Shop</title>

    {{-- Bootstrap & FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #136b51ff, #c4e6dbff);
            font-family: 'Poppins', sans-serif;
        }

        .order-container {
            padding: 90px 15px 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .order-card {
            max-width: 650px;
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.18);
            transition: all 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.25);
        }

        /* image block */
        .order-img-wrap {
            background: radial-gradient(circle at top, #e0f2fe, #e5e7eb);
            padding: 18px 0 8px;
            display: flex;
            justify-content: center;
        }

        .order-img {
            width: 100%;
            max-width: 260px;
            /* 👉 រូបមិនធំពេកទៀត */
            height: auto;
            object-fit: contain;
            border-radius: 18px;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.25);
        }

        .order-body {
            padding: 22px 24px 26px;
            text-align: center;
        }

        .order-body h3 {
            font-weight: 700;
            color: #0d6efd;
            font-size: 1.4rem;
            margin-bottom: 4px;
        }

        .price {
            color: #198754;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .badge {
            font-size: 0.82rem;
            padding: 7px 12px;
            border-radius: 20px;
        }

        .order-info {
            text-align: left;
            margin-top: 20px;
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .order-info strong {
            color: #0d6efd;
            min-width: 120px;
            display: inline-block;
        }

        .btn-back {
            margin-top: 26px;
            border-radius: 999px;
            font-weight: 600;
            padding: 9px 24px;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .btn-back i {
            margin-right: 6px;
        }

        .btn-back:hover {
            background-color: #0d6efd;
            color: white;
        }

        @media (max-width: 576px) {
            .order-card {
                border-radius: 18px;
            }

            .order-body {
                padding: 18px 16px 22px;
            }

            .order-img {
                max-width: 210px;
            }
        }
    </style>
</head>

<body>

    {{-- Header --}}
    @include('home.header')

    <section class="order-container">
        <div class="order-card">

            <div class="order-img-wrap">
                <img src="{{ asset('products/'.$order->product->image) }}"
                    class="order-img"
                    alt="{{ $order->product->title }}">
            </div>

            <div class="order-body">
                <h3>{{ $order->product->title }}</h3>
                <p class="price">${{ $order->product->price }}</p>

                <p class="mt-2">
                    <strong>ស្ថានភាព៖</strong>
                    @if(strtolower($order->status) == 'delivery')
                    <span class="badge bg-success">
                        <i class="fa-solid fa-truck"></i> បានដឹកជញ្ជូនរួច
                    </span>
                    @elseif(strtolower($order->status) == 'in progress')
                    <span class="badge bg-warning text-dark">
                        <i class="fa-solid fa-hourglass-half"></i> កំពុងដំណើរការ
                    </span>
                    @else
                    <span class="badge bg-secondary">
                        <i class="fa-solid fa-clock"></i> កំពុងរង់ចាំ
                    </span>
                    @endif
                </p>

                <div class="order-info">
                    <p><strong>លេខបញ្ជា:</strong> #{{ $order->id }}</p>
                    <p><strong>បរិមាណ:</strong> {{ $order->quantity ?? 1 }}</p>
                    <p><strong>តម្លៃសរុប:</strong> ${{ $order->product->price * ($order->quantity ?? 1) }}</p>
                    <p><strong>កាលបរិច្ឆេទបញ្ជា:</strong> {{ $order->created_at->format('d-M-Y - h:i A') }}</p>
                </div>

                <a href="{{ url('/myorders') }}" class="btn btn-outline-primary btn-back">
                    <i class="fa-solid fa-arrow-left"></i> ត្រឡប់ទៅវិញ
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    @include('home.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>