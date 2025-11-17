<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Result | LFCShop</title>

    <style>
        body {
            font-family: "Poppins", "Battambang", sans-serif;
            background: linear-gradient(180deg, #0F6B63, #4FA7A5, #A2D3D6);
            color: #fff;
            text-align: center;
            padding: 100px 20px;
        }
        .card {
            max-width: 500px;
            background: rgba(255,255,255,0.1);
            margin: auto;
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .success-icon {
            font-size: 80px;
            color: #00ff99;
        }
        .fail-icon {
            font-size: 80px;
            color: #ff4c4c;
        }
        h1 {
            font-size: 28px;
            margin-top: 10px;
        }
        p {
            font-size: 18px;
            color: #eee;
        }
        .btn {
            margin-top: 20px;
            display: inline-block;
            background-color: #FFD43B;
            color: #000;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn:hover {
            background: #ffca00;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    @include('home.header')

    <div class="card">
        @if ($status === '0' || strtolower($status) === 'success')
            <div class="success-icon">✅</div>
            <h1>Payment Successful</h1>
            <p>សូមអរគុណ! ការបង់ប្រាក់របស់បងត្រូវបានបញ្ចប់ដោយជោគជ័យ។</p>
            <p><strong>Transaction ID:</strong> {{ $tranId }}</p>
        @else
            <div class="fail-icon">❌</div>
            <h1>Payment Failed</h1>
            <p>សូមអភ័យទោស ប៉ុន្តែការបង់ប្រាក់របស់បងបរាជ័យ។</p>
            <p><strong>Transaction ID:</strong> {{ $tranId ?? 'N/A' }}</p>
        @endif

        <a href="{{ url('/') }}" class="btn">🏠 Back to Home</a>
    </div>

    @include('home.footer')
</body>
</html>
